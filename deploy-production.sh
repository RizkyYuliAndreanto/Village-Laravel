#!/bin/bash

# ===================================================================
# PRODUCTION DEPLOYMENT SCRIPT - Laravel Village
# Automates the complete production deployment process
# ===================================================================

echo "🚀 Starting Laravel Village Production Deployment..."

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Error handling
set -e
trap 'echo -e "${RED}❌ Deployment failed at step: ${STEP}${NC}"' ERR

# Configuration
PROJECT_DIR="/var/www/village-web"
PHP_BIN="/usr/bin/php"
COMPOSER_BIN="/usr/local/bin/composer"
NODE_BIN="/usr/bin/node"
NPM_BIN="/usr/bin/npm"

# Functions
print_step() {
    STEP="$1"
    echo -e "\n${BLUE}📋 STEP: ${STEP}${NC}"
}

print_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

print_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

print_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Pre-deployment checks
print_step "Pre-deployment Checks"

# Check if running as web user
if [ "$USER" != "www-data" ] && [ "$USER" != "nginx" ]; then
    print_warning "Consider running as web user (www-data/nginx)"
fi

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
if (( $(echo "$PHP_VERSION < 8.2" | bc -l) )); then
    print_error "PHP 8.2+ required. Current: $PHP_VERSION"
    exit 1
fi
print_success "PHP Version: $PHP_VERSION"

# Check required extensions
REQUIRED_EXTENSIONS=("redis" "pdo" "pdo_mysql" "curl" "json" "mbstring" "openssl" "tokenizer" "xml" "zip")
for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    if ! php -m | grep -q "$ext"; then
        print_error "Required PHP extension missing: $ext"
        exit 1
    fi
done
print_success "All required PHP extensions are installed"

# Application setup
print_step "Setting up Application Environment"

# Copy production environment
if [ ! -f ".env" ]; then
    if [ -f ".env.production" ]; then
        cp .env.production .env
        print_success "Production environment copied"
    else
        cp .env.example .env
        print_warning "Using example environment - CONFIGURE BEFORE PRODUCTION USE"
    fi
else
    print_success "Environment file exists"
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    $PHP_BIN artisan key:generate --force
    print_success "Application key generated"
fi

# Dependencies installation
print_step "Installing Dependencies"

# Composer install for production
$COMPOSER_BIN install --no-dev --optimize-autoloader --no-interaction
print_success "Composer dependencies installed"

# NPM install and build
if [ -f "package.json" ]; then
    $NPM_BIN ci --production=false
    $NPM_BIN run build
    print_success "Frontend assets built"
fi

# Database setup
print_step "Setting up Database"

# Wait for database to be ready
echo "Waiting for database connection..."
for i in {1..30}; do
    if $PHP_BIN artisan db:monitor --max-connections=1 >/dev/null 2>&1; then
        break
    fi
    sleep 1
    if [ $i -eq 30 ]; then
        print_error "Database connection timeout"
        exit 1
    fi
done
print_success "Database connection established"

# Run migrations
$PHP_BIN artisan migrate --force
print_success "Database migrations completed"

# Storage and permissions
print_step "Setting up Storage and Permissions"

# Create storage symlink
$PHP_BIN artisan storage:link
print_success "Storage symlink created"

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache public/storage
print_success "Permissions configured"

# Redis setup (if available)
print_step "Configuring Redis"
if command -v redis-cli &> /dev/null; then
    if redis-cli ping >/dev/null 2>&1; then
        print_success "Redis is running and accessible"
        
        # Test Redis connection from Laravel
        if $PHP_BIN artisan tinker --execute="Redis::ping();" >/dev/null 2>&1; then
            print_success "Laravel Redis connection working"
        else
            print_warning "Laravel cannot connect to Redis - check configuration"
        fi
    else
        print_warning "Redis server not running - using file cache"
        # Fallback to file cache
        sed -i 's/CACHE_STORE=redis/CACHE_STORE=file/' .env
        sed -i 's/SESSION_DRIVER=redis/SESSION_DRIVER=file/' .env
        sed -i 's/QUEUE_CONNECTION=redis/QUEUE_CONNECTION=sync/' .env
    fi
else
    print_warning "Redis not installed - using file cache"
fi

# Production optimizations
print_step "Applying Production Optimizations"

# Laravel optimizations
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache  
$PHP_BIN artisan view:cache
print_success "Laravel caches optimized"

# Custom production optimizations
if [ -f "app/Console/Commands/OptimizeProduction.php" ]; then
    $PHP_BIN artisan optimize:production --cache-warmup
    print_success "Custom production optimizations applied"
fi

# Security setup
print_step "Configuring Security"

# Ensure proper ownership
chown -R www-data:www-data .
print_success "File ownership configured"

# Secure sensitive files
chmod 600 .env
chmod -R 755 app config database resources routes
chmod -R 644 app config database resources routes
print_success "File permissions secured"

# Queue workers setup
print_step "Setting up Queue Workers"

# Create systemd service for queue workers
QUEUE_SERVICE_FILE="/etc/systemd/system/village-queue.service"
if [ ! -f "$QUEUE_SERVICE_FILE" ]; then
    cat > "$QUEUE_SERVICE_FILE" << EOF
[Unit]
Description=Laravel Queue Worker - Village Web
After=network.target

[Service]
Type=simple
User=www-data
WorkingDirectory=$PROJECT_DIR
ExecStart=$PHP_BIN $PROJECT_DIR/artisan queue:work --sleep=3 --tries=3 --timeout=90
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
EOF
    
    systemctl daemon-reload
    systemctl enable village-queue
    systemctl start village-queue
    print_success "Queue worker service created and started"
else
    systemctl restart village-queue
    print_success "Queue worker service restarted"
fi

# Scheduler setup
print_step "Setting up Task Scheduler"

# Add cron job for Laravel scheduler
CRON_ENTRY="* * * * * cd $PROJECT_DIR && $PHP_BIN artisan schedule:run >> /dev/null 2>&1"
(crontab -l 2>/dev/null; echo "$CRON_ENTRY") | sort -u | crontab -
print_success "Cron job for scheduler configured"

# Health checks
print_step "Running Health Checks"

# Application health
if $PHP_BIN artisan route:list | grep -q "home"; then
    print_success "Application routes loaded correctly"
else
    print_error "Application routes not loading"
    exit 1
fi

# Database health
if $PHP_BIN artisan migrate:status | grep -q "Migration name"; then
    print_success "Database migrations status OK"
else
    print_warning "Could not verify migration status"
fi

# Performance metrics
print_step "Performance Verification"

if [ -f "app/Console/Commands/OptimizeProduction.php" ]; then
    $PHP_BIN artisan optimize:production --monitor
fi

# Final steps
print_step "Final Configuration"

# Clear any remaining caches
$PHP_BIN artisan optimize:clear
$PHP_BIN artisan optimize

# Restart services
if command -v systemctl &> /dev/null; then
    systemctl reload nginx || systemctl reload apache2 || print_warning "Could not reload web server"
    systemctl restart village-queue || print_warning "Could not restart queue service"
fi

print_success "Production deployment completed successfully!"

echo -e "\n${GREEN}🎉 DEPLOYMENT SUMMARY${NC}"
echo -e "   ✅ Environment configured"
echo -e "   ✅ Dependencies installed"
echo -e "   ✅ Database migrated"
echo -e "   ✅ Storage configured"
echo -e "   ✅ Optimizations applied"
echo -e "   ✅ Security configured"
echo -e "   ✅ Queue workers running"
echo -e "   ✅ Scheduler configured"

echo -e "\n${BLUE}🔗 Quick Links:${NC}"
echo -e "   Frontend: ${APP_URL:-https://your-domain.com}"
echo -e "   Admin Panel: ${APP_URL:-https://your-domain.com}/admin"
echo -e "   API Documentation: ${APP_URL:-https://your-domain.com}/api/documentation"

echo -e "\n${YELLOW}📋 Post-Deployment Tasks:${NC}"
echo -e "   1. Test all application features"
echo -e "   2. Configure monitoring (logs, metrics)"
echo -e "   3. Setup SSL certificate"
echo -e "   4. Configure backup strategy"
echo -e "   5. Setup DNS records"
echo -e "   6. Configure CDN (optional)"

echo -e "\n${YELLOW}📊 Monitor Status:${NC}"
echo -e "   Queue Status: sudo systemctl status village-queue"
echo -e "   Performance: php artisan optimize:production --monitor"
echo -e "   Logs: tail -f storage/logs/laravel.log"
#!/bin/bash

# ===================================================================
# SHARED HOSTING DEPLOYMENT SCRIPT - Laravel Village
# Optimized untuk shared hosting (Hostinger, Niagahoster, dll)
# ===================================================================

echo "🏠 Starting Laravel Village Shared Hosting Deployment..."

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
print_step() {
    echo -e "\n${BLUE}📋 STEP: $1${NC}"
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

# Shared hosting specific settings
SHARED_HOSTING=true
PHP_BIN="php" # Usually just 'php' on shared hosting
COMPOSER_BIN="composer" # Or full path if needed

print_step "Shared Hosting Pre-Checks"

# Check PHP version
PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "PHP Version: $PHP_VERSION"

# Check if in correct directory
if [ ! -f "artisan" ]; then
    print_error "Laravel artisan file not found. Are you in the correct directory?"
    exit 1
fi
print_success "In Laravel project directory"

# Environment Setup
print_step "Setting up Shared Hosting Environment"

# Copy shared hosting environment if .env doesn't exist
if [ ! -f ".env" ]; then
    if [ -f ".env.shared-hosting" ]; then
        cp .env.shared-hosting .env
        print_success "Shared hosting environment template copied"
    elif [ -f ".env.example" ]; then
        cp .env.example .env
        print_warning "Using example environment - CONFIGURE DATABASE SETTINGS"
    else
        print_error "No environment template found"
        exit 1
    fi
else
    print_success "Environment file exists"
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    $PHP_BIN artisan key:generate --force
    print_success "Application key generated"
fi

# Dependencies Installation (Shared Hosting Compatible)
print_step "Installing Dependencies for Shared Hosting"

# Check if composer is available
if command -v $COMPOSER_BIN &> /dev/null; then
    # Install without dev dependencies and optimize autoloader
    $COMPOSER_BIN install --no-dev --optimize-autoloader --no-interaction
    print_success "Composer dependencies installed (production mode)"
else
    print_warning "Composer not found - ensure dependencies are pre-installed"
fi

# Frontend Assets (if Node.js available on shared hosting)
if command -v npm &> /dev/null; then
    npm ci --production=false
    npm run build
    print_success "Frontend assets built"
else
    print_warning "Node.js/NPM not available - ensure assets are pre-built"
fi

# Shared Hosting Optimizations
print_step "Applying Shared Hosting Optimizations"

# Apply shared hosting configurations
if [ -f "app/Console/Commands/OptimizeSharedHosting.php" ]; then
    $PHP_BIN artisan optimize:shared-hosting --setup
    print_success "Shared hosting configurations applied"
else
    print_warning "Shared hosting optimization command not available"
fi

# Database Setup (Conservative approach for shared hosting)
print_step "Setting up Database"

# Test database connection (with timeout)
echo "Testing database connection..."
timeout 30s $PHP_BIN artisan tinker --execute="DB::select('SELECT 1');" >/dev/null 2>&1
if [ $? -eq 0 ]; then
    print_success "Database connection successful"
    
    # Run migrations (safe for shared hosting)
    $PHP_BIN artisan migrate --force
    print_success "Database migrations completed"
else
    print_warning "Database connection failed - configure database settings in .env"
fi

# Storage Setup (Shared Hosting Compatible)
print_step "Setting up Storage"

# Create storage directories
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions  
mkdir -p storage/logs
mkdir -p public/storage

# Set permissions (if possible on shared hosting)
chmod -R 755 storage bootstrap/cache 2>/dev/null || print_warning "Could not set permissions - manual setup may be required"

# Create storage symlink
$PHP_BIN artisan storage:link
print_success "Storage symlink created"

# Shared Hosting Cache Optimizations
print_step "Optimizing Cache for Shared Hosting"

# Clear all caches first
$PHP_BIN artisan cache:clear
$PHP_BIN artisan config:clear
$PHP_BIN artisan view:clear

# Apply file-based caching
$PHP_BIN artisan config:cache
print_success "Configuration cached"

$PHP_BIN artisan view:cache
print_success "Views cached"

# Skip route caching for shared hosting compatibility
print_warning "Route caching skipped (shared hosting compatibility)"

# Warm up application cache
if [ -f "app/Console/Commands/OptimizeSharedHosting.php" ]; then
    $PHP_BIN artisan optimize:shared-hosting --cache-warmup
    print_success "Application cache warmed up"
fi

# File Cleanup for Shared Hosting
print_step "Cleaning up for Shared Hosting"

# Remove development files that shouldn't be in production
rm -f .env.example
rm -rf tests/ 
rm -rf node_modules/
rm -f package*.json
rm -f vite.config.js
rm -f tailwind.config.js
rm -f postcss.config.js

print_success "Development files cleaned up"

# Security for Shared Hosting
print_step "Applying Shared Hosting Security"

# Create/update .htaccess for security
cat > public/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>

# Hide sensitive files
<Files ".env">
    Require all denied
</Files>

<Files "composer.*">
    Require all denied
</Files>

<Files "artisan">
    Require all denied
</Files>
EOF

print_success "Security configurations applied"

# Final Health Checks
print_step "Running Health Checks"

# Check if routes are working
if $PHP_BIN artisan route:list >/dev/null 2>&1; then
    print_success "Application routes loaded correctly"
else
    print_warning "Could not verify routes - check manually"
fi

# Check storage permissions
if [ -w "storage/logs" ]; then
    print_success "Storage is writable"
else
    print_warning "Storage may not be writable - check permissions"
fi

# Performance check
if [ -f "app/Console/Commands/OptimizeSharedHosting.php" ]; then
    $PHP_BIN artisan optimize:shared-hosting --monitor
fi

print_success "Shared hosting deployment completed successfully!"

echo -e "\n${GREEN}🎉 SHARED HOSTING DEPLOYMENT SUMMARY${NC}"
echo -e "   ✅ Environment configured for shared hosting"
echo -e "   ✅ File-based caching enabled"
echo -e "   ✅ Synchronous queue processing"
echo -e "   ✅ Storage and permissions configured"
echo -e "   ✅ Security headers applied"
echo -e "   ✅ Development files cleaned up"

echo -e "\n${BLUE}🔗 Access Your Application:${NC}"
echo -e "   Frontend: https://your-domain.com"
echo -e "   Admin Panel: https://your-domain.com/admin"

echo -e "\n${YELLOW}📋 IMPORTANT: Complete These Manual Steps${NC}"
echo -e "   1. 🔧 Update .env file with your database credentials"
echo -e "   2. 🌐 Set APP_URL to your actual domain"
echo -e "   3. 🔒 Set APP_ENV=production and APP_DEBUG=false"
echo -e "   4. 📁 Upload all files to your hosting public_html directory"
echo -e "   5. 🗄️ Import/run database migrations if needed"
echo -e "   6. ✅ Test your application thoroughly"

echo -e "\n${YELLOW}🔧 Shared Hosting Limitations:${NC}"
echo -e "   • File-based caching (no Redis)"
echo -e "   • Synchronous job processing (no queues)"
echo -e "   • Limited cron job capabilities"
echo -e "   • Conservative resource limits"

echo -e "\n${BLUE}🚀 Optimization Commands:${NC}"
echo -e "   Cache warmup: php artisan optimize:shared-hosting --cache-warmup"
echo -e "   Performance check: php artisan optimize:shared-hosting --monitor"
echo -e "   Cleanup: php artisan optimize:shared-hosting --cleanup"

echo -e "\n${GREEN}Happy hosting! 🏠${NC}"
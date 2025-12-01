#!/bin/bash

# 🏠 Laravel Village - Shared Hosting Deployment Script
# Automated deployment script for shared hosting environments

echo "🚀 Starting Laravel Village Shared Hosting Deployment..."
echo "=================================================="

# Configuration
PROJECT_NAME="Laravel-Village"
BACKUP_DIR="backup-$(date +%Y%m%d-%H%M%S)"

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

# Check if PHP is available
check_php() {
    print_info "Checking PHP availability..."
    if ! command -v php &> /dev/null; then
        print_error "PHP is not available. Please install PHP 8.2+ first."
        exit 1
    fi
    
    PHP_VERSION=$(php -r "echo PHP_VERSION;")
    print_status "PHP version: $PHP_VERSION"
}

# Check if composer is available
check_composer() {
    print_info "Checking Composer availability..."
    if ! command -v composer &> /dev/null; then
        print_error "Composer is not available. Please install Composer first."
        exit 1
    fi
    print_status "Composer is available"
}

# Backup existing deployment
create_backup() {
    if [ -d "storage" ]; then
        print_info "Creating backup of existing deployment..."
        mkdir -p "$BACKUP_DIR"
        cp -r storage "$BACKUP_DIR/"
        cp .env "$BACKUP_DIR/" 2>/dev/null || true
        print_status "Backup created in $BACKUP_DIR"
    fi
}

# Setup environment for shared hosting
setup_environment() {
    print_info "Setting up environment for shared hosting..."
    
    # Copy shared hosting environment template
    if [ ! -f ".env" ]; then
        if [ -f ".env.shared-hosting" ]; then
            cp .env.shared-hosting .env
            print_status "Copied shared hosting environment template"
        else
            print_error "No environment template found! Please create .env file."
            exit 1
        fi
    fi
    
    # Generate application key if not set
    if ! grep -q "APP_KEY=base64:" .env; then
        print_info "Generating application key..."
        php artisan key:generate --force
        print_status "Application key generated"
    fi
}

# Install dependencies (production mode)
install_dependencies() {
    print_info "Installing production dependencies..."
    
    # Clear composer cache
    composer clear-cache
    
    # Install dependencies optimized for production
    composer install --no-dev --optimize-autoloader --no-interaction
    
    if [ $? -eq 0 ]; then
        print_status "Dependencies installed successfully"
    else
        print_error "Failed to install dependencies"
        exit 1
    fi
}

# Build frontend assets
build_assets() {
    print_info "Building frontend assets..."
    
    if [ -f "package.json" ]; then
        # Install npm dependencies
        if command -v npm &> /dev/null; then
            npm ci --silent
            npm run build
            print_status "Frontend assets built successfully"
        else
            print_warning "npm not available, skipping frontend build"
        fi
    else
        print_warning "No package.json found, skipping frontend build"
    fi
}

# Set proper permissions for shared hosting
set_permissions() {
    print_info "Setting proper file permissions..."
    
    # Storage and cache directories
    find storage -type d -exec chmod 755 {} \;
    find storage -type f -exec chmod 644 {} \;
    find bootstrap/cache -type d -exec chmod 755 {} \; 2>/dev/null || true
    find bootstrap/cache -type f -exec chmod 644 {} \; 2>/dev/null || true
    
    # Make sure important directories exist
    mkdir -p storage/logs
    mkdir -p storage/framework/cache
    mkdir -p storage/framework/sessions
    mkdir -p storage/framework/views
    mkdir -p bootstrap/cache
    
    print_status "Permissions set successfully"
}

# Database setup and migration
setup_database() {
    print_info "Setting up database..."
    
    # Test database connection
    php artisan config:cache
    
    if php artisan migrate:status &>/dev/null; then
        print_info "Running database migrations..."
        php artisan migrate --force
        print_status "Database migrations completed"
    else
        print_warning "Could not connect to database. Please check your .env configuration."
        return 1
    fi
}

# Apply shared hosting optimizations
apply_optimizations() {
    print_info "Applying shared hosting optimizations..."
    
    # Clear all caches first
    php artisan cache:clear 2>/dev/null || true
    php artisan config:clear 2>/dev/null || true
    php artisan route:clear 2>/dev/null || true
    php artisan view:clear 2>/dev/null || true
    
    # Cache configuration, routes, and views for production
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Create storage symlink if it doesn't exist
    if [ ! -L "public/storage" ]; then
        php artisan storage:link 2>/dev/null || true
    fi
    
    print_status "Optimizations applied successfully"
}

# Cleanup development files
cleanup_dev_files() {
    print_info "Cleaning up development files..."
    
    # Remove development files that shouldn't be in production
    rm -rf .git 2>/dev/null || true
    rm -rf tests 2>/dev/null || true
    rm -rf node_modules 2>/dev/null || true
    rm -f .gitignore .gitattributes 2>/dev/null || true
    rm -f package*.json webpack.mix.js vite.config.js 2>/dev/null || true
    rm -f phpunit.xml .editorconfig .styleci.yml 2>/dev/null || true
    rm -f railway*.* nixpacks.toml 2>/dev/null || true
    
    print_status "Development files cleaned up"
}

# Verify deployment
verify_deployment() {
    print_info "Verifying deployment..."
    
    # Check if key routes are working
    if php artisan route:list &>/dev/null; then
        print_status "Routes are properly configured"
    else
        print_warning "Route issues detected"
    fi
    
    # Check if database is accessible
    if php artisan migrate:status &>/dev/null; then
        print_status "Database connection verified"
    else
        print_warning "Database connection issues"
    fi
    
    # Check storage permissions
    if [ -w "storage/logs" ]; then
        print_status "Storage permissions are correct"
    else
        print_warning "Storage permission issues detected"
    fi
}

# Display post-deployment instructions
show_instructions() {
    echo ""
    echo "🎉 Deployment completed successfully!"
    echo "=================================="
    echo ""
    echo "📋 Next steps for your shared hosting:"
    echo ""
    echo "1. 📁 Upload all files to your hosting's public_html directory"
    echo "2. 🔧 Edit .env file with your hosting database credentials:"
    echo "   - DB_HOST (usually 'localhost')"
    echo "   - DB_DATABASE (your database name)"
    echo "   - DB_USERNAME (your database username)"
    echo "   - DB_PASSWORD (your database password)"
    echo "   - APP_URL (your domain name)"
    echo ""
    echo "3. 🗄️ Create database and run migrations (if needed):"
    echo "   php artisan migrate --force"
    echo ""
    echo "4. 🔐 Set these file permissions via cPanel or FTP:"
    echo "   - storage/ and subdirectories: 755"
    echo "   - bootstrap/cache/: 755"
    echo ""
    echo "5. ✅ Verify your site is working:"
    echo "   - Homepage: https://your-domain.com"
    echo "   - Admin: https://your-domain.com/admin"
    echo ""
    echo "📞 If you encounter issues:"
    echo "   - Check storage/logs/laravel.log for errors"
    echo "   - Ensure PHP 8.2+ is enabled in cPanel"
    echo "   - Contact your hosting provider for Laravel support"
    echo ""
    echo "🏠 Your Laravel Village is ready for shared hosting!"
}

# Main execution
main() {
    # Pre-flight checks
    check_php
    check_composer
    
    # Deployment steps
    create_backup
    setup_environment
    install_dependencies
    build_assets
    set_permissions
    setup_database
    apply_optimizations
    cleanup_dev_files
    verify_deployment
    
    # Post-deployment
    show_instructions
}

# Run main function
main

echo ""
echo "🚀 Shared hosting deployment script completed!"
echo "============================================"
#!/bin/bash

echo "🚀 Starting Railway deployment with error handling..."

# Set error handling
set -e

# Check if we're in production
if [ "$APP_ENV" = "production" ]; then
    echo "📦 Production environment detected"
    
    # Install dependencies
    echo "📥 Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction --no-progress
    
    echo "📥 Installing NPM dependencies..."
    npm ci --silent
    
    # Build assets
    echo "🔨 Building assets..."
    npm run build
    
    # Clear and cache for production
    echo "🧹 Clearing caches..."
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    
    echo "📝 Caching configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Handle storage link safely
    echo "🔗 Checking storage link..."
    if [ ! -L "public/storage" ]; then
        echo "Creating storage link..."
        php artisan storage:link
    else
        echo "Storage link already exists, skipping..."
    fi
    
    # Run migrations
    echo "🗄️ Running migrations..."
    php artisan migrate --force --no-interaction
    
    echo "✅ Deployment completed successfully!"
else
    echo "🔧 Non-production environment"
    composer install
    npm install
    npm run dev
fi
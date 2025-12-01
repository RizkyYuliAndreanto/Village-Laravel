#!/bin/bash

# Railway Build Script for Laravel with Vite
set -e

echo "🚀 Starting Railway build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm install

# Build Vite assets
echo "🔨 Building Vite assets..."
npm run build

# Generate Laravel key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating Laravel application key..."
    php artisan key:generate --no-interaction
fi

# Clear ALL caches completely
echo "🧹 Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
php artisan queue:clear

# Cache for production
echo "⚙️ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Run migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "✅ Build completed successfully!"
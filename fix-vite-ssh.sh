#!/bin/bash

# Script untuk memperbaiki Vite manifest di shared hosting via SSH
# Jalankan script ini di server shared hosting

echo "🔧 Fixing Vite manifest issue..."

# 1. Masuk ke direktori Laravel
cd /home/desabany/laravel

# 2. Buat direktori build jika belum ada
echo "📁 Creating build directory..."
mkdir -p public/build

# 3. Set permission
echo "🔐 Setting permissions..."
chmod -R 755 public/build
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# 4. Copy file .env untuk production
if [ -f .env.shared-hosting ]; then
    echo "📝 Using .env.shared-hosting..."
    cp .env.shared-hosting .env
fi

# 5. Install dependencies jika diperlukan (opsional)
echo "📦 Checking composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader
fi

# 6. Clear dan cache Laravel
echo "🗑️ Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 7. Periksa apakah manifest.json ada
if [ -f public/build/manifest.json ]; then
    echo "✅ Manifest found!"
    echo "📄 Manifest content:"
    head -n 10 public/build/manifest.json
else
    echo "❌ Manifest still missing!"
    echo "📋 Files in build directory:"
    ls -la public/build/
fi

echo "🎉 Process completed!"
echo "🌐 Try accessing your website now."
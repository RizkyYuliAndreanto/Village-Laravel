#!/bin/bash

# Railway Start Script
set -e

echo "🌐 Starting Laravel application..."

# Ensure storage is writable
chmod -R 775 storage bootstrap/cache

# Start PHP server
exec php artisan serve --host=0.0.0.0 --port=$PORT
#!/bin/bash

# Railway Post-Deploy Migration Script
# Run this via Railway console after successful deployment

echo "🚀 Starting Laravel post-deployment setup..."

# Generate APP_KEY if not exists
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
    echo "📝 Generating APP_KEY..."
    php artisan key:generate --force
    echo "✅ APP_KEY generated"
fi

# Check database connection
echo "🗄️ Testing database connection..."
php artisan migrate:status || {
    echo "❌ Database connection failed. Please check environment variables:"
    echo "   - MYSQLHOST, MYSQLPORT, MYSQLDATABASE, MYSQLUSER, MYSQLPASSWORD"
    exit 1
}

# Run database migrations
echo "🗄️ Running database migrations..."
php artisan migrate --force
echo "✅ Migrations completed"

# Seed database (optional)
echo "🌱 Seeding database..."
php artisan db:seed --force
echo "✅ Database seeded"

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link
echo "✅ Storage linked"

# Clear and optimize application
echo "🧹 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Application optimized"

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
echo "✅ Permissions set"

echo ""
echo "🎉 Railway deployment setup completed successfully!"
echo ""
echo "📋 Next steps:"
echo "   1. Test your application: $APP_URL"
echo "   2. Access admin panel: $APP_URL/admin"
echo "   3. Check APBDes: $APP_URL/apbdes"
echo "   4. Check PPID: $APP_URL/ppid"
echo ""
echo "✅ All features should be working with mobile responsive design!"
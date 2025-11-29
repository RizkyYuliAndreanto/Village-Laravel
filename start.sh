#!/bin/bash
set -e

echo "============================"
echo "🚀 DEBUG START SCRIPT BEGIN"
echo "============================"

echo "📌 Current directory: $(pwd)"
echo "📌 Listing project folder:"
ls -lah /var/www/html

echo ""
echo "📌 Checking Laravel environment (.env):"
if [ -f /var/www/html/.env ]; then
    cat /var/www/html/.env
else
    echo "❌ .env file NOT FOUND!"
fi

echo ""
echo "📌 Checking PHP version:"
php -v

echo ""
echo "📌 Checking Composer:"
composer --version || echo "❌ Composer not available"

echo ""
echo "📌 Checking Apache config:"
apache2ctl -S || echo "❌ Apache config error"

echo ""
echo "📌 Checking MySQL connection..."
echo "Trying to connect: ${DB_HOST}:${DB_PORT}"
# DO NOT EXIT on failure → keep container alive
php -r "
\$conn = @mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'), getenv('DB_PORT'));
if (!\$conn) { echo \"❌ MySQL connect failed: \" . mysqli_connect_error() . \"\n\"; }
else { echo \"✅ MySQL connected successfully.\n\"; }
"

echo ""
echo "📌 Running Laravel commands (debug mode)..."

echo "→ composer install"
composer install --no-interaction || echo "❌ composer install failed"

echo "→ php artisan key:generate"
php artisan key:generate || echo "❌ key:generate failed"

echo "→ php artisan config:clear"
php artisan config:clear || echo "❌ config:clear failed"

echo "→ php artisan optimize:clear"
php artisan optimize:clear || echo "❌ optimize:clear failed"

echo "→ php artisan migrate"
php artisan migrate --force || echo "❌ migration failed"

echo ""
echo "============================"
echo "🚀 STARTING APACHE IN DEBUG MODE"
echo "============================"
echo ""

# FOLLOW ALL APACHE LOGS LIVE
tail -F /var/log/apache2/*.log &

# KEEP APACHE RUNNING
exec apache2-foreground

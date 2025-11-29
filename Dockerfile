# Use PHP 8.3 with Apache
FROM php:8.3-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    default-mysql-client \
    netcat-traditional \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www/html

# Set proper permissions  
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Verify important directories and files are copied correctly
RUN echo "=== Checking Filament Resources structure ===" \
    && ls -la /var/www/html/app/Filament/Resources/ \
    && echo "=== Checking DetailApbdes directory ===" \
    && ls -la /var/www/html/app/Filament/Resources/DetailApbdes/ \
    && echo "=== Checking DetailApbdes Pages directory ===" \
    && ls -la /var/www/html/app/Filament/Resources/DetailApbdes/Pages/ \
    && echo "=== Files verification completed ==="

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

# Clear any cached autoload files and regenerate completely
RUN rm -rf vendor/composer/autoload_*.php bootstrap/cache/packages.php bootstrap/cache/services.php \
    && composer dump-autoload --optimize --no-scripts

# Verify the classes can be found
RUN php -c "echo 'Testing class autoload...';" \
    && php -r "require 'vendor/autoload.php'; echo class_exists('App\\Filament\\Resources\\DetailApbdes\\Pages\\ListDetailApbdes') ? 'ListDetailApbdes: OK' : 'ListDetailApbdes: MISSING'; echo PHP_EOL;"

# Run package discovery safely in production mode
RUN APP_ENV=production php artisan package:discover --ansi || echo "Package discovery completed with warnings"

# Install and build Node dependencies  
RUN npm ci && npm run build && npm cache clean --force

# Create required directories
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Configure Apache DocumentRoot to Laravel public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create Apache virtual host for Laravel
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        DirectoryIndex index.php\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port
EXPOSE 80

# Create startup script for Railway
RUN echo '#!/bin/bash\n\
# Wait for MySQL if using Railway MySQL\n\
if [ ! -z "$MYSQLHOST" ]; then\n\
    echo "Waiting for MySQL..."\n\
    timeout=30\n\
    while [ $timeout -gt 0 ]; do\n\
        if nc -z "$MYSQLHOST" "$MYSQLPORT"; then\n\
            echo "MySQL is up!"\n\
            break\n\
        fi\n\
        echo "MySQL is unavailable - sleeping ($timeout seconds left)"\n\
        sleep 1\n\
        timeout=$((timeout-1))\n\
    done\n\
    if [ $timeout -eq 0 ]; then\n\
        echo "MySQL connection timeout - continuing anyway"\n\
    fi\n\
fi\n\
\n\
# Run Laravel optimizations\n\
php artisan config:cache || echo "Config cache failed"\n\
php artisan route:cache || echo "Route cache failed"\n\
php artisan view:cache || echo "View cache failed"\n\
\n\
# Create storage link if not exists\n\
php artisan storage:link || echo "Storage link exists"\n\
\n\
# Set proper permissions\n\
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
\n\
# Start Apache in foreground\n\
apache2-foreground' > /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh

# Start with custom script
CMD ["/usr/local/bin/start.sh"]
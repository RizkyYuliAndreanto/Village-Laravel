    # Panduan Deployment ke Shared Hosting

## 📋 Persyaratan Minimum Shared Hosting

-   ✅ PHP 8.2 atau lebih tinggi
-   ✅ MySQL Database
-   ✅ Composer support atau upload manual vendor/
-   ✅ SSL Certificate
-   ✅ File permissions (755/644)

## 🚀 Langkah-langkah Deployment

### 1. Persiapan File Lokal

```bash
# Build assets untuk production
npm run build

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Buat backup database
php artisan db:seed --env=production # jika diperlukan
```

### 2. Upload Files ke Hosting

```
public_html/
├── public/ (isi Laravel public folder)
├── app/
├── config/
├── database/
├── resources/
├── routes/
├── storage/ (pastikan writable)
├── vendor/ (jika tidak ada composer di hosting)
├── .env (sesuaikan dengan hosting)
├── composer.json
└── artisan
```

### 3. Konfigurasi .env untuk Production

```dotenv
APP_NAME=VillageWeb
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database sesuai hosting
DB_CONNECTION=mysql
DB_HOST=localhost  # atau host yang diberikan hosting
DB_PORT=3306
DB_DATABASE=nama_database_hosting
DB_USERNAME=username_database
DB_PASSWORD=password_database

# Session & Cache
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

# File Storage
FILESYSTEM_DISK=public

# Mail (sesuai hosting)
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### 4. Struktur Folder Shared Hosting

```
/public_html/
├── index.php (dari Laravel public/)
├── .htaccess (dari Laravel public/)
├── storage/ -> ../storage/app/public/
├── css/ (build assets)
├── js/ (build assets)

/laravel/ (di luar public_html)
├── app/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
└── artisan
```

### 5. Update index.php

Edit `public_html/index.php`:

```php
<?php
// Ubah path ke folder Laravel di luar public_html
require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';
```

### 6. Permissions yang Diperlukan

```bash
# Set permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod 644 .env
```

### 7. Database Migration

```sql
-- Import database atau jalankan migration
-- php artisan migrate --force (jika ada access terminal)
-- Atau upload SQL dump melalui phpMyAdmin
```

### 8. Storage Link

```bash
# Jika ada akses terminal
php artisan storage:link

# Jika tidak ada akses terminal, buat manual:
# Buat symbolic link dari public/storage ke storage/app/public
```

## ⚠️ Troubleshooting Common Issues

### Error 500 - Internal Server Error

1. Cek file permissions (755/644)
2. Pastikan .env sesuai dengan hosting
3. Clear cache: `php artisan cache:clear`
4. Cek error log di hosting panel

### File Upload Tidak Berfungsi

1. Pastikan folder storage/ writable (755)
2. Buat folder umkm/logos dan umkm/galeri di storage/app/public/
3. Pastikan storage link sudah dibuat

### CSS/JS Tidak Load

1. Pastikan build assets sudah di-upload
2. Cek path di config/app.php: `'asset_url' => env('ASSET_URL')`
3. Update .env: `ASSET_URL=https://yourdomain.com`

### Database Connection Error

1. Cek kredensial database di .env
2. Pastikan host database benar (biasanya 'localhost')
3. Whitelist IP jika diperlukan

## 🎯 Optimasi untuk Shared Hosting

### 1. Cache Configuration

```php
// config/cache.php - gunakan file cache
'default' => 'file',
```

### 2. Session Configuration

```php
// config/session.php - gunakan file session
'driver' => 'file',
```

### 3. Queue Configuration

```php
// config/queue.php - gunakan sync untuk shared hosting
'default' => 'sync',
```

### 4. Reduce Memory Usage

```php
// config/app.php - disable unused services
'providers' => [
    // Comment out services yang tidak digunakan
],
```

## 📞 Support Hosting yang Direkomendasikan

-   **Hostinger** - Support Laravel, Node.js ✅
-   **Niagahoster** - Support Laravel, PHP 8+ ✅
-   **DomainRacer** - Support Laravel frameworks ✅
-   **Dewaweb** - Support Laravel, good performance ✅

## ✅ Checklist Deployment

-   [ ] Upload all files to hosting
-   [ ] Configure .env for production
-   [ ] Set correct file permissions
-   [ ] Create database and import data
-   [ ] Create storage symbolic link
-   [ ] Test file upload functionality
-   [ ] Test admin panel (Filament)
-   [ ] Test frontend UMKM pages
-   [ ] Configure SSL certificate
-   [ ] Test email sending (if used)

## 🔧 Post-Deployment Commands (jika ada SSH)

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Clear old caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

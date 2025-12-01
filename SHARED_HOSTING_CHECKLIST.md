# 🚀 Pre-Deployment Checklist untuk Shared Hosting

## ✅ CHECKLIST SEBELUM DEPLOYMENT

### 1. **Environment Configuration**

- [ ] Copy `.env.shared-hosting` ke `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL` ke domain Anda
- [ ] Configure database credentials
- [ ] Set mail configuration
- [ ] Generate application key: `php artisan key:generate`

### 2. **Database Setup**

- [ ] Create database di hosting panel
- [ ] Note database name, username, password
- [ ] Test database connection
- [ ] Verify database charset (utf8mb4_unicode_ci)

### 3. **Dependencies & Build**

- [ ] Run: `composer install --no-dev --optimize-autoloader`
- [ ] Run: `npm ci && npm run build` (jika diperlukan)
- [ ] Verify vendor folder exists
- [ ] Verify public/build folder exists (jika ada)

### 4. **Permissions & Security**

- [ ] Set storage folder permission: 755
- [ ] Set bootstrap/cache permission: 755
- [ ] Verify .htaccess file ada di public/
- [ ] Verify .env tidak accessible via web

### 5. **Optimization**

- [ ] Run: `php artisan optimize:shared-hosting --setup`
- [ ] Run: `php artisan config:cache`
- [ ] Run: `php artisan view:cache`
- [ ] Don't run route:cache (compatibility issues)

### 6. **File Upload**

- [ ] Upload semua files ke public_html
- [ ] Verify file structure correct
- [ ] Test main routes work
- [ ] Test admin panel accessible

### 7. **Post-Deployment**

- [ ] Run migrations: `php artisan migrate --force`
- [ ] Create storage symlink: `php artisan storage:link`
- [ ] Warm up cache: `php artisan optimize:shared-hosting --cache-warmup`
- [ ] Test all major features
- [ ] Monitor error logs

---

## 🔧 QUICK SETUP COMMANDS

### Local Preparation:

```bash
# Setup shared hosting config
php artisan optimize:shared-hosting --setup

# Install production dependencies
composer install --no-dev --optimize-autoloader

# Build assets (if needed)
npm ci && npm run build

# Generate caches
php artisan config:cache
php artisan view:cache
```

### On Shared Hosting:

```bash
# Generate key
php artisan key:generate --force

# Run migrations
php artisan migrate --force

# Create symlinks
php artisan storage:link

# Warm up cache
php artisan optimize:shared-hosting --cache-warmup
```

---

## 📋 FILE STRUCTURE CHECK

Your hosting public_html should contain:

```
public_html/
├── index.php
├── .htaccess
├── css/ (dari public/build)
├── js/ (dari public/build)
├── storage/ (symlink)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
└── composer.lock
```

---

## ⚠️ TROUBLESHOOTING COMMON ISSUES

### "500 Internal Server Error"

- Check `storage/logs/laravel.log`
- Verify file permissions (755 for folders, 644 for files)
- Check .env configuration
- Ensure PHP version is 8.2+

### "Database Connection Failed"

- Verify database credentials in .env
- Check if database exists
- Use 'localhost' as DB_HOST for most shared hosting
- Contact hosting support for connection details

### "Cache/Session Issues"

- Run: `php artisan cache:clear`
- Run: `php artisan optimize:shared-hosting --cleanup`
- Check storage folder permissions

### "Storage Symlink Failed"

- Create manually via cPanel File Manager
- Or contact hosting support to enable symlink
- Alternative: copy storage/app/public to public/storage

### "Memory Limit Exceeded"

- Request PHP memory increase from hosting
- Or optimize code to use less memory
- Use pagination for large data sets

---

## 📞 HOSTING SUPPORT CHECKLIST

When contacting hosting support, mention:

- PHP version 8.2+ required
- Laravel framework requirements
- Need for symlink support (if symlink fails)
- Composer and artisan command access
- Memory limit requirements (256MB recommended)

---

## 🎯 PERFORMANCE OPTIMIZATION

### After Deployment:

- Monitor: `php artisan optimize:shared-hosting --monitor`
- Weekly cleanup: `php artisan optimize:shared-hosting --cleanup`
- Check logs regularly: `storage/logs/laravel.log`
- Monitor database query performance

### Hosting Recommendations:

- Choose hosting with PHP 8.2+
- Ensure MySQL 5.7+ or MariaDB 10.3+
- Minimum 512MB RAM (1GB recommended)
- SSD storage preferred
- SSL/HTTPS support included

---

**✅ Deployment Ready!**

Your Laravel Village project is now optimized for shared hosting deployment.
Follow this checklist step by step for a successful deployment.

🏠 **Happy Hosting!** 🚀

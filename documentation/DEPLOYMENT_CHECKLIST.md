# 🔄 SHARED HOSTING DEPLOYMENT CHECKLIST

## 📋 Pre-Deployment Checklist

### **Local Development Complete** ✅

-   [ ] All features working locally
-   [ ] No critical bugs in development
-   [ ] Database migrations tested
-   [ ] File uploads working
-   [ ] Admin panel functional
-   [ ] Front-end responsive

### **Shared Hosting Requirements** ✅

-   [ ] PHP 8.2+ available on hosting
-   [ ] MySQL database created
-   [ ] Domain/subdomain configured
-   [ ] SSL certificate available
-   [ ] FTP or cPanel access ready
-   [ ] Database credentials noted

---

## 🛠️ **DEPLOYMENT PROCESS**

### **Step 1: Local Preparation** ⏳

```bash
# Terminal commands to run locally:
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Setup shared hosting configuration
cp .env.shared-hosting .env
php artisan optimize:shared-hosting --setup
```

**Status:** [ ] Complete

### **Step 2: Environment Configuration** ⏳

Edit `.env` file with your hosting details:

```env
APP_NAME="Desa [NAMA_DESA]"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://[YOUR-DOMAIN.com]

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=[your_database_name]
DB_USERNAME=[your_username]
DB_PASSWORD=[your_password]

# Shared hosting optimized settings
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
```

**Status:** [ ] Complete

### **Step 3: File Upload** ⏳

**Via FTP/cPanel File Manager:**

-   [ ] Upload all project files to `public_html/` or domain folder
-   [ ] Ensure `.env` file uploaded and configured
-   [ ] Verify `storage/` and `bootstrap/cache/` folders exist
-   [ ] Set folder permissions: `storage/` → 755, `bootstrap/cache/` → 755

**Status:** [ ] Complete

### **Step 4: Database Setup** ⏳

**Via hosting cPanel terminal or SSH:**

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Seed initial data (if needed)
php artisan db:seed --force

# Optimize for shared hosting
php artisan optimize:shared-hosting --cache-warmup
```

**Status:** [ ] Complete

### **Step 5: Automated Deployment (Alternative)** ⏳

**Run the automated script:**

```bash
chmod +x deploy-shared-hosting.sh
./deploy-shared-hosting.sh
```

This script handles steps 1-4 automatically.

**Status:** [ ] Complete (if using automated script)

---

## ✅ **POST-DEPLOYMENT VERIFICATION**

### **Website Functionality**

-   [ ] Homepage loads correctly (`https://your-domain.com`)
-   [ ] No 500 or 404 errors
-   [ ] Images and CSS loading properly
-   [ ] Navigation working

### **Admin Panel**

-   [ ] Admin login accessible (`/admin`)
-   [ ] Can log in with admin credentials
-   [ ] Dashboard loads without errors
-   [ ] Admin navigation functional
-   [ ] File upload working in admin

### **Core Features**

-   [ ] **Demografi**: Statistics page working
-   [ ] **UMKM**: Business listings displaying
-   [ ] **Berita**: News articles showing
-   [ ] **Profil Desa**: Village profile accessible
-   [ ] **Infografis**: Graphics/charts loading
-   [ ] **APBDES**: Budget data (if applicable)
-   [ ] **PPID**: Public info service working

### **Performance Check**

-   [ ] Page load time < 3 seconds
-   [ ] Cache files being created in `storage/framework/cache/`
-   [ ] No memory limit errors
-   [ ] Database connections working
-   [ ] Session handling functional

### **Security Verification**

-   [ ] HTTPS working and SSL certificate active
-   [ ] `.env` file not accessible via browser
-   [ ] Error pages don't expose sensitive information
-   [ ] Admin area password protected
-   [ ] File upload security working

---

## 🔍 **TROUBLESHOOTING GUIDE**

### **Common Issues & Solutions**

#### **❌ "500 Internal Server Error"**

**Check:**

-   [ ] `storage/logs/laravel.log` for detailed error
-   [ ] File permissions on `storage/` and `bootstrap/cache/`
-   [ ] `.env` configuration accuracy
-   [ ] PHP version compatibility

**Fix:**

```bash
chmod 755 storage/ -R
chmod 755 bootstrap/cache/ -R
php artisan cache:clear
```

#### **❌ "Database Connection Error"**

**Check:**

-   [ ] Database credentials in `.env`
-   [ ] Database server hostname (usually `localhost`)
-   [ ] Database exists and user has permissions
-   [ ] MySQL service running

**Fix:**

```bash
# Test connection via cPanel phpMyAdmin
# Verify hostname, username, password, database name
```

#### **❌ "Storage Not Writable"**

**Check:**

-   [ ] `storage/` folder permissions
-   [ ] `bootstrap/cache/` permissions
-   [ ] Web server can write to these directories

**Fix:**

```bash
chmod 755 storage/ -R
chmod 755 bootstrap/cache/ -R
```

#### **❌ "Cache Not Working"**

**Check:**

-   [ ] File-based cache configuration
-   [ ] Cache directory writable
-   [ ] No Redis/Memcached references

**Fix:**

```bash
php artisan cache:clear
php artisan optimize:shared-hosting --cache-warmup
```

#### **❌ "Files Not Uploading"**

**Check:**

-   [ ] File upload directory permissions
-   [ ] Upload size limits in hosting
-   [ ] Storage disk configuration
-   [ ] Symbolic link to storage

**Fix:**

```bash
chmod 755 public/storage/
php artisan storage:link
```

---

## 📊 **PERFORMANCE MONITORING**

### **Check Performance Regularly**

```bash
# Monitor shared hosting performance
php artisan optimize:shared-hosting --monitor

# Clean up old cache files
php artisan optimize:shared-hosting --cleanup
```

### **Expected Metrics**

-   **Response Time**: 400-800ms (acceptable for shared hosting)
-   **Memory Usage**: 32-64MB per request
-   **Cache Hit Rate**: 80%+
-   **Database Queries**: <10 per page load

### **Weekly Maintenance**

```bash
# Clear old logs and cache
php artisan optimize:shared-hosting --cleanup

# Refresh cache
php artisan optimize:shared-hosting --cache-warmup
```

---

## 🎯 **SUCCESS CRITERIA**

### **✅ Deployment Successful When:**

-   [ ] All core pages load without errors
-   [ ] Admin panel fully functional
-   [ ] User interactions working (forms, searches, etc.)
-   [ ] Performance acceptable (< 3 second page loads)
-   [ ] No critical errors in logs
-   [ ] File uploads functional
-   [ ] Database operations working
-   [ ] Cache system operational
-   [ ] Security measures active
-   [ ] HTTPS working properly

### **🎉 Project Ready for Production**

Once all items above are checked ✅, your Laravel Village project is successfully deployed and ready for production use on shared hosting!

---

## 📞 **Next Steps After Deployment**

1. **Content Management**: Start adding village data through admin panel
2. **SEO Optimization**: Configure meta tags and sitemap
3. **Backup Strategy**: Set up regular database and file backups
4. **Monitoring**: Implement uptime and performance monitoring
5. **Updates**: Plan for regular maintenance and Laravel updates

---

**🏠 Congratulations! Your Village Web project is now live on shared hosting! 🎉**

**Need help?** Check logs in `storage/logs/laravel.log` and use the troubleshooting commands provided above.

# 🚀 Railway Quick Deploy Script

## ⚠️ DEPENDENCY FIXES APPLIED:
✅ Laravel Framework downgraded to v11.0 (from v12.0) for stability
✅ Filament updated to v3.2 for compatibility
✅ **DOCKER DEPLOYMENT**: Using custom Dockerfile with PHP 8.3
✅ All PHP extensions (zip, intl, pdo_mysql, pdo_pgsql, etc.) included
✅ **DUAL DATABASE SUPPORT**: MySQL + PostgreSQL ready

## 🐳 Docker-Based Deployment:
- **Builder**: DOCKERFILE (instead of NIXPACKS) 
- **Base Image**: PHP 8.3 with Apache (fixes openspout requirement)
- **Extensions**: zip, intl, pdo_mysql, pdo_pgsql, gd, mbstring, xml, curl, etc.
- **Port**: 80 (Apache default)

## 📊 Database Options:

### Option 1: MySQL (Recommended untuk Anda)
```bash
# 1. APP CONFIGURATION
APP_NAME=Village Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# 2. DATABASE MYSQL (Add MySQL service di Railway)
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

# 3. CACHING & SESSIONS
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# 4. FILE STORAGE
FILESYSTEM_DISK=public

# 5. SECURITY
BCRYPT_ROUNDS=12
```

### Option 2: PostgreSQL (Railway Default)
```bash
# 1. APP CONFIGURATION
APP_NAME=Village Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# 2. DATABASE POSTGRESQL (Railway auto-fills)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# 3. CACHING & SESSIONS
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# 4. FILE STORAGE
FILESYSTEM_DISK=public

# 5. SECURITY
BCRYPT_ROUNDS=12
```

## Generate APP_KEY:

```bash
# Run this locally to get APP_KEY:
php artisan key:generate --show

# Then add to Railway environment:
APP_KEY=base64:your-generated-key-here
```

## Post-Deploy Commands (Run in Railway Console):

```bash
# 1. Migrate database
php artisan migrate --force

# 2. Create storage link
php artisan storage:link

# 3. Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Seed database (optional)
php artisan db:seed --force
```

## URL Structure:

-   **Main App**: `https://your-app-name.up.railway.app`
-   **Admin Panel**: `https://your-app-name.up.railway.app/admin`
-   **APBDes**: `https://your-app-name.up.railway.app/apbdes`
-   **PPID**: `https://your-app-name.up.railway.app/ppid`

## Testing Checklist:

-   [ ] Homepage loads
-   [ ] Mobile responsive working
-   [ ] APBDes horizontal layout active
-   [ ] PPID cards working
-   [ ] Admin login functional
-   [ ] Database connected

Ready for Railway! 🎉

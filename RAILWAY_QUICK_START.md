# 🚀 Railway Quick Deploy Script

## ⚠️ DEPENDENCY FIXES APPLIED:

✅ Laravel Framework downgraded to v11.0 (from v12.0) for stability
✅ Filament updated to v3.2 for compatibility
✅ **DOCKER DEPLOYMENT**: Using custom Dockerfile with PHP 8.3
✅ All PHP extensions (zip, intl, pdo_mysql, pdo_pgsql, etc.) included
✅ **DUAL DATABASE SUPPORT**: MySQL + PostgreSQL ready

## 🐳 Docker-Based Deployment:

-   **Builder**: DOCKERFILE (instead of NIXPACKS)
-   **Base Image**: PHP 8.3 with Apache (fixes openspout requirement)
-   **Extensions**: zip, intl, pdo_mysql, pdo_pgsql, gd, mbstring, xml, curl, etc.
-   **Port**: 80 (Apache default)

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

**IMPORTANT**: Railway akan auto-start Apache web server.
Setelah deploy sukses, run migration script:

```bash
# Option 1: Run migration script (Recommended)
chmod +x railway-post-deploy.sh && ./railway-post-deploy.sh

# Option 2: Manual commands
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🚀 Fixed Issues:

✅ **ServeCommand Error**: Menggunakan Apache langsung (port 80)
✅ **MySQL Connection**: Auto-wait untuk MySQL service ready
✅ **Database Setup**: Post-deploy migration script included
✅ **Permissions**: Auto-set proper Laravel permissions

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

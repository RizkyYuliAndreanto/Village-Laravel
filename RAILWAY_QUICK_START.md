# 🚀 Railway Quick Deploy Script

## Copy-Paste Commands untuk Railway Environment Variables:

```bash
# 1. APP CONFIGURATION
APP_NAME=Village Laravel
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# 2. DATABASE (Railway auto-fills these)
DB_CONNECTION=pgsql
DB_HOST=${{PGHOST}}
DB_PORT=${{PGPORT}}
DB_DATABASE=${{PGDATABASE}}
DB_USERNAME=${{PGUSER}}
DB_PASSWORD=${{PGPASSWORD}}

# 3. CACHING & SESSIONS
CACHE_DRIVER=database
SESSION_DRIVER=database
QUEUE_CONNECTION=database

# 4. FILE STORAGE
FILESYSTEM_DISK=public

# 5. SECURITY
BCRYPT_ROUNDS=12

# 6. RAILWAY SPECIFIC
PORT=8080
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
- **Main App**: `https://your-app-name.up.railway.app`
- **Admin Panel**: `https://your-app-name.up.railway.app/admin`
- **APBDes**: `https://your-app-name.up.railway.app/apbdes`
- **PPID**: `https://your-app-name.up.railway.app/ppid`

## Testing Checklist:
- [ ] Homepage loads
- [ ] Mobile responsive working
- [ ] APBDes horizontal layout active
- [ ] PPID cards working
- [ ] Admin login functional
- [ ] Database connected

Ready for Railway! 🎉
# 🚀 Railway Deployment Guide - Village Laravel Project

## 📋 Overview
Panduan ini untuk deploy project Village Laravel ke Railway sebagai testing environment sebelum deploy final ke shared hosting.

## ✅ Prerequisites
- [x] GitHub repository sudah ready (main branch)
- [x] Railway account (gratis/pro)
- [x] Project sudah mobile responsive optimized
- [x] Database migrations ready

## 🔧 Step 1: Persiapan Environment Variables

### Environment Variables yang dibutuhkan di Railway:

```env
# App Configuration
APP_NAME="Village Laravel"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-railway-app.up.railway.app

# Database (Railway akan auto-generate PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Session & Cache
SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

# File Storage
FILESYSTEM_DISK=public

# Mail (optional untuk testing)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Village Laravel"

# Security
BCRYPT_ROUNDS=12
```

## 🚀 Step 2: Deploy ke Railway

### 2.1 Login ke Railway
1. Buka [railway.app](https://railway.app)
2. Login dengan GitHub account
3. Authorize Railway untuk akses repository

### 2.2 Create New Project
1. Click **"New Project"**
2. Select **"Deploy from GitHub repo"**
3. Choose **"RizkyYuliAndreanto/Village-Laravel"**
4. Select **"main"** branch
5. Click **"Deploy Now"**

### 2.3 Auto-Detection
Railway akan otomatis detect:
- ✅ PHP Laravel framework
- ✅ Composer dependencies
- ✅ Build process

## 🗄️ Step 3: Database Setup

### 3.1 Add PostgreSQL Database
1. Di Railway dashboard, click **"+ Add Service"**
2. Select **"PostgreSQL"**
3. Database akan auto-provision
4. Environment variables otomatis ter-setup

### 3.2 Connect Database ke App
Railway otomatis connect database variables:
- `PGHOST`, `PGPORT`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`
- Update `DB_CONNECTION=pgsql` di environment variables

## ⚙️ Step 4: Configuration

### 4.1 Set Environment Variables
1. Go to **"Variables"** tab di Railway dashboard
2. Add semua environment variables dari Step 1
3. **Generate APP_KEY**:
   ```bash
   php artisan key:generate --show
   ```

### 4.2 Build Configuration
Railway otomatis menggunakan:
```json
{
  "scripts": {
    "build": "npm ci && npm run build && composer install --no-dev --optimize-autoloader"
  }
}
```

## 📦 Step 5: Deploy Process

### 5.1 Automatic Deployment
Railway akan:
1. Clone repository
2. Install dependencies (`composer install`)
3. Run npm build (`npm run build`)
4. Setup environment
5. Start application

### 5.2 Migration & Seeding
Setelah deploy berhasil, run migration:
1. Go to **"Deployments"** tab
2. Click latest deployment
3. Open **"Deploy Logs"**
4. Run commands via Railway CLI atau dashboard:

```bash
# Migrate database
php artisan migrate --force

# Seed data (optional)
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🌐 Step 6: Domain & Testing

### 6.1 Custom Domain (Optional)
1. Go to **"Settings"** tab
2. Add custom domain jika diperlukan
3. Atau gunakan Railway domain: `https://your-app.up.railway.app`

### 6.2 Testing Checklist
- [ ] Home page loading
- [ ] APBDes section responsive
- [ ] PPID horizontal cards working
- [ ] Mobile optimizations active
- [ ] Admin login working
- [ ] Database connections working
- [ ] File uploads working

## 🔍 Step 7: Monitoring & Debugging

### 7.1 Check Logs
```bash
# Via Railway dashboard
- Go to "Deployments" tab
- Click deployment
- View "Deploy Logs" dan "Build Logs"

# Common issues:
- APP_KEY not set
- Database migration errors
- File permission issues
```

### 7.2 Performance Monitoring
Railway provides:
- CPU & Memory usage
- Request metrics
- Error tracking

## 💰 Step 8: Cost Management

### 8.1 Free Tier Limits
- $5 credit per month
- Aplikasi sleep setelah 30 menit tidak aktif
- Shared resources

### 8.2 Pro Tier Benefits
- $20/month
- Always-on applications
- Better performance
- Priority support

## 🔄 Step 9: Continuous Deployment

### 9.1 Auto-Deploy Setup
Railway otomatis deploy ketika push ke main branch:
1. Push changes ke GitHub main branch
2. Railway detect changes
3. Auto-trigger new deployment
4. Zero-downtime deployment

### 9.2 Branch Strategy
```bash
# Development workflow
git checkout -b feature/new-feature
# ... make changes ...
git push origin feature/new-feature
# ... create PR, merge to main ...
# Railway auto-deploys
```

## 🚀 Step 10: Migration ke Shared Hosting

Setelah testing di Railway sukses:

### 10.1 Backup Railway Data
```bash
# Export database
pg_dump railway_db > backup.sql

# Download uploaded files
# Backup environment configurations
```

### 10.2 Shared Hosting Prep
1. **Database**: Export dari Railway PostgreSQL ke MySQL
2. **Files**: Download semua uploaded files
3. **Environment**: Adapt untuk shared hosting environment
4. **Dependencies**: Ensure PHP version compatibility

### 10.3 Database Migration Script
```sql
-- Convert PostgreSQL to MySQL
-- Update data types:
-- serial -> AUTO_INCREMENT
-- boolean -> TINYINT(1)
-- timestamp -> DATETIME
```

## 🛠️ Troubleshooting

### Common Issues:

**1. Build Fails**
```bash
# Check composer.json dependencies
# Ensure PHP version compatibility
# Verify package.json scripts
```

**2. Database Connection Error**
```bash
# Verify DATABASE_URL format
# Check PostgreSQL service status
# Confirm environment variables
```

**3. File Upload Issues**
```bash
# Check storage permissions
# Verify storage:link command
# Configure filesystem disk
```

**4. Performance Issues**
```bash
# Enable caching:
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize composer:
composer install --optimize-autoloader --no-dev
```

## 📞 Support & Resources

- **Railway Docs**: [docs.railway.app](https://docs.railway.app)
- **Railway Discord**: Community support
- **Laravel Deployment**: [laravel.com/docs/deployment](https://laravel.com/docs/deployment)

## 🎯 Success Criteria

✅ **Railway Deployment Successful When:**
- [ ] Application loads without errors
- [ ] Database connected and migrations ran
- [ ] Mobile responsive design working
- [ ] Admin panel accessible
- [ ] File uploads functioning
- [ ] Performance acceptable
- [ ] SSL certificate active

✅ **Ready for Shared Hosting When:**
- [ ] Railway testing completed
- [ ] All features validated
- [ ] Performance optimized
- [ ] Database export ready
- [ ] Files backed up
- [ ] Environment variables documented

---

## 🚀 Quick Deploy Command

```bash
# Clone and prepare for Railway
git clone https://github.com/RizkyYuliAndreanto/Village-Laravel.git
cd Village-Laravel
git checkout main

# Railway will handle the rest automatically!
```

**Happy Deploying! 🎉**
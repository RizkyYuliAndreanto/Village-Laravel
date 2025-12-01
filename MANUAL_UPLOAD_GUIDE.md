# 📁 PANDUAN MANUAL UPLOAD ke cPanel File Manager

## 🚀 PERSIAPAN SEBELUM UPLOAD

### 1. Prepare Project untuk Upload

```bash
# Jalankan persiapan terakhir
composer install --no-dev --optimize-autoloader
npm run build
php artisan config:cache
php artisan view:cache
php artisan optimize
```

### 2. File yang HARUS di-upload

```
✅ WAJIB UPLOAD:
├── app/ (folder)
├── bootstrap/ (folder)
├── config/ (folder)
├── database/ (folder)
├── public/ (folder) - INI PENTING!
├── resources/ (folder)
├── routes/ (folder)
├── storage/ (folder)
├── vendor/ (folder) - Jika sudah composer install
├── .env.shared-hosting (rename jadi .env)
├── artisan (file)
├── composer.json
└── composer.lock

❌ JANGAN UPLOAD:
├── .git/
├── node_modules/
├── tests/
├── .gitignore
├── package.json
├── README.md
└── deploy-*.ps1
```

## 📂 LANGKAH-LANGKAH UPLOAD

### STEP 1: Login ke cPanel

1. Buka cPanel hosting Anda
2. Cari "File Manager" dan klik
3. Navigate ke folder `public_html`

### STEP 2: Upload Files

```
🎯 STRATEGI UPLOAD:

Method 1 - ZIP Upload (RECOMMENDED):
1. Compress semua files yang wajib di-upload ke ZIP
2. Upload ZIP file ke public_html
3. Extract di cPanel File Manager
4. Move isi folder Laravel ke root public_html

Method 2 - Folder by Folder:
1. Upload folder app/ ke public_html/app/
2. Upload folder bootstrap/ ke public_html/bootstrap/
3. (repeat untuk semua folder)
```

### STEP 3: Struktur Akhir di Hosting

```
public_html/
├── index.php (dari Laravel public/ folder)
├── .htaccess (dari Laravel public/ folder)
├── css/ (dari public/build/ jika ada)
├── js/ (dari public/build/ jika ada)
├── storage/ (symlink, akan dibuat nanti)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env (copy dari .env.shared-hosting)
├── artisan
├── composer.json
└── composer.lock
```

## ⚙️ KONFIGURASI SETELAH UPLOAD

### STEP 4: Setup Environment File

1. Rename `.env.shared-hosting` menjadi `.env`
2. Edit `.env` file dengan data hosting Anda:

```env
APP_NAME="Desa Banyukambang"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://DOMAIN-ANDA.com

# Database dari hosting provider
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_hosting
DB_USERNAME=username_database_hosting
DB_PASSWORD=password_database_hosting

# File system
FILESYSTEM_DISK=public
```

### STEP 5: Setup Database

1. Buat database MySQL di cPanel
2. Catat nama database, username, password
3. Update `.env` dengan data database

### STEP 6: Setup File Permissions

Melalui cPanel File Manager, set permissions:

```
📁 storage/ → 755 (recursive)
📁 bootstrap/cache/ → 755 (recursive)
📄 .env → 644
📄 All other files → 644
📁 All other folders → 755
```

### STEP 7: Run Initial Commands

Jika hosting support SSH/Terminal:

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Cache optimization
php artisan config:cache
php artisan optimize
```

Jika TIDAK ada SSH, lakukan via cPanel Terminal atau skip dulu.

## 🛠️ TROUBLESHOOTING COMMON ISSUES

### ❌ "500 Internal Server Error"

```
✅ Check file permissions (755 untuk folder, 644 untuk file)
✅ Check .env database credentials
✅ Check storage/ folder exists dan writable
✅ Check error_log di cPanel untuk detail error
```

### ❌ "Laravel Page Not Found"

```
✅ Pastikan index.php dari Laravel public/ folder ada di root
✅ Pastikan .htaccess dari Laravel public/ folder ada di root
✅ Check mod_rewrite enabled di hosting
```

### ❌ "Database Connection Failed"

```
✅ Verify database name, username, password di .env
✅ Pastikan database sudah dibuat di cPanel
✅ Use 'localhost' sebagai DB_HOST (99% hosting)
✅ Contact hosting support untuk connection details
```

### ❌ "Storage Link Failed"

```
Manual create symlink:
1. Di cPanel File Manager
2. Create folder 'storage' di public_html/
3. Atau manual copy storage/app/public/* ke public_html/storage/
```

## ✅ VERIFICATION CHECKLIST

Setelah upload, test ini:

### Frontend Test

- [ ] Homepage load: `https://domain-anda.com`
- [ ] No 500 errors
- [ ] CSS/JS assets load properly
- [ ] Images display correctly

### Admin Test

- [ ] Admin login: `https://domain-anda.com/admin`
- [ ] Filament dashboard accessible
- [ ] Can login with credentials

### Functionality Test

- [ ] File upload works (test di UMKM atau Berita)
- [ ] Database operations work
- [ ] Forms submit successfully
- [ ] No PHP errors in logs

## 🎉 POST-DEPLOYMENT

### Performance Monitoring

```bash
# Check logs regularly
tail storage/logs/laravel.log

# Monitor performance via cPanel metrics
Check: CPU usage, Memory usage, I/O stats
```

### Backup Strategy

```
Setup cPanel backup:
- Weekly full backup
- Daily database backup
- Monthly file backup
```

### Security

```
✅ Ensure HTTPS is active
✅ Regular Laravel updates
✅ Monitor access logs
✅ Keep .env file secure
```

---

## 📞 NEED HELP?

### Hosting Support

Contact your hosting provider for:

- PHP version verification (need 8.2+)
- Database connection issues
- File permission problems
- .htaccess/mod_rewrite issues

### Laravel Issues

Check:

- `storage/logs/laravel.log` for application errors
- cPanel error logs for server issues
- Browser developer console for frontend issues

---

🎯 **READY TO UPLOAD!** Follow this guide step by step untuk successful deployment.

Good luck! 🚀

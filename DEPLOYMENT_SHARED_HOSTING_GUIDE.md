# Panduan Deployment Laravel ke Shared Hosting

## 🚀 Pilihan Deployment

### Opsi 1: All-in-One (Semua file di public_html)

❌ **TIDAK DIREKOMENDASIKAN** - Kurang aman karena file Laravel bisa diakses publik

### Opsi 2: Secure (File Laravel di luar public_html)

✅ **DIREKOMENDASIKAN** - Lebih aman, file Laravel tidak bisa diakses publik

## 📁 Struktur Opsi 2 (Recommended)

```
public_html/
├── index.php (modified - gunakan index-shared-hosting.php)
├── .htaccess (gunakan .htaccess-shared-hosting-secure)
├── css/ (hasil build dari npm run build)
├── js/ (hasil build dari npm run build)
├── images/
├── storage/ -> symbolic link ke ../laravel/storage/app/public/

laravel/ (di luar public_html - AMAN)
├── app/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env (konfigurasi production)
├── artisan
└── composer.json
```

## ⚙️ Langkah-langkah Deployment

### 1. Persiapan Lokal

```bash
# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Upload Files ke Hosting

#### Untuk Opsi 2 (Recommended):

1. **Upload semua file Laravel ke folder `laravel/` (di luar public_html)**
2. **Copy file ke public_html:**

   ```bash
   # Copy hasil build
   public_html/css/ <- copy dari public/build/assets/
   public_html/js/  <- copy dari public/build/assets/

   # Copy & rename file khusus
   public_html/index.php <- copy dari index-shared-hosting.php
   public_html/.htaccess <- copy dari .htaccess-shared-hosting-secure
   ```

### 3. Konfigurasi .env untuk Production

```dotenv
APP_NAME="Village Web Banyukambang"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://banyukambang.desa.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_hosting
DB_USERNAME=username_database
DB_PASSWORD=password_database

# File Storage
FILESYSTEM_DISK=public

# Cache & Session (untuk shared hosting)
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Mail (sesuai hosting)
MAIL_MAILER=smtp
MAIL_HOST=mail.banyukambang.desa.id
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=noreply@banyukambang.desa.id
MAIL_PASSWORD=your_email_password

# Asset URL (sesuai domain)
ASSET_URL=https://banyukambang.desa.id
```

### 4. Buat Storage Symlink

Jika ada akses SSH:

```bash
cd public_html
ln -s ../laravel/storage/app/public storage
```

Jika tidak ada SSH, buat manual:

1. Buat folder `storage` di `public_html`
2. Copy isi dari `laravel/storage/app/public/` ke `public_html/storage/`

### 5. Set Permissions

```bash
chmod -R 755 laravel/storage/
chmod -R 755 laravel/bootstrap/cache/
chmod 644 laravel/.env
```

### 6. Import Database

1. Buat database di hosting panel
2. Import SQL dump atau jalankan migration (jika ada SSH):
   ```bash
   cd laravel
   php artisan migrate --force
   ```

## 🛠️ Troubleshooting

### Error 500

- Cek permissions: `chmod -R 755 storage/`
- Cek .env sesuai hosting
- Lihat error log di hosting panel

### CSS/JS Tidak Load

- Pastikan build sudah di-upload ke public_html/css & public_html/js
- Cek ASSET_URL di .env
- Cek path di config/app.php

### File Upload Error

- Pastikan folder storage writable
- Cek storage symlink
- Buat folder: `storage/app/public/umkm/logos/` dan `storage/app/public/umkm/galeri/`

### Filament Admin 403

- Pastikan User model implements FilamentUser
- Cek canAccessPanel() method returns true
- Clear config cache: `php artisan config:clear`

## ✅ Checklist Final

- [ ] Files uploaded sesuai struktur Opsi 2
- [ ] .env configured untuk production
- [ ] Database imported & configured
- [ ] Storage symlink created
- [ ] Permissions set correctly (755/644)
- [ ] SSL certificate installed
- [ ] Test website loading: https://yourdomain.com
- [ ] Test admin panel: https://yourdomain.com/admin
- [ ] Test file upload functionality
- [ ] Test UMKM pages and galleries

## 🎯 Files yang Digunakan

- `public_html/index.php` <- gunakan `index-shared-hosting.php`
- `public_html/.htaccess` <- gunakan `.htaccess-shared-hosting-secure`
- `laravel/.env` <- copy dari `.env.production` dan sesuaikan

## 📞 Support Hosting yang Direkomendasikan

- **Hostinger** - Support Laravel, Node.js, SSH ✅
- **Niagahoster** - Support Laravel, PHP 8+, cPanel ✅
- **DomainRacer** - Support Laravel frameworks ✅
- **Dewaweb** - Support Laravel, good performance ✅

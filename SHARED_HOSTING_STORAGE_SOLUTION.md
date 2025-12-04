# 🔧 PANDUAN LENGKAP MENGATASI GAMBAR 404 DI SHARED HOSTING

## 🚨 **PROBLEM**: kaur-umum.jpg, sekretaris-desa.jpg, dll tidak tampil (404 error)

### **PENYEBAB**:

1. **Storage symlink tidak berfungsi** di shared hosting
2. **Path `/storage/` tidak accessible** dari web
3. **File tersimpan di `storage/app/public/`** tapi tidak bisa diakses publik

## ✅ **SOLUSI LENGKAP**

### **METODE 1: Quick Fix Manual (TERCEPAT)**

#### 1. Via cPanel File Manager

```bash
# Masuk ke cPanel > File Manager
# Navigasi ke public_html/

# 1. Buat folder storage
mkdir storage

# 2. Buat subfolder yang diperlukan
mkdir storage/umkm
mkdir storage/umkm/logos
mkdir storage/umkm/galeri
mkdir storage/berita
mkdir storage/galeri
mkdir storage/ppid-dokumen
mkdir storage/struktur-organisasi

# 3. Set permissions ke 755
chmod 755 storage -R
```

#### 2. Copy Files yang Sudah Ada

```bash
# Copy semua file dari laravel/storage/app/public/
# ke public_html/storage/

# Contoh struktur:
public_html/storage/umkm/logos/kaur-umum.jpg
public_html/storage/umkm/logos/sekretaris-desa.jpg
public_html/storage/berita/01KBHPRE7FTT80W1ZWHPPBN9AT.jpg
public_html/storage/struktur-organisasi/kepala-desa.jpg
```

### **METODE 2: Automatic Sync (RECOMMENDED)**

#### 1. Update .env

```env
# Copy .env.shared-hosting-fixed ke .env
# Update dengan data hosting real:

SHARED_HOSTING_MODE=true
FILESYSTEM_DISK=public_shared_hosting
MEDIA_DISK_DRIVER=public_shared_hosting
APP_URL=https://your-real-domain.com

# Database real credentials
DB_DATABASE=your_real_database
DB_USERNAME=your_real_username
DB_PASSWORD=your_real_password
```

#### 2. Jalankan Sync Command

```bash
# Via SSH atau terminal hosting
cd /path/to/laravel

# Initial setup (jalankan sekali)
php artisan storage:sync-shared-hosting --initial

# Sync files yang sudah ada
php artisan storage:sync-shared-hosting
```

#### 3. Test Upload Baru

Setelah sync, upload gambar baru akan otomatis tersimpan di:

- `storage/app/public/` (source)
- `public_html/storage/` (public access) ✅

### **METODE 3: Manual Script (Jika No SSH)**

Jika tidak ada akses SSH, buat file PHP untuk sync manual.

## 🧪 **TESTING**

### 1. Test Akses File

```bash
# Coba akses langsung di browser:
https://your-domain.com/storage/umkm/logos/kaur-umum.jpg
https://your-domain.com/storage/berita/01KBHPRE7FTT80W1ZWHPPBN9AT.jpg
```

### 2. Cek Storage Status

```bash
php artisan storage:sync-shared-hosting
# Akan show tabel status sync
```

### 3. Test Upload Baru

- Login ke admin panel
- Upload gambar baru via Filament
- Cek apakah muncul di website

## ⚠️ **TROUBLESHOOTING**

### **Gambar Masih 404**

```bash
# 1. Cek path di browser network tab
# 2. Pastikan file exists di public_html/storage/
# 3. Cek permissions: chmod 755 storage/ -R
# 4. Clear browser cache
```

### **Upload Error**

```bash
# 1. Cek folder writable: chmod 755 public_html/storage/ -R
# 2. Cek disk space hosting
# 3. Cek .env FILESYSTEM_DISK=public_shared_hosting
```

### **Sync Command Error**

```bash
# 1. Cek SHARED_HOSTING_MODE=true di .env
# 2. Pastikan path SHARED_HOSTING_STORAGE_ROOT benar
# 3. Cek logs: tail storage/logs/laravel.log
```

## 🎯 **FILES MODIFIED**

1. **config/filesystems.php** - Added `public_shared_hosting` disk
2. **app/Services/MediaStorageService.php** - Auto sync after upload
3. **app/Services/SharedHostingStorageService.php** - Sync service
4. **app/Console/Commands/SyncSharedHostingStorage.php** - Artisan command
5. **.env.shared-hosting-fixed** - Environment template

## 📋 **DEPLOYMENT CHECKLIST**

- [ ] Upload files sesuai struktur
- [ ] Copy .env.shared-hosting-fixed ke .env
- [ ] Update .env dengan credentials real
- [ ] Buat folder public_html/storage/ manually
- [ ] Set permissions 755 untuk storage/
- [ ] Run: `php artisan storage:sync-shared-hosting --initial`
- [ ] Test akses: https://domain.com/storage/test-file.jpg
- [ ] Test upload gambar baru via admin
- [ ] Verify gambar tampil di frontend website

## 🚀 **NEXT STEPS**

1. **Implement salah satu metode di atas**
2. **Test dengan upload gambar baru**
3. **Monitor logs untuk error**
4. **Setup automated sync untuk future uploads**

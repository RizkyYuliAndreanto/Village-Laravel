# 🔧 SOLUSI STORAGE GAMBAR SHARED HOSTING

## 🚨 **MASALAH**: Gambar upload tidak tampil (404 error)

### **Root Cause:**

- Storage symlink tidak bekerja di shared hosting
- Path `/storage/` tidak ada atau tidak accessible
- Konfigurasi filesystem masih pointing ke local

## ✅ **SOLUSI LENGKAP**

### **Metode 1: Manual Copy (PALING MUDAH)**

#### 1. Struktur Folder di Shared Hosting

```
public_html/
├── index.php
├── .htaccess
├── css/
├── js/
├── storage/ (BUAT MANUAL - BUKAN SYMLINK)
│   ├── umkm/
│   │   ├── logos/
│   │   └── galeri/
│   ├── berita/
│   ├── galeri/
│   └── ppid-dokumen/

laravel/ (di luar public_html)
├── storage/
│   └── app/
│       └── public/ (file asli disimpan disini)
```

#### 2. Setup Manual di cPanel File Manager

```bash
# 1. Buat folder storage di public_html
mkdir public_html/storage

# 2. Buat subfolder yang diperlukan
mkdir public_html/storage/umkm
mkdir public_html/storage/umkm/logos
mkdir public_html/storage/umkm/galeri
mkdir public_html/storage/berita
mkdir public_html/storage/galeri
mkdir public_html/storage/ppid-dokumen

# 3. Set permissions
chmod 755 public_html/storage -R
```

#### 3. Copy File Upload Otomatis

Tambahkan script PHP untuk sync file otomatis setiap upload.

### **Metode 2: Update Filesystem Config**

Ubah konfigurasi Laravel untuk langsung save ke public_html/storage

### **Metode 3: Menggunakan Subdomain Storage**

Setup subdomain khusus untuk storage files.

## 📝 **IMPLEMENTASI**

### **A. Update .env untuk Shared Hosting**

```env
# Filesystem Configuration
FILESYSTEM_DISK=public_shared_hosting
APP_URL=https://your-domain.com

# Force storage URL ke public_html/storage
STORAGE_URL=https://your-domain.com/storage
```

### **B. Update config/filesystems.php**

Tambahkan disk baru untuk shared hosting.

### **C. Update MediaStorageService**

Modifikasi service untuk handle shared hosting storage.

### **D. Automatic Sync Script**

Buat script untuk otomatis sync file dari storage/app/public ke public_html/storage

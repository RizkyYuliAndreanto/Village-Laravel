# 🚀 Quick Start Guide - UMKM Blade Templates

## 📋 Panduan Cepat untuk Teman Developer

### 1. Persiapan Awal

```bash
# Pastikan di root directory Laravel
cd d:\PROJECT\Laravel-web\Village-web

# Install dependencies (jika belum)
composer install
npm install

# Copy environment
cp .env.example .env

# Generate key
php artisan key:generate

# Setup database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=village_web
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Setup Database

```bash
# Buat database 'village_web' di MySQL

# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data sample
php artisan db:seed --class=KategoriUmkmSeeder
php artisan db:seed --class=UmkmSeeder
```

### 3. Testing System

```bash
# Start server
php artisan serve

# Akses di browser:
http://localhost:8000/test-umkm
```

### 4. URL yang Tersedia

| URL                     | Deskripsi                       |
| ----------------------- | ------------------------------- |
| `/umkm`                 | Daftar semua UMKM dengan filter |
| `/umkm/kategori/{slug}` | UMKM per kategori               |
| `/umkm/{slug}`          | Detail UMKM                     |
| `/test-umkm`            | Testing system                  |

### 5. File yang Sudah Dibuat

#### Backend (Controller)

-   ✅ `app/Http/Controllers/Frontend/UmkmController.php`
-   ✅ `app/Http/Controllers/Frontend/TestUmkmController.php`

#### Frontend (Views)

-   ✅ `resources/views/frontend/layout.blade.php`
-   ✅ `resources/views/frontend/umkm/index.blade.php`
-   ✅ `resources/views/frontend/umkm/show.blade.php`
-   ✅ `resources/views/frontend/umkm/kategori.blade.php`

#### Routes

-   ✅ `routes/web.php` (updated with UMKM routes)

#### Documentation

-   ✅ `DOKUMENTASI-BLADE-UMKM.md`

### 6. Cara Mengambil Data di Blade

#### Contoh Sederhana:

```php
<!-- Controller -->
$umkms = Umkm::with('kategori')->paginate(12);
return view('frontend.umkm.index', compact('umkms'));

<!-- Blade View -->
@foreach($umkms as $umkm)
    <h3>{{ $umkm->nama }}</h3>
    <p>Kategori: {{ $umkm->kategori->nama_kategori }}</p>
@endforeach
```

### 7. Troubleshooting

#### Error: "Class not found"

```bash
composer dump-autoload
```

#### Error: "View not found"

```bash
# Pastikan file view ada di:
resources/views/frontend/umkm/index.blade.php
```

#### Error: "Route not defined"

```bash
php artisan route:cache
php artisan route:clear
```

### 8. Customization

#### Menambah Field Baru:

1. Buat migration: `php artisan make:migration add_field_to_umkm_table`
2. Update model Umkm.php
3. Update view untuk menampilkan field baru

#### Menambah Filter Baru:

1. Update method `index()` di UmkmController
2. Update form filter di `index.blade.php`

### 9. Production Ready

#### Optimizations:

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

#### Remove Testing:

-   Hapus route testing dari `web.php`
-   Hapus `TestUmkmController.php`

### 10. Next Steps

1. ✅ System sudah siap pakai
2. 🎨 Customize CSS/styling sesuai kebutuhan
3. 📱 Tambah responsive design
4. 🔍 Implementasi search advanced
5. 📊 Tambah analytics/statistics
6. 🖼️ Upload image system
7. 📧 Contact form integration

---

## 📞 Support

Jika ada pertanyaan, cek:

1. File `DOKUMENTASI-BLADE-UMKM.md` untuk dokumentasi lengkap
2. Testing URL: `http://localhost:8000/test-umkm`
3. Laravel documentation: https://laravel.com/docs

**Happy Coding!** 🎉

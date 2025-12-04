# 🔥 SOLUSI SIMPLE - SHARED HOSTING STORAGE (TANPA COMMAND)

## 🎯 **SOLUSI TERCEPAT - LANGSUNG PAKAI**

### **METODE 1: Override di index.php (PALING SIMPLE)**

Tambahkan di `public_html/index.php` sebelum bootstrap Laravel:

```php
<?php
// Shared hosting storage fix - TAMBAHKAN INI DI ATAS BOOTSTRAP
if (!file_exists(__DIR__.'/storage')) {
    mkdir(__DIR__.'/storage', 0755, true);
    mkdir(__DIR__.'/storage/umkm', 0755, true);
    mkdir(__DIR__.'/storage/umkm/logos', 0755, true);
    mkdir(__DIR__.'/storage/umkm/galeri', 0755, true);
    mkdir(__DIR__.'/storage/berita', 0755, true);
    mkdir(__DIR__.'/storage/galeri', 0755, true);
    mkdir(__DIR__.'/storage/ppid-dokumen', 0755, true);
    mkdir(__DIR__.'/storage/struktur-organisasi', 0755, true);
}

// Override storage URL untuk shared hosting
define('STORAGE_PATH', __DIR__.'/storage');

// Bootstrap Laravel
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../laravel/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel/bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture())->send();
$kernel->terminate($request, $response);
```

### **METODE 2: AppServiceProvider Override (RECOMMENDED)**

Edit `app/Providers/AppServiceProvider.php`:

```php
public function boot()
{
    // Shared hosting storage fix
    if (env('SHARED_HOSTING_MODE', false)) {
        config([
            'filesystems.disks.public.root' => public_path('storage'),
            'filesystems.disks.public.url' => config('app.url') . '/storage',
        ]);

        // Auto create directories
        $directories = [
            'umkm/logos', 'umkm/galeri', 'berita',
            'galeri', 'ppid-dokumen', 'struktur-organisasi'
        ];

        foreach ($directories as $dir) {
            $path = public_path('storage/' . $dir);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }
}
```

### **METODE 3: Simple .env Override (LANGSUNG JALAN)**

Cukup tambahkan ini di `.env`:

```env
# Shared Hosting Fix
SHARED_HOSTING_MODE=true
STORAGE_PUBLIC_PATH=/home/username/public_html/storage
```

Lalu buat file `config/shared-hosting.php`:

```php
<?php
return [
    'enabled' => env('SHARED_HOSTING_MODE', false),
    'storage_path' => env('STORAGE_PUBLIC_PATH', public_path('storage')),
    'auto_create_dirs' => true,
];
```

## 🚀 **IMPLEMENTASI LANGSUNG**

### **STEP 1: Pilih Salah Satu Metode**

- Metode 1: Edit index.php (paling simple)
- Metode 2: Edit AppServiceProvider (recommended)
- Metode 3: Config file approach

### **STEP 2: Manual Copy (SEKALI AJA)**

```bash
# Via cPanel File Manager:
# Copy dari: laravel/storage/app/public/
# Ke: public_html/storage/

# Struktur hasil:
public_html/storage/umkm/logos/kaur-umum.jpg ✅
public_html/storage/berita/01KBHPRE7FTT80W1ZWHPPBN9AT.jpg ✅
```

### **STEP 3: Set .env**

```env
SHARED_HOSTING_MODE=true
APP_URL=https://your-domain.com
```

### **STEP 4: Upload & Test**

Upload files → Test `https://domain.com/storage/umkm/logos/kaur-umum.jpg`

## ✅ **NO COMMAND NEEDED - LANGSUNG JALAN!**

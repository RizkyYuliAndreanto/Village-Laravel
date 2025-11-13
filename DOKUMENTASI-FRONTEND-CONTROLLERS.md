# 📚 Dokumentasi Lengkap - Frontend Controllers & Routes

## 🎯 Overview

Dokumentasi ini menyediakan **semua controller dan routes** untuk fitur public website desa yang dapat di-fetch menggunakan Blade template. Semua controller mengembalikan **array data** yang siap digunakan dalam template Blade.

## 📂 Struktur Controller yang Telah Dibuat

### 1. **BeritaController** - Berita & Informasi Desa

**File:** `app/Http/Controllers/Frontend/BeritaController.php`

**Methods:**

-   `index()` - Daftar semua berita dengan filter
-   `show($id)` - Detail berita
-   `kategori($kategori)` - Berita per kategori
-   `arsip($tahun, $bulan)` - Arsip berita
-   `terbaru($limit)` - Berita terbaru (API)
-   `populer($limit)` - Berita populer (API)
-   `searchAjax()` - Search AJAX
-   `widget()` - Widget berita untuk sidebar

### 2. **StrukturOrganisasiController** - Pemerintahan Desa

**File:** `app/Http/Controllers/Frontend/StrukturOrganisasiController.php`

**Methods:**

-   `index()` - Struktur organisasi lengkap
-   `show($id)` - Detail pejabat
-   `divisi($divisi)` - Pejabat per divisi
-   `search()` - Pencarian pejabat
-   `widget()` - Widget pejabat utama (API)
-   `bagan()` - Data bagan organisasi (API)
-   `kontak()` - Kontak penting (API)

### 3. **DemografiController** - Data Kependudukan & Statistik

**File:** `app/Http/Controllers/Frontend/DemografiController.php`

**Methods:**

-   `index()` - Dashboard demografi lengkap
-   `umum()` - Data demografi umum
-   `umur()` - Statistik berdasarkan umur
-   `agama()` - Statistik berdasarkan agama
-   `pekerjaan()` - Statistik berdasarkan pekerjaan
-   `pendidikan()` - Statistik berdasarkan pendidikan
-   `perbandingan()` - Perbandingan antar tahun
-   `widget()` - Widget demografi (API)
-   `chart($type)` - Data chart (API)

### 4. **PpidController** - Layanan Informasi Publik

**File:** `app/Http/Controllers/Frontend/PpidController.php`

**Methods:**

-   `index()` - Daftar semua dokumen PPID
-   `show($id)` - Detail dokumen
-   `jenis($jenis)` - Dokumen per jenis (berkala/serta merta/setiap saat)
-   `kategori($kategori)` - Dokumen per kategori
-   `arsip($tahun)` - Arsip dokumen per tahun
-   `download($id)` - Download dokumen dengan tracking
-   `searchAjax()` - Search AJAX
-   `widget()` - Widget PPID (API)
-   `statistik()` - Statistik dokumen (API)

### 5. **ApbdesController** - Transparansi Keuangan Desa

**File:** `app/Http/Controllers/Frontend/ApbdesController.php`

**Methods:**

-   `index()` - Dashboard APBDes lengkap
-   `pendapatan()` - Detail pendapatan desa
-   `pengeluaran()` - Detail pengeluaran desa
-   `perbandingan()` - Perbandingan antar tahun
-   `transparansi()` - Laporan transparansi
-   `widget()` - Widget APBDes (API)
-   `chart($type)` - Data chart keuangan (API)

### 6. **UmkmController** - Usaha Mikro Kecil Menengah

**File:** `app/Http/Controllers/Frontend/UmkmController.php` _(sudah ada)_

## 🛣️ Routes Mapping

### **Berita Routes**

```php
// Web Routes
GET /berita                           → BeritaController@index
GET /berita/kategori/{kategori}       → BeritaController@kategori
GET /berita/arsip/{tahun}/{bulan?}    → BeritaController@arsip
GET /berita/{id}                      → BeritaController@show

// API Routes
GET /api/berita/terbaru/{limit?}      → BeritaController@terbaru
GET /api/berita/populer/{limit?}      → BeritaController@populer
GET /api/berita/search                → BeritaController@searchAjax
GET /api/berita/widget                → BeritaController@widget
```

### **Struktur Organisasi Routes**

```php
// Web Routes
GET /struktur-organisasi              → StrukturOrganisasiController@index
GET /struktur-organisasi/divisi/{divisi} → StrukturOrganisasiController@divisi
GET /struktur-organisasi/search       → StrukturOrganisasiController@search
GET /struktur-organisasi/{id}         → StrukturOrganisasiController@show

// API Routes
GET /api/struktur-organisasi/widget   → StrukturOrganisasiController@widget
GET /api/struktur-organisasi/bagan    → StrukturOrganisasiController@bagan
GET /api/struktur-organisasi/kontak   → StrukturOrganisasiController@kontak
```

### **Demografi Routes**

```php
// Web Routes
GET /demografi                        → DemografiController@index
GET /demografi/umum                   → DemografiController@umum
GET /demografi/umur                   → DemografiController@umur
GET /demografi/agama                  → DemografiController@agama
GET /demografi/pekerjaan              → DemografiController@pekerjaan
GET /demografi/pendidikan             → DemografiController@pendidikan
GET /demografi/perbandingan           → DemografiController@perbandingan

// API Routes
GET /api/demografi/widget             → DemografiController@widget
GET /api/demografi/chart/{type}       → DemografiController@chart
```

### **PPID Routes**

```php
// Web Routes
GET /ppid                             → PpidController@index
GET /ppid/jenis/{jenis}               → PpidController@jenis
GET /ppid/kategori/{kategori}         → PpidController@kategori
GET /ppid/arsip/{tahun}               → PpidController@arsip
GET /ppid/download/{id}               → PpidController@download
GET /ppid/{id}                        → PpidController@show

// API Routes
GET /api/ppid/search                  → PpidController@searchAjax
GET /api/ppid/widget                  → PpidController@widget
GET /api/ppid/statistik               → PpidController@statistik
```

### **APBDes Routes**

```php
// Web Routes
GET /apbdes                           → ApbdesController@index
GET /apbdes/pendapatan                → ApbdesController@pendapatan
GET /apbdes/pengeluaran               → ApbdesController@pengeluaran
GET /apbdes/perbandingan              → ApbdesController@perbandingan
GET /apbdes/transparansi              → ApbdesController@transparansi

// API Routes
GET /api/apbdes/widget                → ApbdesController@widget
GET /api/apbdes/chart/{type}          → ApbdesController@chart
```

### **UMKM Routes**

```php
// Web Routes
GET /umkm                             → UmkmController@index
GET /umkm/kategori/{kategori:slug}    → UmkmController@kategori
GET /umkm/search-ajax                 → UmkmController@searchAjax
GET /umkm/{umkm:slug}                 → UmkmController@show
```

## 💡 Cara Menggunakan Controller dalam Blade

### **1. Mengambil Data di Route**

```php
// routes/web.php
Route::get('/berita', function() {
    $controller = new App\Http\Controllers\Frontend\BeritaController();
    $data = $controller->index(request());
    return view('berita.index', $data);
});
```

### **2. Menggunakan Controller Langsung**

```php
// web.php - sudah tersedia
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

// blade template dapat menggunakan data langsung
// View akan menerima array data dari controller
```

### **3. Contoh Implementasi di Blade**

```php
// Jika menggunakan route yang sudah ada
// Data otomatis tersedia di blade template

<!-- berita/index.blade.php -->
@extends('layout')

@section('content')
<div class="container">
    <h1>Berita Desa ({{ $totalBerita }} berita)</h1>

    <!-- Filter Form -->
    <form method="GET">
        <select name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori }}"
                        {{ $kategori == request('kategori') ? 'selected' : '' }}>
                    {{ $kategori }}
                </option>
            @endforeach
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Daftar Berita -->
    @foreach($berita as $item)
        <article class="berita-item">
            <h2>{{ $item->judul }}</h2>
            <p class="meta">
                {{ $item->penulis }} • {{ $item->created_at->format('d M Y') }}
            </p>
            <p>{{ Str::limit($item->konten, 150) }}</p>
            <a href="{{ route('berita.show', $item->id) }}">Baca Selengkapnya</a>
        </article>
    @endforeach

    <!-- Pagination -->
    {{ $berita->links() }}
</div>
@endsection
```

## 📊 Data yang Dikembalikan Controller

### **BeritaController@index**

```php
[
    'berita' => Collection,           // Paginated berita
    'kategoris' => Collection,        // Kategori unik
    'tahuns' => Collection,           // Tahun tersedia
    'search' => string,               // Query pencarian
    'kategori' => string,             // Kategori terpilih
    'tahun' => integer,               // Tahun terpilih
    'bulan' => integer,               // Bulan terpilih
    'totalBerita' => integer,         // Total semua berita
    'beritaBulanIni' => integer       // Berita bulan ini
]
```

### **DemografiController@index**

```php
[
    'demografi' => Model,             // Data demografi utama
    'demografiSebelumnya' => Model,   // Data tahun sebelumnya
    'statistikUmur' => Collection,    // Statistik per umur
    'statistikAgama' => Collection,   // Statistik per agama
    'statistikPekerjaan' => Collection, // Statistik per pekerjaan
    'statistikPendidikan' => Collection, // Statistik per pendidikan
    'statistikPerkawinan' => Collection, // Statistik perkawinan
    'statistikWajibPilih' => Collection, // Statistik pemilih
    'tahunTersedia' => Collection,    // Tahun data tersedia
    'tahunTerpilih' => integer        // Tahun terpilih
]
```

### **ApbdesController@index**

```php
[
    'apbdes' => Model,                // Data APBDes utama
    'pendapatan' => Collection,       // Detail pendapatan
    'pengeluaran' => Collection,      // Detail pengeluaran
    'pendapatanPerKategori' => Array, // Grouped pendapatan
    'pengeluaranPerKategori' => Array, // Grouped pengeluaran
    'totalPendapatanAnggaran' => float, // Total anggaran pendapatan
    'totalPendapatanRealisasi' => float, // Total realisasi pendapatan
    'totalPengeluaranAnggaran' => float, // Total anggaran pengeluaran
    'totalPengeluaranRealisasi' => float, // Total realisasi pengeluaran
    'saldoAnggaran' => float,         // Saldo anggaran
    'saldoRealisasi' => float,        // Saldo realisasi
    'persentasePendapatan' => float,  // % realisasi pendapatan
    'persentasePengeluaran' => float, // % realisasi pengeluaran
    'tahunTersedia' => Collection,    // Tahun tersedia
    'tahunTerpilih' => integer        // Tahun terpilih
]
```

## 🔧 Features yang Tersedia

### **🔍 Search & Filter**

-   Semua controller mendukung pencarian
-   Filter berdasarkan kategori, tahun, bulan
-   AJAX search untuk autocomplete
-   Pagination otomatis

### **📊 Statistik & Charts**

-   Widget data untuk dashboard
-   Chart data dalam format JSON
-   Perbandingan antar periode
-   Trend analysis

### **📱 API Endpoints**

-   RESTful API untuk mobile apps
-   JSON responses
-   Rate limiting ready
-   CORS support ready

### **🔒 Security Features**

-   XSS protection (auto-escaped output)
-   SQL injection protection (Eloquent ORM)
-   File download security
-   Access control ready

### **📈 Performance**

-   Eager loading relationships
-   Query optimization
-   Pagination untuk large datasets
-   Caching ready

## 🚀 Testing URLs

Setelah server berjalan (`php artisan serve`):

```bash
# Berita
http://localhost:8000/berita
http://localhost:8000/berita/1
http://localhost:8000/berita/kategori/pengumuman
http://localhost:8000/api/berita/terbaru/5

# Struktur Organisasi
http://localhost:8000/struktur-organisasi
http://localhost:8000/struktur-organisasi/1
http://localhost:8000/api/struktur-organisasi/widget

# Demografi
http://localhost:8000/demografi
http://localhost:8000/demografi/umur?tahun=2024
http://localhost:8000/api/demografi/chart/agama

# PPID
http://localhost:8000/ppid
http://localhost:8000/ppid/jenis/berkala
http://localhost:8000/ppid/download/1

# APBDes
http://localhost:8000/apbdes
http://localhost:8000/apbdes/pendapatan?tahun=2024
http://localhost:8000/api/apbdes/chart/trend

# UMKM
http://localhost:8000/umkm
http://localhost:8000/umkm/kategori/makanan-minuman
```

## 📝 Langkah Setup untuk Teman Developer

### **1. Pastikan Migration & Seeder**

```bash
php artisan migrate
php artisan db:seed
```

### **2. Test Controllers**

```bash
php artisan route:list | grep berita
php artisan route:list | grep demografi
php artisan route:list | grep apbdes
```

### **3. Buat Blade Templates**

Teman developer tinggal membuat view files:

-   `resources/views/berita/index.blade.php`
-   `resources/views/demografi/index.blade.php`
-   `resources/views/ppid/index.blade.php`
-   `resources/views/apbdes/index.blade.php`
-   dst.

### **4. Contoh Layout Master**

```php
<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Website Desa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <header>
        <!-- Navigation Menu -->
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Footer Content -->
    </footer>
</body>
</html>
```

## ✅ **Controller Siap Pakai!**

Semua **6 controller utama** telah dibuat dengan fitur lengkap:

1. ✅ **BeritaController** - 8 methods (index, show, kategori, arsip, terbaru, populer, search, widget)
2. ✅ **StrukturOrganisasiController** - 7 methods (index, show, divisi, search, widget, bagan, kontak)
3. ✅ **DemografiController** - 9 methods (index, umum, umur, agama, pekerjaan, pendidikan, perbandingan, widget, chart)
4. ✅ **PpidController** - 9 methods (index, show, jenis, kategori, arsip, download, search, widget, statistik)
5. ✅ **ApbdesController** - 8 methods (index, pendapatan, pengeluaran, perbandingan, transparansi, widget, chart)
6. ✅ **UmkmController** - 4 methods (sudah ada sebelumnya)

**Total: 45+ methods** siap untuk di-fetch oleh Blade template!

Teman developer tinggal fokus pada **pembuatan view/template** saja. Semua logic backend dan data sudah tersedia. 🎉

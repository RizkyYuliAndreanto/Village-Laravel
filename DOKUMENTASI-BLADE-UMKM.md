# 📚 Dokumentasi Blade Template - UMKM Desa

## 🎯 Pengantar

Dokumentasi ini dibuat untuk membantu teman developer memahami cara mengambil dan menampilkan data dari database menggunakan **Blade Template** (Server-Side Rendering) dalam aplikasi Laravel.

## 🏗️ Arsitektur Sistem

### Model-View-Controller (MVC) Pattern

```
┌─────────────────┐    ┌──────────────────┐    ┌─────────────────┐
│     Model       │    │    Controller    │    │      View       │
│                 │    │                  │    │                 │
│ - Umkm.php      │◄──►│ UmkmController   │◄──►│ index.blade.php │
│ - KategoriUmkm  │    │ - index()        │    │ show.blade.php  │
│                 │    │ - show()         │    │ kategori.blade  │
└─────────────────┘    │ - kategori()     │    └─────────────────┘
                       └──────────────────┘
```

## 📂 Struktur File yang Telah Dibuat

### 1. Controller (Backend Logic)

**File:** `app/Http/Controllers/Frontend/UmkmController.php`

### 2. Routes (URL Mapping)

**File:** `routes/web.php`

### 3. Views (Frontend Templates)

-   `resources/views/frontend/layout.blade.php` (Master Template)
-   `resources/views/frontend/umkm/index.blade.php` (Daftar UMKM)
-   `resources/views/frontend/umkm/show.blade.php` (Detail UMKM)
-   `resources/views/frontend/umkm/kategori.blade.php` (UMKM per Kategori)

## 🔍 Cara Kerja Blade Template

### 1. Request Flow

```
User Request → Route → Controller → Model → Database
                ↓
            Blade View ← Data ← Controller ← Model
```

### 2. Contoh Konkret - Menampilkan Daftar UMKM

#### A. Route Definition (`routes/web.php`)

```php
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
```

#### B. Controller Method (`UmkmController.php`)

```php
public function index(Request $request)
{
    // 1. Ambil parameter filter dari URL
    $search = $request->get('search');
    $kategori_id = $request->get('kategori');
    $dusun = $request->get('dusun');

    // 2. Query database dengan filter
    $umkms = Umkm::with('kategori')  // Eager loading relationship
        ->when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('pemilik', 'like', "%{$search}%");
        })
        ->when($kategori_id, function ($query, $kategori_id) {
            return $query->where('kategori_umkm_id', $kategori_id);
        })
        ->when($dusun, function ($query, $dusun) {
            return $query->where('dusun', $dusun);
        })
        ->where('status_aktif', true)
        ->orderBy('nama')
        ->paginate(12); // Pagination otomatis

    // 3. Ambil data tambahan untuk filter
    $kategoris = KategoriUmkm::orderBy('nama_kategori')->get();
    $dusuns = Umkm::distinct()->pluck('dusun')->filter()->sort();

    // 4. Hitung statistik
    $totalUmkm = Umkm::count();
    $totalKategori = KategoriUmkm::count();

    // 5. Kirim data ke view
    return view('frontend.umkm.index', compact(
        'umkms',
        'kategoris',
        'search',
        'kategori_id',
        'dusun',
        'dusuns',
        'totalUmkm',
        'totalKategori'
    ));
}
```

#### C. Blade View (`index.blade.php`)

```php
@extends('frontend.layout')

@section('title', 'Daftar UMKM')

@section('content')
<div class="container">
    <!-- Header dengan statistik -->
    <h1>UMKM Desa</h1>
    <p>Temukan {{ $totalUmkm }} UMKM dari {{ $totalKategori }} kategori</p>

    <!-- Form Filter -->
    <form method="GET">
        <input name="search" value="{{ $search }}" placeholder="Cari UMKM...">

        <select name="kategori">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}"
                        {{ $kategori_id == $kategori->id ? 'selected' : '' }}>
                    {{ $kategori->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filter</button>
    </form>

    <!-- Loop Data UMKM -->
    <div class="row">
        @forelse($umkms as $umkm)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $umkm->nama }}</h5>
                        <p>Pemilik: {{ $umkm->pemilik }}</p>
                        <p>Kategori: {{ $umkm->kategori->nama_kategori }}</p>
                        <p>{{ Str::limit($umkm->deskripsi, 100) }}</p>

                        <a href="{{ route('umkm.show', $umkm->slug) }}"
                           class="btn btn-primary">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>Tidak ada UMKM ditemukan.</p>
        @endforelse
    </div>

    <!-- Pagination otomatis -->
    {{ $umkms->links() }}
</div>
@endsection
```

## 🔗 Relationship Database

### Model Umkm (`app/Models/Umkm.php`)

```php
class Umkm extends Model
{
    // Relasi ke KategoriUmkm
    public function kategori()
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_umkm_id');
    }

    // Accessor untuk URL slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
```

### Model KategoriUmkm (`app/Models/KategoriUmkm.php`)

```php
class KategoriUmkm extends Model
{
    // Relasi balik ke UMKM
    public function umkms()
    {
        return $this->hasMany(Umkm::class, 'kategori_umkm_id');
    }
}
```

## 🎨 Template Inheritance

### Master Layout (`layout.blade.php`)

```php
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - Desa Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('umkm.index') }}">UMKM Desa</a>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('umkm.index') }}">Semua UMKM</a>
                </li>
                <!-- Loop kategori di navigation -->
                @foreach(App\Models\KategoriUmkm::all() as $kategori)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('umkm.kategori', $kategori->slug) }}">
                            {{ $kategori->icon }} {{ $kategori->nama_kategori }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-light py-4">
        <div class="container text-center">
            <p>&copy; 2024 UMKM Desa. Semua hak cipta dilindungi.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
```

## 🔧 Fitur-Fitur Blade yang Digunakan

### 1. Template Inheritance

```php
@extends('frontend.layout')     // Menggunakan layout master
@section('title', 'Halaman')   // Mengisi section title
@section('content')             // Mulai section content
    <!-- Konten halaman -->
@endsection                     // Akhiri section
```

### 2. Looping Data

```php
@foreach($umkms as $umkm)
    <div class="umkm-item">
        <h3>{{ $umkm->nama }}</h3>
        <p>{{ $umkm->deskripsi }}</p>
    </div>
@endforeach
```

### 3. Conditional Rendering

```php
@if($umkm->status_aktif)
    <span class="badge bg-success">Aktif</span>
@else
    <span class="badge bg-secondary">Tidak Aktif</span>
@endif
```

### 4. Empty State

```php
@forelse($umkms as $umkm)
    <!-- Loop item -->
@empty
    <p>Tidak ada UMKM ditemukan.</p>
@endforelse
```

### 5. Include Partial Views

```php
@include('frontend.partials.umkm-card', ['umkm' => $umkm])
```

## 🌐 URL dan Routing

### Named Routes

```php
// Definisi di routes/web.php
Route::get('/umkm', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm/{umkm:slug}', [UmkmController::class, 'show'])->name('umkm.show');

// Penggunaan di blade
<a href="{{ route('umkm.index') }}">Daftar UMKM</a>
<a href="{{ route('umkm.show', $umkm->slug) }}">{{ $umkm->nama }}</a>
```

### Route Parameters

```php
// Route dengan parameter
Route::get('/umkm/kategori/{kategori:slug}', [UmkmController::class, 'kategori'])
     ->name('umkm.kategori');

// Controller menerima parameter
public function kategori(KategoriUmkm $kategori)
{
    // $kategori sudah di-resolve otomatis berdasarkan slug
    $umkms = $kategori->umkms()->paginate(12);
    return view('frontend.umkm.kategori', compact('kategori', 'umkms'));
}
```

## 📊 Pagination Laravel

### Controller

```php
$umkms = Umkm::paginate(12); // 12 item per halaman
```

### Blade View

```php
<!-- Menampilkan data -->
@foreach($umkms as $umkm)
    <!-- Item UMKM -->
@endforeach

<!-- Link pagination otomatis -->
{{ $umkms->links() }}

<!-- Preserve GET parameters -->
{{ $umkms->appends(request()->query())->links() }}
```

## 🔍 Search dan Filter

### Form HTML

```php
<form method="GET" action="{{ route('umkm.index') }}">
    <input type="text" name="search" value="{{ request('search') }}">
    <select name="kategori">
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}"
                    {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    <button type="submit">Cari</button>
</form>
```

### Controller Logic

```php
public function index(Request $request)
{
    $query = Umkm::query();

    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('kategori')) {
        $query->where('kategori_umkm_id', $request->kategori);
    }

    $umkms = $query->paginate(12);

    return view('frontend.umkm.index', compact('umkms'));
}
```

## 🎯 Best Practices

### 1. Data Security

```php
<!-- Escape output untuk mencegah XSS -->
{{ $umkm->nama }}                    // Auto-escaped
{!! nl2br(e($umkm->deskripsi)) !!}  // Manual escape + line breaks
```

### 2. Performance Optimization

```php
// Eager Loading untuk mencegah N+1 Query
$umkms = Umkm::with('kategori')->get();

// Caching data statis
$kategoris = Cache::remember('kategoris', 3600, function () {
    return KategoriUmkm::orderBy('nama_kategori')->get();
});
```

### 3. SEO Friendly URLs

```php
// Route dengan slug parameter
Route::get('/umkm/{umkm:slug}', [UmkmController::class, 'show']);

// Model dengan slug attribute
public function getRouteKeyName()
{
    return 'slug';
}
```

## 🔧 Troubleshooting

### Error Umum & Solusi

1. **"Undefined variable"**

    ```php
    // Pastikan data di-pass dari controller
    return view('frontend.umkm.index', compact('umkms', 'kategoris'));
    ```

2. **"Trying to get property of non-object"**

    ```php
    // Gunakan optional chaining
    {{ $umkm->kategori->nama_kategori ?? 'Tidak ada kategori' }}
    ```

3. **N+1 Query Problem**
    ```php
    // Gunakan eager loading
    $umkms = Umkm::with('kategori')->get();
    ```

## 🚀 Testing Routes

### Menggunakan Browser

1. `http://localhost:8000/umkm` - Daftar semua UMKM
2. `http://localhost:8000/umkm/kategori/makanan-minuman` - UMKM kategori makanan
3. `http://localhost:8000/umkm/toko-sembako-pak-ahmad` - Detail UMKM
4. `http://localhost:8000/umkm?search=toko&kategori=1` - Search dengan filter

### Testing dengan Artisan

```bash
# Lihat semua routes
php artisan route:list

# Test specific route
php artisan route:cache
php artisan serve
```

## 📝 Langkah Setup untuk Teman Developer

### 1. Persiapan Database

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data sample
php artisan db:seed --class=KategoriUmkmSeeder
php artisan db:seed --class=UmkmSeeder
```

### 2. Testing Controller

```bash
# Buat route testing
php artisan make:controller TestController

# Test manual di TestController
public function test()
{
    $umkms = \App\Models\Umkm::with('kategori')->get();
    dd($umkms); // Debug data
}
```

### 3. Debugging Blade Views

```php
<!-- Debug variable di blade -->
@dump($umkms)

<!-- Cek isi variable -->
@if(isset($umkms))
    <p>Data UMKM tersedia: {{ $umkms->count() }} item</p>
@else
    <p>Data UMKM tidak tersedia</p>
@endif
```

## 🎉 Kesimpulan

Dengan arsitektur Blade Template ini, teman developer dapat:

1. ✅ **Mengambil data** dari database menggunakan Eloquent ORM
2. ✅ **Memproses data** di Controller dengan filter dan pagination
3. ✅ **Menampilkan data** di View menggunakan Blade syntax
4. ✅ **Membuat relasi** antar tabel dengan mudah
5. ✅ **Mengoptimalkan performa** dengan eager loading dan caching
6. ✅ **Membuat website yang SEO-friendly** dengan server-side rendering

**Keuntungan Blade Template:**

-   Server-side rendering (baik untuk SEO)
-   Syntax yang mudah dipahami
-   Terintegrasi penuh dengan Laravel
-   Performance yang optimal untuk website desa
-   Mudah di-maintain dan dikembangkan

Selamat ngoding! 🚀

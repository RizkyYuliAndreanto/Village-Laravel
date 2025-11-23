# Dokumentasi Perubahan Navbar dan Struktur Menu

## Perubahan yang Dilakukan

### ❌ **Fitur yang Dihapus**

1. **Listing** - Dihapus dari navbar dan sistem

    - Route `/listing` dihapus
    - Folder `frontend/listing/` dihapus
    - Layout `listing.blade.php` dihapus

2. **IDM** - Dihapus dari navbar dan sistem

    - Route `/idm` dihapus
    - Folder `frontend/idm/` dihapus
    - Layout `idm.blade.php` dihapus

3. **Belanja** - Diubah menjadi APBDES
    - Folder `frontend/belanja/` → `frontend/apbdes/`
    - Layout `belanja.blade.php` → `apbdes.blade.php`
    - Konten diubah dari template umum menjadi spesifik APBDES

### ✅ **Menu Navbar Baru**

```php
// Navbar sebelumnya:
Home | Profil Desa | Infografis | Listing | IDM | Berita | Belanja | PPID

// Navbar sekarang:
Home | Profil Desa | Infografis | UMKM | APBDES | Berita | PPID
```

## Struktur Folder Akhir

```
resources/views/frontend/
├── home/                    # ✅ Home dengan sections
├── profil-desa/            # ✅ Profil Desa
├── infografis/             # ✅ Infografis dengan sections
├── umkm/                   # ✅ UMKM (sudah ada)
├── apbdes/                 # ✅ APBDES (ex-belanja, diubah konten)
├── berita/                 # ✅ Berita (sudah ada)
├── ppid/                   # ✅ PPID
├── layouts/                # ✅ Layout files
└── components/             # ✅ Komponen reusable
```

## Routes yang Aktif

```php
// STATIC PAGES
Route::view('/profil-desa', 'frontend.profil-desa.index')->name('profil-desa.index');
Route::get('/infografis', [DemografiController::class, 'infografis'])->name('infografis.index');
Route::view('/belanja', 'frontend.apbdes.index')->name('belanja.index'); // APBDES

// UMKM ROUTES
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('index');
    Route::get('/kategori/{kategori:slug}', [UmkmController::class, 'kategori'])->name('kategori');
    Route::get('/{umkm:slug}', [UmkmController::class, 'show'])->name('show');
});

// BERITA ROUTES
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('index');
    Route::get('/{id}', [BeritaController::class, 'show'])->name('show');
    // ... other berita routes
});

// PPID ROUTES
Route::prefix('ppid')->name('ppid.')->group(function () {
    Route::get('/', [PpidController::class, 'index'])->name('index');
    // ... other ppid routes
});
```

## Konten APBDES

Folder `apbdes` sekarang berisi 4 section utama:

1. **Anggaran Pendapatan Desa** - Sumber dana (Dana Desa, ADD, PAD)
2. **Anggaran Belanja Desa** - Penggunaan untuk infrastruktur & pemberdayaan
3. **Laporan Keuangan Desa** - Realisasi & pertanggungjawaban
4. **Visualisasi Data APBDES** - Grafik dan chart data keuangan

## Navbar Links

```blade
<a href="{{ route('home') }}">Home</a>
<a href="{{ route('profil-desa.index') }}">Profil Desa</a>
<a href="{{ route('infografis.index') }}">Infografis</a>
<a href="{{ route('umkm.index') }}">UMKM</a>
<a href="{{ route('belanja.index') }}">APBDES</a>
<a href="{{ route('berita.index') }}">Berita</a>
<a href="{{ route('ppid.index') }}">PPID</a>
```

## Keuntungan Perubahan

### ✅ **Fokus Menu yang Relevan**

-   Menu lebih fokus pada fitur yang benar-benar digunakan
-   UMKM, APBDES, dan Berita adalah fitur utama desa
-   Menghilangkan menu yang tidak jelas fungsinya

### ✅ **Konsistensi Penamaan**

-   APBDES lebih jelas dibanding "Belanja"
-   Sesuai dengan terminologi pemerintahan desa
-   Mudah dipahami oleh pengunjung website

### ✅ **Struktur Lebih Bersih**

-   Tidak ada folder dan file yang tidak terpakai
-   Routes lebih ringkas dan focused
-   Maintenance lebih mudah

## Testing

Setelah perubahan, test semua menu navbar:

1. ✅ **Home** - `http://127.0.0.1:8000/`
2. ✅ **Profil Desa** - `http://127.0.0.1:8000/profil-desa`
3. ✅ **Infografis** - `http://127.0.0.1:8000/infografis`
4. ✅ **UMKM** - `http://127.0.0.1:8000/umkm`
5. ✅ **APBDES** - `http://127.0.0.1:8000/belanja`
6. ✅ **Berita** - `http://127.0.0.1:8000/berita`
7. ✅ **PPID** - `http://127.0.0.1:8000/ppid`

Semua menu sekarang mengarah ke fitur yang relevan dan berguna untuk website desa.

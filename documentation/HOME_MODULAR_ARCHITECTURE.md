# Home Page Modular Architecture

## Overview

Halaman home telah direfactor menjadi struktur modular dengan sections terpisah untuk memudahkan debugging dan maintenance. Setiap section memiliki file blade terpisah dan data dikelola melalui HomeController yang terintegrasi.

## Directory Structure

```
resources/views/frontend/home/
├── index.blade.php          # Alternative structure (not used)
└── sections/
    ├── hero.blade.php           # Hero section dengan CTA
    ├── profil-desa.blade.php    # Profil dan overview desa
    ├── peta-desa.blade.php      # Google Maps embed
    ├── sotk.blade.php           # Struktur Organisasi & Tatakelola
    ├── statistik-penduduk.blade.php # Data demografis tahun terbaru
    ├── apbd-desa.blade.php      # Data APBD dengan progress bars
    ├── berita-desa.blade.php    # Berita terbaru dari database
    ├── potensi-desa.blade.php   # Potensi ekonomi dan pariwisata
    └── galeri-desa.blade.php    # Galeri foto kegiatan desa
```

## Sections Detail

### 1. Hero Section (`hero.blade.php`)

**Purpose**: Welcome message dan call-to-action utama

-   **Content**: Judul, deskripsi, button menuju infografis
-   **Links**: `route('infografis.index')`
-   **Styling**: Indigo gradient background, centered layout

### 2. Profil Desa (`profil-desa.blade.php`)

**Purpose**: Overview tentang desa dan navigasi

-   **Content**: Logo desa, deskripsi singkat, action buttons
-   **Links**: `route('infografis.index')`, profil lengkap
-   **Layout**: Flex layout dengan image dan text

### 3. Peta Desa (`peta-desa.blade.php`)

**Purpose**: Menampilkan lokasi geografis desa

-   **Content**: Google Maps embed, koordinat alamat
-   **Features**: Responsive iframe, loading lazy
-   **Data**: Static coordinates untuk Desa Ngengor

### 4. SOTK (`sotk.blade.php`)

**Purpose**: Struktur organisasi dan tatakelola desa

-   **Content**: Grid cards pejabat desa
-   **Data Source**: `$sotk` dari HomeController (with fallback to dummy)
-   **Links**: `route('pemerintahan.index')`
-   **Components**: `x-card-info` untuk setiap pejabat

### 5. Statistik Penduduk (`statistik-penduduk.blade.php`)

**Purpose**: Menampilkan data demografis tahun terbaru

-   **Content**: 5 stat boxes dengan data terkini
-   **Data Source**: `$statistikPenduduk` dari StatistikController
-   **Features**: Data tahun terbaru, fallback ke dummy data
-   **Components**: `x-stat-box` dengan icons dan colors
-   **Links**: `route('infografis.index')`

### 6. APBD Desa (`apbd-desa.blade.php`)

**Purpose**: Transparansi anggaran desa

-   **Content**: Cards pendapatan & belanja dengan progress bars
-   **Data Source**: `$apbdData` dari LaporanApbdes & DetailApbdes models
-   **Features**:
    -   Progress bars untuk realisasi vs target
    -   Formatting currency Indonesian
    -   Conditional rendering (show empty state if no data)
-   **Links**: `route('apbd.index')`

### 7. Berita Desa (`berita-desa.blade.php`)

**Purpose**: Menampilkan berita dan pengumuman terbaru

-   **Content**: Grid layout dengan 6 berita terbaru
-   **Data Source**: `$berita` dari Berita model (status: published)
-   **Features**:
    -   3 berita utama (large cards)
    -   3 berita lainnya (small cards)
    -   Fallback ke dummy data
-   **Components**: `x-news-card` dengan size variants
-   **Links**: `route('berita.index')`, individual berita

### 8. Potensi Desa (`potensi-desa.blade.php`)

**Purpose**: Showcase potensi ekonomi, pariwisata, dll

-   **Content**: Grid dengan circular image frames
-   **Data Source**: `$potensiDesa` dari HomeController
-   **Features**: Category tags, responsive grid
-   **Components**: `x-circle-image-frame`
-   **Links**: `route('potensi.index')`

### 9. Galeri Desa (`galeri-desa.blade.php`)

**Purpose**: Foto kegiatan dan dokumentasi desa

-   **Content**: Grid layout 4x2 = 8 images
-   **Data Source**: `$galeri` dari HomeController
-   **Features**: Date display, responsive grid
-   **Components**: `x-image-frame`
-   **Links**: `route('galeri.index')`

## HomeController Integration

### Data Flow

```php
// HomeController::index()
1. getTahunTerbaru() → Ambil tahun data terbaru
2. getStatistikPenduduk() → Data demografis via StatistikController
3. getSOTKData() → Data pejabat desa (placeholder)
4. getAPBDData() → Data anggaran via APBD models
5. getBeritaTerbaru() → Berita published terbaru
6. getPotensiDesa() → Data potensi (placeholder)
7. getGaleriTerbaru() → Galeri foto (placeholder)
```

### Key Features

#### 1. Data Tahun Terbaru

-   Statistik penduduk menggunakan data tahun terbaru dari `TahunData`
-   Terintegrasi dengan StatistikController untuk konsistensi data
-   Fallback ke data dummy jika database kosong

#### 2. Error Handling

-   Try-catch untuk setiap data source
-   Graceful fallback ke dummy data
-   Empty state handling untuk sections tanpa data

#### 3. Model Integration

```php
// Models yang digunakan:
- TahunData: Master tahun data
- Berita: Berita dan pengumuman
- LaporanApbdes: Laporan anggaran tahunan
- DetailApbdes: Detail item anggaran
- StatistikController: Data demografis via existing controller
```

## Component Usage

### Stat Box Component

```blade
<x-stat-box
    :value="$statistikPenduduk['totalPenduduk'] ?? 0"
    label="Total Penduduk"
    icon="👥"
    color="blue" />
```

### News Card Component

```blade
<x-news-card
    title="{{ $item->judul }}"
    summary="{{ Str::limit($item->isi, 100) }}"
    date="{{ $item->created_at->format('d M Y') }}"
    image="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('images/logo-placeholder.jpg') }}"
    url="{{ route('berita.show', $item->slug) }}" />
```

### Card Info Component

```blade
<x-card-info
    title="{{ $pejabat->nama ?? 'Lorem' }}"
    summary="{{ $pejabat->jabatan ?? 'Kepala Desa' }}"
    image="{{ $pejabat->foto ? asset('storage/'.$pejabat->foto) : asset('images/logo-placeholder.jpg') }}" />
```

## Benefits

### 1. Modularity

-   Setiap section dapat diedit independently
-   Easy debugging per section
-   Reusable components

### 2. Data Integration

-   Real data dari database untuk statistik penduduk
-   Data tahun terbaru otomatis
-   Prepared untuk integrasi model lainnya

### 3. Performance

-   Conditional rendering untuk sections tanpa data
-   Lazy loading untuk images
-   Efficient database queries

### 4. Maintainability

-   Clear separation of concerns
-   Consistent naming convention
-   Documentation per section

## Development Guidelines

### Adding New Section

1. Create new file in `resources/views/frontend/home/sections/`
2. Add data method in HomeController
3. Include section in main home.blade.php
4. Test with real and dummy data

### Updating Existing Section

1. Modify individual section file
2. Update corresponding HomeController method if needed
3. Test data binding and fallbacks

### Database Integration

```php
// Untuk menambahkan model baru:
private function getNewSectionData()
{
    try {
        return NewModel::where('active', true)->get();
    } catch (\Exception $e) {
        return null; // Use dummy data in blade
    }
}
```

## Migration Path

### From Old Structure

1. ✅ Old content commented dalam file asli
2. ✅ Routes unchanged (backward compatibility)
3. ✅ Modular sections implemented
4. ✅ Data integration completed

### Future Enhancements

1. Implement remaining models (SOTK, Potensi, Galeri)
2. Add caching for performance
3. Implement admin CMS untuk content management
4. Add SEO meta tags per section

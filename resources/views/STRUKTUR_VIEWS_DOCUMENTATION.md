# Dokumentasi Struktur Views yang Telah Dirapikan (Versi Sederhana)

## Filosofi Struktur Baru

**Home** = Membutuhkan banyak sections karena ada hero section, peta desa section, APBDES section, dll.
**Modul Lain** = Cukup halaman utama (index.blade.php) dan halaman detail (show.blade.php) saja.

## Struktur Folder Akhir (Sederhana & Konsisten)

```
resources/views/frontend/
├── home/
│   ├── index.blade.php           # Main home page
│   └── sections/                 # ✅ BANYAK SECTIONS (BENAR)
│       ├── hero.blade.php        # Hero section dengan statistik
│       ├── profil-desa.blade.php # Profil dan deskripsi desa
│       ├── peta-desa.blade.php   # Peta lokasi desa
│       ├── sotk.blade.php        # Struktur organisasi
│       ├── statistik-penduduk.blade.php  # Data demografi
│       ├── apbd-desa.blade.php   # Data APBDES
│       ├── berita-desa.blade.php # Berita terbaru
│       ├── potensi-desa.blade.php # UMKM dan potensi
│       └── galeri-desa.blade.php # Galeri foto
│
├── infografis/
│   ├── index.blade.php           # Main infografis page
│   ├── partials/                 # ✅ PARTIALS UNTUK KOMPONEN
│   │   └── tahun-selector.blade.php
│   └── sections/                 # ✅ SECTIONS UNTUK CHART/GRAFIK
│       ├── demografi.blade.php   # Chart demografi
│       ├── agama.blade.php       # Chart agama
│       ├── kelompok-umur.blade.php # Chart umur
│       ├── pekerjaan.blade.php   # Chart pekerjaan
│       ├── pendidikan.blade.php  # Chart pendidikan
│       ├── perkawinan.blade.php  # Chart perkawinan
│       └── wajib-pilih.blade.php # Chart pemilih
│
├── berita/
│   ├── index.blade.php           # ✅ SEDERHANA - Satu file lengkap
│   ├── show.blade.php            # Halaman detail berita
│   └── arsip.blade.php           # Halaman arsip berita
│
├── belanja/
│   ├── index.blade.php           # ✅ MENGGUNAKAN REUSABLE COMPONENT
│   └── sections/                 # ✅ REUSABLE COMPONENT
│       └── content-section.blade.php  # Template section dengan parameter
│
├── umkm/
│   ├── index.blade.php           # ✅ SEDERHANA - Satu file lengkap
│   ├── show.blade.php            # Halaman detail UMKM
│   └── kategori.blade.php        # Halaman kategori UMKM
│
├── profil-desa/
│   └── index.blade.php           # ✅ SEDERHANA - Satu file saja
│
├── ppid/
│   └── index.blade.php           # ✅ SEDERHANA - Satu file saja
│
├── idm/
│   └── index.blade.php           # ✅ SEDERHANA - Satu file saja
│
├── listing/
│   └── index.blade.php           # ✅ SEDERHANA - Satu file saja
│
└── layouts/                      # ✅ LAYOUTS TETAP DI SINI
    ├── main.blade.php
    ├── berita.blade.php
    ├── belanja.blade.php
    └── ...
```

## Pola yang Diterapkan

### 1. **Home Page** (Banyak Sections)

```blade
@extends('frontend.layouts.main')
@section('content')
    {{-- Hero Section --}}
    @include('frontend.home.sections.hero')

    {{-- Profil Desa Section --}}
    @include('frontend.home.sections.profil-desa')

    {{-- Dan sections lainnya... --}}
@endsection
```

### 2. **Modul Biasa** (File Tunggal)

```blade
@extends('frontend.layouts.[layout]')
@section('content')
<div class="container">
    <!-- Header -->
    <div class="page-header">
        <h1>Judul Halaman</h1>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Semua content dalam satu file -->
    </div>
</div>
@endsection
```

### 3. **Belanja** (Reusable Component)

```blade
@extends('frontend.layouts.belanja')
@section('content')
    {{-- Menggunakan component dengan parameter --}}
    @include('frontend.belanja.sections.content-section', [
        'title' => 'VISI & MISI',
        'description' => '...',
        'image' => asset('images/visi.jpg')
    ])
@endsection
```

## Status Perapihan

### ✅ Selesai Dirapikan (Sederhana)

-   **home/** - 9 sections untuk berbagai bagian halaman
-   **infografis/** - Sections untuk charts/grafik
-   **berita/** - File tunggal sederhana
-   **belanja/** - Reusable component approach
-   **umkm/** - File tunggal sederhana
-   **profil-desa/** - File tunggal sederhana
-   **ppid/** - File tunggal sederhana
-   **idm/** - File tunggal sederhana
-   **listing/** - File tunggal sederhana

## Keuntungan Struktur Sederhana

### 1. **Mudah Dipahami**

-   Home: Banyak sections karena memang butuh banyak bagian
-   Modul lain: Simple, satu file untuk satu halaman
-   Tidak over-engineering

### 2. **Maintainability**

-   File tidak terpecah berlebihan
-   Mudah menemukan code yang dicari
-   Konsisten dengan kebutuhan sebenarnya

### 3. **Performance**

-   Tidak banyak include yang berlebihan
-   Loading lebih cepat
-   Optimal untuk kebutuhan

### 4. **Developer Experience**

-   Struktur sesuai dengan logika bisnis
-   Tidak membingungkan
-   Mudah onboarding developer baru

## Prinsip yang Diterapkan

### ✅ **Kapan Menggunakan Sections**

-   **Home page** - Ada banyak bagian berbeda (hero, profil, peta, dll)
-   **Infografis** - Ada banyak chart/grafik berbeda
-   **Belanja** - Ada template yang bisa digunakan berulang

### ❌ **Kapan TIDAK Menggunakan Sections**

-   **UMKM index** - Cukup satu halaman listing
-   **Berita index** - Cukup satu halaman listing
-   **Profil Desa** - Cukup satu halaman informasi
-   **PPID, IDM, Listing** - Halaman sederhana

## Convention Naming

-   **Folder**: lowercase dengan dash (kebab-case)
-   **Files**: descriptive names dengan .blade.php
-   **Layouts**: frontend.layouts.[name]
-   **Sections**: frontend.[module].sections.[section-name] (hanya jika diperlukan)

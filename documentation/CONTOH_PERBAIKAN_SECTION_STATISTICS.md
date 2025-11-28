# 🎨 CONTOH PERBAIKAN: section_statistics.blade.php

## SEBELUM PERBAIKAN (Hardcoded Colors)

```blade
{{-- Header --}}
<div class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="mb-4 md:mb-0">
            <h2 class="text-3xl font-bold mb-2 flex items-center">
                <i class="fas fa-chart-line mr-3"></i>
                Ringkasan Keuangan {{ $tahunDipilih }}
            </h2>
            <p class="text-cyan-100">Transparansi pengelolaan keuangan desa</p>
        </div>
    </div>
</div>

{{-- Total Pendapatan --}}
<div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center border border-green-200 hover:shadow-lg transition-all duration-300">
    <div class="w-16 h-16 apbdes-pendapatan rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
        <i class="fas fa-arrow-up text-2xl"></i>
    </div>
    <p class="apbdes-pendapatan-text text-sm font-bold mb-2 uppercase tracking-wide">Total Pendapatan</p>
    <p class="text-2xl font-bold apbdes-pendapatan-text mb-3">
        Rp {{ number_format($balance['total_pendapatan'] ?? 0, 0, ',', '.') }}
    </p>
    <div class="w-full apbdes-pendapatan-progress rounded-full h-2.5">
        <div class="apbdes-pendapatan-bar h-2.5 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_pendapatan'] ?? 0 }}%"></div>
    </div>
    <p class="text-xs apbdes-pendapatan-text font-medium mt-2">{{ $balance['persentase_pendapatan'] ?? 0 }}% dari Total</p>
</div>

{{-- Status Laporan --}}
<div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center border border-purple-200 hover:shadow-lg transition-all duration-300">
    <div class="w-16 h-16 bg-purple-500 text-white rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
        <i class="fas fa-file-alt text-2xl"></i>
    </div>
    <p class="text-purple-800 text-sm font-bold mb-2 uppercase tracking-wide">Status Laporan</p>
    <p class="text-lg font-bold text-purple-900 mb-3">{{ ucfirst($laporan->status) }}</p>
    <div class="flex items-center justify-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
            <i class="fas fa-calendar mr-1"></i> {{ $laporan->nama_bulan }}
        </span>
    </div>
</div>
```

## SETELAH PERBAIKAN (Global Classes)

```blade
{{-- Header --}}
<div class="apbdes-hero text-white px-8 py-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="mb-4 md:mb-0">
            <h2 class="text-3xl font-bold mb-2 flex items-center">
                <i class="fas fa-chart-line mr-3"></i>
                Ringkasan Keuangan {{ $tahunDipilih }}
            </h2>
            <p class="navbar-text-secondary">Transparansi pengelolaan keuangan desa</p>
        </div>
    </div>
</div>

{{-- Total Pendapatan --}}
<div class="apbdes-pendapatan-light rounded-xl p-6 text-center border-primary hover:shadow-lg transition-all duration-300">
    <div class="w-16 h-16 apbdes-pendapatan rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
        <i class="fas fa-arrow-up text-2xl"></i>
    </div>
    <p class="apbdes-pendapatan-text text-sm font-bold mb-2 uppercase tracking-wide">Total Pendapatan</p>
    <p class="text-2xl font-bold apbdes-pendapatan-text mb-3">
        Rp {{ number_format($balance['total_pendapatan'] ?? 0, 0, ',', '.') }}
    </p>
    <div class="w-full apbdes-pendapatan-progress rounded-full h-2.5">
        <div class="apbdes-pendapatan-bar h-2.5 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_pendapatan'] ?? 0 }}%"></div>
    </div>
    <p class="text-xs apbdes-pendapatan-text font-medium mt-2">{{ $balance['persentase_pendapatan'] ?? 0 }}% dari Total</p>
</div>

{{-- Status Laporan --}}
<div class="section-bg-alternate rounded-xl p-6 text-center border-secondary hover:shadow-lg transition-all duration-300">
    <div class="w-16 h-16 apbdes-balance rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
        <i class="fas fa-file-alt text-2xl"></i>
    </div>
    <p class="text-heading text-sm font-bold mb-2 uppercase tracking-wide">Status Laporan</p>
    <p class="text-lg font-bold text-heading mb-3">{{ ucfirst($laporan->status) }}</p>
    <div class="flex items-center justify-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold card-bg text-body">
            <i class="fas fa-calendar mr-1"></i> {{ $laporan->nama_bulan }}
        </span>
    </div>
</div>
```

## PERUBAHAN YANG DILAKUKAN

### 1. Header Section:

-   `bg-gradient-to-r from-cyan-500 to-blue-600` → `apbdes-hero`
-   `text-cyan-100` → `navbar-text-secondary`

### 2. Card Backgrounds:

-   `bg-gradient-to-br from-green-50 to-green-100` → `apbdes-pendapatan-light`
-   `bg-gradient-to-br from-purple-50 to-purple-100` → `section-bg-alternate`
-   `border border-green-200` → `border-primary`
-   `border border-purple-200` → `border-secondary`

### 3. Icon Backgrounds:

-   `bg-purple-500 text-white` → `apbdes-balance`

### 4. Text Colors:

-   `text-purple-800` → `text-heading`
-   `text-purple-900` → `text-heading`
-   `bg-purple-100 text-purple-800` → `card-bg text-body`

## BENEFIT PERUBAHAN

1. **Consistency**: Semua warna mengikuti sistem global
2. **Maintainability**: Ganti warna cukup edit colors.css
3. **Readability**: Class names lebih semantic dan mudah dipahami
4. **Flexibility**: Client bisa ganti tema dengan mudah

## TESTING YANG DIPERLUKAN

1. ✅ Visual appearance tetap sama atau lebih baik
2. ✅ Responsive design masih berfungsi
3. ✅ Hover effects masih berfungsi
4. ✅ Color contrast masih memenuhi accessibility standards

---

📝 **File:** section_statistics.blade.php  
🎯 **Changes:** 15+ hardcoded colors replaced  
⏰ **Est. Time:** 30 minutes

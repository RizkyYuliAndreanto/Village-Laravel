Dashboard Validasi Populasi - Dokumentasi

## Overview

Dashboard ini dibuat untuk menampilkan validasi data populasi village dengan fitur sorting berdasarkan tahun. Dashboard terdiri dari beberapa widget yang memberikan overview komprehensif tentang konsistensi data statistik populasi.

## Fitur Utama

### 1. Year Filter Widget

-   **Lokasi**: Widget pertama di dashboard
-   **Fungsi**: Dropdown untuk memilih tahun dan melihat validasi data
-   **Fitur**:
    -   Pilihan tahun dari data yang tersedia
    -   Display total populasi untuk tahun terpilih
    -   Grid statistik dengan status validasi
    -   Progress bar untuk setiap jenis statistik
    -   Color coding: Hijau (valid), Merah (tidak valid)

### 2. Population Validation Chart Widget

-   **Lokasi**: Widget kedua di dashboard
-   **Fungsi**: Grafik line chart menampilkan data populasi per tahun
-   **Fitur**:
    -   Line chart dengan multiple datasets
    -   Filter: Semua Tahun, 5 Tahun Terakhir, 3 Tahun Terakhir, Tahun Terbaru
    -   Datasets untuk setiap jenis statistik:
        -   Total Populasi (biru)
        -   Umur (hijau)
        -   Pekerjaan (kuning)
        -   Pendidikan (merah)
        -   Agama (ungu)
        -   Perkawinan (pink)
        -   Wajib Pilih (biru muda)

### 3. Year Validation Summary Widget

-   **Lokasi**: Widget ketiga di dashboard
-   **Fungsi**: Tabel ringkasan validasi per tahun
-   **Fitur**:
    -   Tabel dengan kolom tahun dan total populasi
    -   Status badge untuk setiap jenis statistik
    -   Status keseluruhan per tahun
    -   Sortable dan paginable
    -   Color coding untuk status

## Status Validasi

### Individual Status

-   **Valid (angka)**: Data konsisten dengan populasi total
-   **Tidak Valid (±angka)**: Data tidak konsisten, menampilkan selisih
-   **Belum Ada Data**: Tidak ada data untuk jenis statistik tersebut

### Overall Status

-   **Semua Valid**: Semua statistik yang ada datanya valid
-   **Ada Masalah**: 1-2 statistik tidak valid
-   **Banyak Masalah**: 3+ statistik tidak valid
-   **Belum Ada Data**: Tidak ada data statistik sama sekali

## Color Coding

-   🟢 **Hijau (Success)**: Data valid/konsisten
-   🔴 **Merah (Danger)**: Data tidak valid/bermasalah
-   🟡 **Kuning (Warning)**: Ada beberapa masalah
-   ⚫ **Abu-abu (Gray)**: Belum ada data

## Cara Menggunakan

### Sorting Berdasarkan Tahun:

1. **Year Filter Widget**:
    - Pilih tahun dari dropdown di widget pertama
    - Dashboard akan menampilkan detail validasi untuk tahun tersebut
2. **Chart Widget**:
    - Gunakan filter dropdown untuk melihat rentang tahun yang diinginkan
    - Hover pada chart untuk melihat detail angka
3. **Summary Table**:
    - Tabel otomatis terurut berdasarkan tahun (terbaru ke terlama)
    - Klik header kolom untuk sorting manual
    - Gunakan pagination untuk navigasi data

### Interpretasi Data:

-   Cek status keseluruhan untuk overview cepat
-   Periksa individual status untuk detail masalah
-   Gunakan chart untuk melihat trend data antar tahun
-   Progress bar menunjukkan persentase terhadap target populasi

## File Terkait

### Widget Files:

-   `app/Filament/Widgets/YearFilterWidget.php`
-   `app/Filament/Widgets/PopulationValidationChartWidget.php`
-   `app/Filament/Widgets/YearValidationSummaryWidget.php`

### View Files:

-   `resources/views/filament/widgets/year-filter-widget.blade.php`

### Service Files:

-   `app/Services/PopulationValidationService.php`

### Dashboard Configuration:

-   `app/Filament/Pages/Dashboard.php`

## Troubleshooting

### Jika Data Tidak Muncul:

1. Pastikan ada data di tabel `tahun_data`
2. Pastikan ada data di tabel `demografi_penduduk`
3. Check foreign key relationships antara `tahun_data.id_tahun` dan `demografi_penduduk.tahun_id`

### Jika Validasi Selalu Invalid:

1. Pastikan total input statistik = total populasi (laki_laki + perempuan)
2. Check kalkulasi di `PopulationValidationService`
3. Verifikasi data input tidak ada yang null/kosong

## Maintenance Notes

-   Widget menggunakan polling interval untuk auto-refresh
-   Chart data di-cache untuk performa
-   Validation service dapat diperluas untuk jenis statistik baru
-   Color scheme dapat disesuaikan di widget configuration

## Future Improvements

1. Export data to Excel/PDF
2. Real-time notifications untuk data inconsistency
3. Batch validation untuk multiple tahun
4. Historical comparison features
5. Advanced filtering dan search capabilities

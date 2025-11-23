# Fitur Pemilihan Tahun Data Infografis

## Overview

Fitur pemilihan tahun memungkinkan pengguna untuk melihat data infografis untuk tahun yang berbeda tanpa reload halaman. Setiap section infografis memiliki dropdown tahun yang independent.

## Komponen yang Terlibat

### 1. Backend Controllers

-   **InfografisController**: Controller utama yang koordinasi semua data
-   **StatistikController**: Handle data demografis dasar
-   **UmurController**: Handle data kelompok umur
-   **PendidikanController**: Handle data pendidikan
-   **PekerjaanController**: Handle data pekerjaan
-   **AgamaController**: Handle data agama
-   **PerkawinanController**: Handle data perkawinan dan wajib pilih

### 2. Frontend Components

-   **tahun-selector.blade.php**: Partial component untuk dropdown tahun
-   **infografis-tahun-selector.js**: JavaScript handler untuk AJAX requests
-   **infografis-tahun-selector.css**: Styling untuk tahun selector

### 3. API Endpoints

```
GET /api/infografis/statistik?tahun=2024
GET /api/infografis/umur?tahun=2024
GET /api/infografis/pendidikan?tahun=2024
GET /api/infografis/pekerjaan?tahun=2024
GET /api/infografis/agama?tahun=2024
GET /api/infografis/perkawinan?tahun=2024
GET /api/infografis/wajib-pilih?tahun=2024
```

## Cara Kerja

### 1. Initialization

-   Saat halaman load, setiap section menampilkan data untuk tahun aktif (default: tahun terbaru)
-   Dropdown tahun diisi dengan data dari `TahunData` model
-   JavaScript event listeners di-attach ke semua `.tahun-selector` elements

### 2. User Interaction

-   User memilih tahun dari dropdown
-   JavaScript menangkap event `change`
-   Loading indicator ditampilkan
-   AJAX request dikirim ke API endpoint yang sesuai

### 3. Data Update

-   Controller mengambil data untuk tahun yang diminta
-   Response JSON dikirim kembali ke frontend
-   JavaScript mengupdate DOM elements dengan data baru
-   Charts di-recreate dengan data baru
-   Loading indicator disembunyikan

### 4. Chart Updates

-   Chart instances disimpan di `window.infografisCharts`
-   Chart lama di-destroy sebelum membuat yang baru
-   Data chart format tetap konsisten

## Implementation Details

### Tahun Selector Component

```blade
@include('frontend.Infografis.partials.tahun-selector', [
    'sectionId' => 'demografi',
    'tahunTersedia' => $tahunTersedia ?? [],
    'tahunAktif' => $tahunAktif ?? date('Y')
])
```

### JavaScript Event Handler

```javascript
document.querySelectorAll(".tahun-selector").forEach((selector) => {
    selector.addEventListener("change", function () {
        const section = this.dataset.section;
        const tahun = this.value;
        updateSectionData(section, tahun);
    });
});
```

### API Response Format

```json
{
    "totalPenduduk": 5420,
    "totalLaki": 2710,
    "totalPerempuan": 2710,
    "pendudukSementara": 150,
    "mutasiPenduduk": 85,
    "tahun": "2024"
}
```

## Data Flow

### 1. Section: Demografi

-   **API**: `/api/infografis/statistik`
-   **Update**: Stat boxes dengan animasi counter
-   **Elements**: `#stat-total-penduduk`, `#stat-total-laki`, etc.

### 2. Section: Kelompok Umur

-   **API**: `/api/infografis/umur`
-   **Update**: Piramida penduduk chart
-   **Elements**: `#chartPiramida`

### 3. Section: Pendidikan

-   **API**: `/api/infografis/pendidikan`
-   **Update**: Horizontal bar chart
-   **Elements**: `#chartPendidikan`

### 4. Section: Pekerjaan

-   **API**: `/api/infografis/pekerjaan`
-   **Update**: Tabel data dan chart
-   **Elements**: `#tabel-pekerjaan`

### 5. Section: Agama

-   **API**: `/api/infografis/agama`
-   **Update**: Grid cards dengan data-field attributes
-   **Elements**: `[data-field="islam"]`, etc.

### 6. Section: Perkawinan

-   **API**: `/api/infografis/perkawinan`
-   **Update**: Grid cards status perkawinan
-   **Elements**: Dynamic grid cards

### 7. Section: Wajib Pilih

-   **API**: `/api/infografis/wajib-pilih`
-   **Update**: Bar chart wajib pilih
-   **Elements**: `#chartWajibPilih`

## Error Handling

### 1. Network Errors

-   Catch fetch errors
-   Show user-friendly error messages
-   Retry mechanism (optional)

### 2. Data Validation

-   Validate tahun parameter
-   Handle empty data responses
-   Fallback ke data dummy jika perlu

### 3. Chart Errors

-   Check chart canvas existence
-   Destroy previous charts safely
-   Handle Chart.js errors

## Performance Considerations

### 1. Caching

-   Controllers dapat implement caching untuk data yang sering diakses
-   Browser caching untuk static assets (JS, CSS)

### 2. Lazy Loading

-   Charts hanya dibuat ketika data berubah
-   Destroy chart lama untuk memory management

### 3. Debouncing

-   Prevent multiple rapid API calls
-   Loading states untuk user feedback

## Database Structure

### Required Tables

-   `tahun_data`: Master tahun yang tersedia
-   `demografi_penduduk`: Data statistik dasar
-   `umur_statistik`: Data kelompok umur
-   `pendidikan_statistik`: Data pendidikan
-   `pekerjaan_statistik`: Data pekerjaan
-   `agama_statistik`: Data agama
-   `perkawinan_statistik`: Data perkawinan
-   `wajib_pilih_statistik`: Data wajib pilih

### Foreign Key Relations

Semua tabel statistik harus memiliki relasi ke `tahun_data.id`

## Testing

### 1. Unit Tests

-   Test setiap controller method
-   Mock data untuk tahun yang berbeda
-   Validate API response format

### 2. Integration Tests

-   Test API endpoints
-   Test JavaScript functionality
-   Test chart updates

### 3. User Acceptance Tests

-   Test user workflow
-   Test responsive design
-   Test error scenarios

## Deployment

### 1. Static Assets

-   Compile CSS dan JS assets
-   Ensure proper versioning untuk cache busting

### 2. Database

-   Pastikan data tahun tersedia di production
-   Run seeders jika diperlukan

### 3. Permissions

-   API endpoints harus accessible tanpa auth
-   Public access untuk infografis data

## Future Enhancements

### 1. Advanced Features

-   Perbandingan multi-tahun
-   Export data per tahun
-   Historical trend analysis

### 2. UX Improvements

-   Smooth animations
-   Progressive loading
-   Keyboard navigation

### 3. Performance

-   Real-time data updates
-   WebSocket untuk live data
-   Advanced caching strategies

# DOKUMENTASI SECTION DUSUN INFOGRAFIS

## Fitur yang Ditambahkan

### 1. Backend Implementation

-   **File**: `app/Http/Controllers/Frontend/DemografiController.php`
    -   Menambahkan import `DusunStatistik` model
    -   Menambahkan call `$dusunData = $this->getDusunData($tahun);` dalam method `infografis()`
    -   Menambahkan method `getDusunData($tahun)` untuk mengambil data dusun
    -   Menambahkan method `apiDusun(Request $request)` untuk API endpoint

### 2. Frontend Implementation

-   **File**: `resources/views/frontend/infografis/sections/dusun.blade.php`

    -   Section baru untuk menampilkan statistik dusun
    -   Layout 2 kolom: Chart (doughnut) + Detail cards
    -   Menggunakan Chart.js untuk visualisasi pie chart
    -   Responsive design mengikuti pola section lain

-   **File**: `resources/views/frontend/infografis/index.blade.php`
    -   Menambahkan include untuk section dusun

### 3. JavaScript Integration

-   **File**: `public/js/infografis-tahun-selector.js`
    -   Menambahkan endpoint API `/api/infografis/dusun`
    -   Menambahkan chart instance `dusun` ke global variables
    -   Menambahkan handler `updateDusunData(tahun)` untuk update data berdasarkan tahun
    -   Menambahkan function `createDusunChart(dusunData)` untuk membuat doughnut chart

### 4. API Routes

-   **File**: `routes/api.php`
    -   Menambahkan route `GET /api/infografis/dusun` untuk mendapatkan data dusun

## Data Structure

### DusunStatistik Model

```php
- nama_dusun: string (nama dusun)
- jumlah_penduduk: integer (total penduduk per dusun)
- jumlah_kk: integer (jumlah kepala keluarga)
- tahun_id: foreign key ke TahunData
```

### Chart Configuration

```php
'dusunChartConfig' => [
    'labels' => ['TAMANG', 'LUBANG LANDAK', 'SENGKABANG', 'BAA'],
    'data' => [395, 548, 477, 283],
    'percentages' => [23.4, 32.5, 28.3, 16.8],
    'colors' => [rgba values],
    'borderColors' => [rgba values]
]
```

## Features

### 1. Doughnut Chart

-   **Type**: Chart.js Doughnut Chart
-   **Features**:
    -   Interactive tooltips dengan persentase
    -   Hover effects
    -   Legend di bawah chart
    -   Responsive dan maintainAspectRatio: false
    -   Cutout 50% untuk doughnut style

### 2. Detail Cards

-   **Layout**: Vertical stack dengan border-left color coding
-   **Content**:
    -   Nama dusun (uppercase)
    -   Jumlah KK
    -   Jumlah penduduk (dengan formatting)
    -   Persentase dari total

### 3. Summary Card

-   **Design**: Gradient background dengan border
-   **Content**:
    -   Total penduduk semua dusun
    -   Total KK semua dusun

### 4. Year Selector Integration

-   **Functionality**: Update data dan chart berdasarkan tahun dipilih
-   **API**: Fetch data dari `/api/infografis/dusun?tahun={tahun}`
-   **Animation**: Chart recreation dengan smooth transition

## Visual Design

### Color Palette

-   Blue: `rgba(59, 130, 246, 0.8)` - untuk dusun pertama
-   Green: `rgba(34, 197, 94, 0.8)` - untuk dusun kedua
-   Yellow: `rgba(251, 191, 36, 0.8)` - untuk dusun ketiga
-   Red: `rgba(239, 68, 68, 0.8)` - untuk dusun keempat

### Layout

-   **Desktop**: 2 kolom (chart + details)
-   **Mobile**: 1 kolom (stacked)
-   **Cards**: Rounded corners, shadow, border-left accent
-   **Typography**: Font weights dan sizes konsisten dengan sections lain

## Data Sources

### Default Data (jika tidak ada di database)

```php
'TAMANG' => 395 penduduk, 120 KK
'LUBANG LANDAK' => 548 penduduk, 165 KK
'SENGKABANG' => 477 penduduk, 142 KK
'BAA' => 283 penduduk, 85 KK
```

### Database Integration

-   Menggunakan model `DusunStatistik` dengan relasi ke `TahunData`
-   Query berdasarkan tahun yang dipilih
-   Fallback ke data dummy jika tidak ada data

## API Response Format

```json
{
    "success": true,
    "dusunData": {
        "dusunStatistik": [...],
        "dusunChart": [...],
        "totalPendudukDusun": 1703,
        "totalKKDusun": 512,
        "dusunChartConfig": {...}
    },
    "tahun": "2024"
}
```

## Installation Status

✅ Controller methods implemented
✅ Blade template created  
✅ JavaScript handlers added
✅ API routes configured
✅ Chart.js integration complete
✅ Responsive design implemented
✅ Year selector integration ready

## Testing

Untuk testing, pastikan:

1. Data `DusunStatistik` tersedia di database
2. Tahun data tersedia di `TahunData`
3. Chart.js library ter-load di layout
4. JavaScript file `infografis-tahun-selector.js` ter-load

Section dusun infografis sudah siap digunakan dan terintegrasi penuh dengan sistem infografis yang ada!

## Preview Lokasi

Section dusun akan muncul di bagian paling bawah halaman infografis setelah section "Berdasarkan Agama".

URL untuk testing: `/infografis` (section otomatis ter-include)

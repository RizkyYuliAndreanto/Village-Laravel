# Dokumentasi Controller Modular Infografis

## 📋 Overview

Controller infografis telah direfactor menjadi struktur yang sangat modular berdasarkan prinsip **Single Responsibility Principle**. Setiap controller menangani satu fitur spesifik dan memiliki API endpoints masing-masing.

## 🗂️ Struktur Controller

### 📁 Lokasi: `app/Http/Controllers/Frontend/Infografis/`

```
app/Http/Controllers/Frontend/Infografis/
├── InfografisController.php      # Controller utama koordinator
├── StatistikController.php       # Data demografi dasar
├── UmurController.php            # Data kelompok umur & piramida
├── PendidikanController.php      # Data tingkat pendidikan
├── PekerjaanController.php       # Data jenis pekerjaan
├── AgamaController.php           # Data agama & kepercayaan
└── PerkawinanController.php      # Data perkawinan & wajib pilih
```

## 🎯 Responsibilities Setiap Controller

### 1. **InfografisController** (Koordinator Utama)

**File**: `InfografisController.php`

-   🎯 **Role**: Main controller untuk halaman infografis
-   🔧 **Functions**:
    -   Koordinasi semua controller section
    -   Render halaman infografis utama
    -   API endpoints untuk data lengkap
    -   Management tahun data
    -   Export functionality (JSON, CSV, Excel)

**Key Methods**:

```php
public function index()                    // Halaman utama infografis
public function apiData()                  // API semua data
public function getSectionData($section)   // API data section tertentu
public function getChartData($section)     // API chart data
public function getAnalisis($section)      // API analisis
public function export()                   // Export data
```

### 2. **StatistikController** (Data Demografi Dasar)

**File**: `StatistikController.php`

-   🎯 **Role**: Handle statistik demografi dasar
-   📊 **Data**: Total penduduk, laki-laki, perempuan, penduduk sementara, mutasi
-   🔧 **Functions**:
    -   Data statistik untuk section demografi
    -   Perbandingan dengan tahun sebelumnya
    -   Growth rate calculation

**Key Methods**:

```php
public function getData($tahun)           // Data statistik dasar
public function apiData()                 // API endpoint
public function getPerbandingan($tahun)   // Perbandingan tahun
```

### 3. **UmurController** (Kelompok Umur)

**File**: `UmurController.php`

-   🎯 **Role**: Handle data kelompok umur
-   📊 **Data**: Piramida penduduk, statistik umur laki-laki & perempuan
-   🔧 **Functions**:
    -   Chart data untuk piramida penduduk
    -   Insights kelompok umur produktif
    -   Analisis demografi berdasarkan umur

**Key Methods**:

```php
public function getData($tahun)           // Data kelompok umur
public function getChartData($tahun)      // Data chart piramida
public function getInsights($tahun)       // Insights & analisis
```

### 4. **PendidikanController** (Tingkat Pendidikan)

**File**: `PendidikanController.php`

-   🎯 **Role**: Handle data pendidikan
-   📊 **Data**: SD, SMP, SMA, Diploma, S1, S2, S3, tidak sekolah
-   🔧 **Functions**:
    -   Chart horizontal pendidikan
    -   Analisis sebaran pendidikan
    -   Ranking tingkat pendidikan

**Key Methods**:

```php
public function getData($tahun)           // Data pendidikan
public function getChartData($tahun)      // Data chart horizontal
public function getAnalisis($tahun)       // Analisis pendidikan
public function getRanking($tahun)        // Ranking pendidikan
```

### 5. **PekerjaanController** (Mata Pencaharian)

**File**: `PekerjaanController.php`

-   🎯 **Role**: Handle data pekerjaan
-   📊 **Data**: Petani, wiraswasta, pegawai, pelajar, IRT, dll
-   🔧 **Functions**:
    -   Tabel dan grid cards pekerjaan
    -   Analisis sektor ekonomi
    -   Tingkat pengangguran

**Key Methods**:

```php
public function getData($tahun)           // Data pekerjaan
public function getTabelData($tahun)      // Data tabel
public function getAnalisis($tahun)       // Analisis ekonomi
public function getRanking($tahun)        // Ranking pekerjaan
public function getChartData($tahun)      // Chart pie/donut
```

### 6. **AgamaController** (Agama & Kepercayaan)

**File**: `AgamaController.php`

-   🎯 **Role**: Handle data agama
-   📊 **Data**: Islam, Katolik, Kristen, Hindu, Buddha, Konghucu, Kepercayaan Lain
-   🔧 **Functions**:
    -   Grid cards agama
    -   Analisis keberagaman
    -   Chart pie agama

**Key Methods**:

```php
public function getData($tahun)           // Data agama
public function getGridData($tahun)       // Data grid cards
public function getAnalisis($tahun)       // Analisis diversitas
public function getRanking($tahun)        // Ranking agama
public function getChartData($tahun)      // Chart pie agama
```

### 7. **PerkawinanController** (Status Perkawinan & Wajib Pilih)

**File**: `PerkawinanController.php`

-   🎯 **Role**: Handle data perkawinan & wajib pilih
-   📊 **Data**: Belum kawin, kawin, cerai, wajib pilih
-   🔧 **Functions**:
    -   Grid cards status perkawinan
    -   Chart wajib pilih
    -   Analisis perkawinan

**Key Methods**:

```php
public function getData($tahun)                    // Data perkawinan
public function getWajibPilihData($tahun)          // Data wajib pilih
public function getGridData($tahun)                // Grid cards
public function getAnalisis($tahun)                // Analisis perkawinan
public function getWajibPilihChartData($tahun)     // Chart wajib pilih
```

## 🌐 API Endpoints

### Main Endpoints

```
GET  /infografis                          # Halaman utama
GET  /api/infografis                      # Semua data JSON
GET  /api/infografis/{section}            # Data section tertentu
GET  /api/infografis/{section}/chart      # Chart data
GET  /api/infografis/{section}/analisis   # Analisis data
POST /api/infografis/refresh              # Refresh data
GET  /infografis/export?format=json       # Export data
```

### Section Endpoints

```
# Statistik
GET  /api/infografis/statistik
GET  /api/infografis/statistik/analisis

# Kelompok Umur
GET  /api/infografis/umur
GET  /api/infografis/umur/chart
GET  /api/infografis/umur/analisis

# Pendidikan
GET  /api/infografis/pendidikan
GET  /api/infografis/pendidikan/chart
GET  /api/infografis/pendidikan/analisis

# Pekerjaan
GET  /api/infografis/pekerjaan
GET  /api/infografis/pekerjaan/chart
GET  /api/infografis/pekerjaan/analisis

# Agama
GET  /api/infografis/agama
GET  /api/infografis/agama/chart
GET  /api/infografis/agama/analisis

# Perkawinan & Wajib Pilih
GET  /api/infografis/perkawinan
GET  /api/infografis/perkawinan/chart
GET  /api/infografis/perkawinan/analisis
GET  /api/infografis/wajib-pilih
GET  /api/infografis/wajib-pilih/chart
```

## 🔄 Data Flow

```
Request → InfografisController
    ↓
Delegate to specific controller
    ↓
StatistikController.getData()
UmurController.getData()
PendidikanController.getData()
PekerjaanController.getData()
AgamaController.getData()
PerkawinanController.getData()
    ↓
array_merge() all data
    ↓
Return to view with all data
```

## 🎯 Keuntungan Modular Structure

### 1. **Single Responsibility** ✅

-   Setiap controller fokus pada satu fitur
-   Easy to understand dan maintain
-   Clear separation of concerns

### 2. **Independent Development** ✅

-   Developer bisa fokus pada satu controller
-   Parallel development possible
-   Less code conflicts

### 3. **Easy Testing** ✅

-   Unit test per controller
-   Mock individual controllers
-   Isolated testing environment

### 4. **Scalable APIs** ✅

-   Individual API endpoints
-   Microservice-ready architecture
-   Frontend dapat consume data specific

### 5. **Reusable Components** ✅

-   Controller bisa dipakai di halaman lain
-   Data methods bisa di-extend
-   Chart data bisa dipakai untuk dashboard lain

## 🔧 Cara Menggunakan

### Update Data Section Tertentu

```php
// Edit data pekerjaan saja
$pekerjaanController = new PekerjaanController();
$data = $pekerjaanController->getData($tahun);
```

### Tambah Section Baru

1. Buat controller baru di folder `Infografis/`
2. Implement method `getData($tahun)`
3. Tambah ke `InfografisController::getAllData()`
4. Buat view section di `sections/`

### Testing Individual Controller

```php
// Test controller terpisah
$umurController = new UmurController();
$chartData = $umurController->getChartData(2025);
$insights = $umurController->getInsights(2025);
```

### Consume API dari Frontend

```javascript
// Load specific section data
fetch("/api/infografis/pekerjaan")
    .then((response) => response.json())
    .then((data) => console.log(data));

// Load chart data
fetch("/api/infografis/umur/chart")
    .then((response) => response.json())
    .then((chartData) => renderChart(chartData));
```

## 🚀 Next Steps

1. **Routes Update**: Update `routes/web.php` dan `routes/api.php`
2. **Database Integration**: Connect real database ke setiap controller
3. **Caching**: Implement Redis cache per controller
4. **Real-time Updates**: WebSocket untuk update data real-time
5. **Advanced Analytics**: Machine learning insights di setiap controller

## ✅ Status

-   ✅ 7 Modular controllers created
-   ✅ API endpoints designed
-   ✅ Data flow documented
-   ✅ Testing strategy defined
-   🔄 Routes integration (next)
-   🔄 Database connection (next)

Controller structure sekarang sangat modular, scalable, dan mudah untuk development tim! 🎉

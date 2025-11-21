# 🛠️ DOKUMENTASI TEKNIS SISTEM APBDes

## 📋 Arsitektur Sistem

### Database Schema

```sql
-- Master Data
bidang_apbdes (id, kode_bidang, nama_bidang, kategori, urutan, is_active)
sub_bidang_apbdes (id, bidang_apbdes_id, kode_sub_bidang, nama_sub_bidang)

-- Laporan & Detail
laporan_apbdes (id, tahun_id, nama_laporan, bulan_rilis, status)
detail_apbdes (id, laporan_apbdes_id, bidang_apbdes_id, tipe, uraian, anggaran, realisasi, persentase_realisasi)
```

### Model Relationships

```php
// BidangApbdes.php
hasMany(SubBidangApbdes::class)
hasMany(DetailApbdes::class)

// LaporanApbdes.php
belongsTo(TahunData::class)
hasMany(DetailApbdes::class)

// DetailApbdes.php
belongsTo(LaporanApbdes::class)
belongsTo(BidangApbdes::class)
belongsTo(SubBidangApbdes::class)
```

### Filament Resources

```php
- BidangApbdesResource.php        // Master bidang
- LaporanApbdesResource.php       // Laporan tahunan
- DetailApbdesInputResource.php   // Input anggaran
```

### Widgets & Pages

```php
- ApbdesBalanceOverview.php       // Widget balance
- ApbdesDashboard.php            // Dashboard khusus
```

---

## 🔄 Business Logic

### Auto Calculations

```php
// Model: DetailApbdes.php
protected static function boot()
{
    parent::boot();

    static::saving(function ($model) {
        if ($model->anggaran > 0) {
            $model->persentase_realisasi = ($model->realisasi / $model->anggaran) * 100;
        }
    });
}
```

### Balance Calculation

```php
// Controller: ApbdesController.php
private function hitungBalance($laporan)
{
    $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
        ->where('tipe', 'pendapatan')
        ->sum('realisasi');

    $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
        ->where('tipe', 'belanja')
        ->sum('realisasi');

    return [
        'total_pendapatan' => $totalPendapatan,
        'total_belanja' => $totalBelanja,
        'selisih' => $totalPendapatan - $totalBelanja,
        'status' => $totalPendapatan >= $totalBelanja ? 'surplus' : 'defisit'
    ];
}
```

---

## 🚀 Installation & Setup

### 1. Run Migrations

```bash
php artisan migrate
```

### 2. Seed Master Data

```bash
php artisan db:seed --class=BidangApbdesSeeder
php artisan db:seed --class=ContohApbdesSeeder  # Contoh data
```

### 3. Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🎨 Frontend Integration

### Route Setup

```php
// routes/web.php
Route::get('/apbdes', [ApbdesController::class, 'index'])->name('apbdes.index');
Route::get('/apbdes/{id}', [ApbdesController::class, 'show'])->name('apbdes.show');
```

### Blade Template Structure

```php
resources/views/frontend/apbdes/
├── index.blade.php          // Halaman utama APBDes
├── detail.blade.php         // Detail laporan
└── sections/
    ├── balance-summary.blade.php
    ├── pendapatan-table.blade.php
    └── belanja-chart.blade.php
```

### API Endpoints (Optional)

```php
// routes/api.php
Route::prefix('apbdes')->group(function () {
    Route::get('/balance/{tahun}', [ApbdesApiController::class, 'balance']);
    Route::get('/bidang/{laporan_id}', [ApbdesApiController::class, 'dataBidang']);
    Route::get('/chart/{laporan_id}', [ApbdesApiController::class, 'chartData']);
});
```

---

## 📊 Chart.js Integration

### Balance Chart

```javascript
// resources/js/apbdes-charts.js
const ctx = document.getElementById("balanceChart").getContext("2d");
const balanceChart = new Chart(ctx, {
    type: "doughnut",
    data: {
        labels: ["Pendapatan", "Belanja"],
        datasets: [
            {
                data: [pendapatanTotal, belanjaTotal],
                backgroundColor: ["#10B981", "#F59E0B"],
            },
        ],
    },
});
```

### Bidang Chart

```javascript
const bidangChart = new Chart(ctx2, {
    type: "bar",
    data: {
        labels: bidangLabels,
        datasets: [
            {
                label: "Realisasi",
                data: realisasiData,
                backgroundColor: "#3B82F6",
            },
        ],
    },
});
```

---

## 🔧 Customization

### Menambah Bidang Baru

```php
// database/seeders/BidangApbdesSeeder.php
BidangApbdes::create([
    'kode_bidang' => 'NEW01',
    'nama_bidang' => 'Bidang Baru',
    'kategori' => 'belanja',
    'urutan' => 8
]);
```

### Custom Validation Rules

```php
// app/Http/Requests/DetailApbdesRequest.php
public function rules()
{
    return [
        'anggaran' => 'required|numeric|min:0',
        'realisasi' => 'required|numeric|min:0|lte:anggaran',
        'bidang_apbdes_id' => 'required|exists:bidang_apbdes,id'
    ];
}
```

### Custom Widget

```php
// app/Filament/Widgets/CustomApbdesWidget.php
class CustomApbdesWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Custom calculations
        return [
            Stat::make('Custom Metric', $value)
                ->description($description)
                ->color('success')
        ];
    }
}
```

---

## 🛡️ Security & Permissions

### Role-based Access

```php
// app/Policies/DetailApbdesPolicy.php
public function create(User $user)
{
    return $user->hasRole(['admin', 'bendahara']);
}

public function update(User $user, DetailApbdes $detail)
{
    return $user->hasRole('admin') ||
           ($user->hasRole('bendahara') && $detail->laporan->status === 'draft');
}
```

### Input Sanitization

```php
// Model: DetailApbdes.php
public function setUraianAttribute($value)
{
    $this->attributes['uraian'] = strip_tags(trim($value));
}

public function setAnggaranAttribute($value)
{
    $this->attributes['anggaran'] = abs(floatval($value));
}
```

---

## 🧪 Testing

### Feature Tests

```php
// tests/Feature/ApbdesTest.php
public function test_can_create_laporan_apbdes()
{
    $response = $this->actingAs($this->admin)
        ->post('/admin/laporan-apbdes', [
            'tahun_id' => 2025,
            'nama_laporan' => 'Test APBDes',
            'bulan_rilis' => 3,
            'status' => 'draft'
        ]);

    $response->assertStatus(302);
    $this->assertDatabaseHas('laporan_apbdes', [
        'nama_laporan' => 'Test APBDes'
    ]);
}
```

### Unit Tests

```php
// tests/Unit/BalanceCalculationTest.php
public function test_balance_calculation()
{
    $laporan = LaporanApbdes::factory()->create();
    $pendapatan = DetailApbdes::factory()->pendapatan()->create([
        'laporan_apbdes_id' => $laporan->id,
        'realisasi' => 1000000
    ]);
    $belanja = DetailApbdes::factory()->belanja()->create([
        'laporan_apbdes_id' => $laporan->id,
        'realisasi' => 800000
    ]);

    $balance = app(ApbdesController::class)->hitungBalance($laporan);

    $this->assertEquals(200000, $balance['selisih']);
    $this->assertEquals('surplus', $balance['status']);
}
```

---

## 📈 Performance Optimization

### Database Indexing

```php
// Migration
Schema::table('detail_apbdes', function (Blueprint $table) {
    $table->index(['laporan_apbdes_id', 'tipe']);
    $table->index(['bidang_apbdes_id']);
    $table->index(['bulan_realisasi']);
});
```

### Query Optimization

```php
// Eager loading relationships
$laporan = LaporanApbdes::with([
    'detailApbdes.bidangApbdes',
    'tahunData'
])->find($id);

// Use select() to limit fields
$balance = DetailApbdes::select([
    'tipe',
    DB::raw('SUM(anggaran) as total_anggaran'),
    DB::raw('SUM(realisasi) as total_realisasi')
])
->where('laporan_apbdes_id', $laporanId)
->groupBy('tipe')
->get();
```

### Caching

```php
// Cache balance calculation
$balance = Cache::remember("apbdes_balance_{$laporanId}", 3600, function () use ($laporanId) {
    return $this->hitungBalance($laporanId);
});
```

---

## 🔍 Debugging & Logs

### Debug Mode

```php
// config/app.php
'debug' => env('APP_DEBUG', true),

// Log APBDes operations
Log::info('APBDes Balance Calculated', [
    'laporan_id' => $laporanId,
    'balance' => $balance,
    'user_id' => auth()->id()
]);
```

### Common Issues

```php
// Error: "Bidang not found"
// Check: bidang_apbdes table has data

// Error: "Balance not calculating"
// Check: detail_apbdes has anggaran & realisasi data

// Error: "Widget not showing"
// Check: ApbdesBalanceOverview is registered in AdminPanelProvider
```

---

## 📦 Deployment Checklist

-   [ ] Run migrations: `php artisan migrate`
-   [ ] Seed master data: `php artisan db:seed --class=BidangApbdesSeeder`
-   [ ] Clear caches: `php artisan optimize:clear`
-   [ ] Set proper permissions on storage/
-   [ ] Configure backup for APBDes data
-   [ ] Test all CRUD operations
-   [ ] Verify balance calculations
-   [ ] Check responsive design on mobile
-   [ ] Test with real data volume

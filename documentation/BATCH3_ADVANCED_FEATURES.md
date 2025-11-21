# 📊 Dokumentasi Batch 3 - Fitur Dashboard Lanjutan

Dokumentasi lengkap untuk implementasi 4 Filament Resources tambahan: **PerkawinanStatistik**, **WajibPilihStatistik**, **PpidDokumen**, dan **StrukturOrganisasi**.

## 🏗️ Arsitektur & Inovasi

### Diversifikasi Fitur

Batch 3 ini menghadirkan **diversifikasi fitur** yang signifikan:

-   ✅ **Statistik Lanjutan** (Perkawinan & Wajib Pilih)
-   ✅ **Manajemen Dokumen** dengan file upload
-   ✅ **Manajemen Organisasi** dengan photo upload
-   ✅ **MediaStorageService Integration** untuk file management
-   ✅ **Advanced Table Features** (badges, images, filters)

### Struktur File

```
app/Filament/Resources/
├── PerkawinanStatistikResource.php
├── WajibPilihStatistikResource.php
├── PpidDokumenResource.php
├── StrukturOrganisasiResource.php
├── PerkawinanStatistikResource/Pages/
├── WajibPilihStatistikResource/Pages/
├── PpidDokumenResource/Pages/
└── StrukturOrganisasiResource/Pages/
```

## 📋 Resource Details

### 1. 💒 PerkawinanStatistikResource

**Navigasi:** Data Statistik → Statistik Perkawinan  
**Icon:** `heroicon-o-heart`  
**Sort Order:** 7

#### Fields:

**Status Perkawinan:**

-   `kawin` - Kawin
-   `cerai_hidup` - Cerai Hidup
-   `cerai_mati` - Cerai Mati

**Pencatatan Perkawinan:**

-   `kawin_tercatat` - Kawin Tercatat
-   `kawin_tidak_tercatat` - Kawin Tidak Tercatat

#### Special Features:

-   ✅ **Dual Section Layout** (Status vs Pencatatan)
-   ✅ **Dual Total Calculation** (2 separate totals)
-   ✅ **Advanced Table Columns** dengan calculated totals
-   ✅ **Smart Form Organization** berdasarkan kategori data

### 2. 🆔 WajibPilihStatistikResource

**Navigasi:** Data Statistik → Statistik Wajib Pilih  
**Icon:** `heroicon-o-identification`  
**Sort Order:** 8

#### Fields:

-   `laki_laki` - Laki-laki
-   `perempuan` - Perempuan
-   `total` - Total (auto-calculated & read-only)

#### Special Features:

-   ✅ **Auto-calculation** dengan `updateTotal()` method
-   ✅ **Read-only Total Field** yang otomatis terisi
-   ✅ **Gender-based Statistics** untuk data pemilu
-   ✅ **3-column Layout** untuk tampilan yang compact

### 3. 📄 PpidDokumenResource

**Navigasi:** Manajemen Dokumen → PPID Dokumen  
**Icon:** `heroicon-o-document-text`  
**Sort Order:** 1

#### Fields:

-   `judul_dokumen` - Judul Dokumen
-   `kategori` - Kategori Informasi (enum with 4 options)
-   `tahun` - Tahun
-   `tanggal_upload` - Tanggal Upload
-   `uploader` - Uploader
-   `file_url` - File Dokumen (dengan file upload)

#### Kategori Enum:

```php
const KATEGORI_BERKALA = 'informasi berkala';
const KATEGORI_SERTAMERTA = 'informasi sertamerta';
const KATEGORI_SETIAP_SAAT = 'informasi setiap saat';
const KATEGORI_DIKECUALIKAN = 'informasi dikecualikan';
```

#### Special Features:

-   ✅ **File Upload Integration** dengan MediaStorageService
-   ✅ **Badge Colors** untuk kategori dokumen
-   ✅ **Download Actions** di table dan view pages
-   ✅ **Advanced Filters** (kategori, tahun, tanggal)
-   ✅ **File Preview** information dalam form
-   ✅ **Auto Uploader** dengan auth user detection

### 4. 👥 StrukturOrganisasiResource

**Navigasi:** Manajemen Organisasi → Struktur Organisasi  
**Icon:** `heroicon-o-user-group`  
**Sort Order:** 1

#### Fields:

-   `nama` - Nama Lengkap
-   `jabatan` - Jabatan
-   `foto_url` - Foto Profil (dengan image upload & editor)
-   `keterangan` - Keterangan (optional)

#### Special Features:

-   ✅ **Image Upload** dengan editor dan aspect ratio options
-   ✅ **Circular Photo Display** di table
-   ✅ **Badge Jabatan** dengan primary color
-   ✅ **Reorderable Table** untuk pengaturan urutan
-   ✅ **Default Avatar** fallback
-   ✅ **Advanced Image Editor** (3:4, 4:3, 1:1 ratios)

## 🔧 Fitur Lanjutan

### 1. MediaStorageService Integration

```php
protected function mutateFormDataBeforeCreate(array $data): array
{
    if (isset($data['file_url']) && is_object($data['file_url'])) {
        $mediaService = app(MediaStorageService::class);
        $data['file_url'] = $mediaService->store($data['file_url'], 'directory');
    }
    return $data;
}
```

### 2. Advanced Table Features

```php
// Badge Column dengan colors
Tables\Columns\BadgeColumn::make('kategori')
    ->colors([
        'success' => PpidDokumen::KATEGORI_BERKALA,
        'warning' => PpidDokumen::KATEGORI_SERTAMERTA,
        'primary' => PpidDokumen::KATEGORI_SETIAP_SAAT,
        'danger' => PpidDokumen::KATEGORI_DIKECUALIKAN,
    ])

// Image Column dengan circular display
Tables\Columns\ImageColumn::make('foto_url')
    ->circular()
    ->size(60)
    ->defaultImageUrl(asset('images/default-avatar.png'))
```

### 3. Advanced Filters

```php
Tables\Filters\Filter::make('tanggal_upload')
    ->form([
        Forms\Components\DatePicker::make('upload_from')->label('Upload Dari'),
        Forms\Components\DatePicker::make('upload_until')->label('Upload Sampai'),
    ])
    ->query(function (Builder $query, array $data): Builder {
        return $query
            ->when($data['upload_from'], fn ($q, $date) => $q->whereDate('tanggal_upload', '>=', $date))
            ->when($data['upload_until'], fn ($q, $date) => $q->whereDate('tanggal_upload', '<=', $date));
    })
```

### 4. Enhanced Actions

```php
Tables\Actions\Action::make('download')
    ->label('Download')
    ->icon('heroicon-o-arrow-down-tray')
    ->color('success')
    ->url(fn (PpidDokumen $record): string => $record->file_url)
    ->openUrlInNewTab()
```

## 🎨 Navigation Updates

### New Navigation Groups:

```
📊 Data Statistik
├── 📈 Tahun Data (sort: 1)
├── 👥 Demografi Penduduk (sort: 2)
├── 👶 Statistik Umur (sort: 3)
├── 💼 Statistik Pekerjaan (sort: 4)
├── 🎓 Statistik Pendidikan (sort: 5)
├── ⭐ Statistik Agama (sort: 6)
├── 💒 Statistik Perkawinan (sort: 7) ← NEW
├── 🆔 Statistik Wajib Pilih (sort: 8) ← NEW
└── 🏘️ Statistik Dusun (sort: 9)

📄 Manajemen Dokumen ← NEW GROUP
└── 📄 PPID Dokumen (sort: 1) ← NEW

👥 Manajemen Organisasi ← NEW GROUP
└── 👥 Struktur Organisasi (sort: 1) ← NEW
```

## 🔒 Security & Validation

### File Upload Security:

```php
->acceptedFileTypes([
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'image/jpeg',
    'image/png',
    'image/jpg'
])
->maxSize(10240) // 10MB untuk dokumen
->maxSize(2048)  // 2MB untuk foto profil
```

### Data Validation:

-   ✅ **Required fields** dengan proper validation
-   ✅ **File type restrictions** untuk keamanan
-   ✅ **File size limits** untuk performance
-   ✅ **Year validation** dengan min/max values
-   ✅ **Auth integration** untuk uploader tracking

## 📊 Table Enhancements

### Advanced Column Types:

-   **BadgeColumn** - untuk status/kategori dengan colors
-   **ImageColumn** - untuk display foto dengan fallback
-   **TextColumn** dengan **url()** untuk download links
-   **Calculated Columns** untuk dynamic totals
-   **Toggleable Columns** untuk optional information

### Filter Innovations:

-   **Date Range Filters** untuk tanggal upload
-   **Enum-based Filters** untuk kategori
-   **Boolean Filters** untuk has_photo/has_keterangan
-   **Custom Query Filters** dengan complex logic

## 🚀 Performance Optimizations

### Lazy Loading:

```php
->toggleable(isToggledHiddenByDefault: true) // Untuk columns yang jarang dibutuhkan
->preload() // Untuk Select options yang sering digunakan
->searchable() // Untuk quick search functionality
```

### File Management:

```php
// Automatic old file deletion
if ($this->record->file_url) {
    $mediaService->delete($this->record->file_url);
}
```

## 🎯 Status Implementasi Batch 3

| Resource            | Status      | Special Features                  |
| ------------------- | ----------- | --------------------------------- |
| PerkawinanStatistik | ✅ Complete | Dual totals, smart sections       |
| WajibPilihStatistik | ✅ Complete | Auto-calculation, read-only field |
| PpidDokumen         | ✅ Complete | File upload, advanced filters     |
| StrukturOrganisasi  | ✅ Complete | Image editor, reorderable table   |

**Total:** 4 resources baru dengan 16 pages dan fitur-fitur advanced yang menghadirkan **level baru** dalam manajemen data village.

---

## 🌟 Innovation Highlights

### 1. **Multi-Category Statistics**

-   Perkawinan dengan kategorisasi status dan pencatatan
-   Wajib Pilih dengan auto-calculation gender-based

### 2. **Document Management System**

-   PPID compliance dengan kategori informasi publik
-   File upload dengan security validation
-   Download integration dan preview system

### 3. **Organization Management**

-   Photo upload dengan advanced image editor
-   Reorderable structure untuk hierarchy management
-   Professional profile display dengan fallback avatar

### 4. **Advanced UI Components**

-   Badge columns dengan color coding
-   Image columns dengan circular display
-   Date range filters untuk advanced searching
-   Preview sections untuk real-time feedback

Batch 3 ini menghadirkan **transformasi signifikan** dari simple statistics ke **comprehensive village management system** dengan document management dan organizational structure! 🎉

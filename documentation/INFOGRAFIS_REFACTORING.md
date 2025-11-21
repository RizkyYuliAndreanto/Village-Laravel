# Dokumentasi Refactoring Halaman Infografis

## 📋 Ringkasan

Halaman infografis telah direfactor menjadi struktur yang lebih modular dan mudah untuk debug. Setiap section demografis sekarang memiliki file terpisah dengan data dan controller method masing-masing.

## 🗂️ Struktur File Baru

### 1. Main View File

-   **File**: `resources/views/frontend/Infografis/index.blade.php`
-   **Fungsi**: Hanya berisi include ke section-section
-   **Backup**: File lama disimpan sebagai `index-old.blade.php`

### 2. Section Files

Semua section disimpan di: `resources/views/frontend/Infografis/sections/`

| File                      | Section                      | Konten                                                   |
| ------------------------- | ---------------------------- | -------------------------------------------------------- |
| `demografi.blade.php`     | Statistik Demografi Penduduk | Total penduduk, laki-laki, perempuan, penduduk sementara |
| `kelompok-umur.blade.php` | Piramida Penduduk            | Chart piramida berdasarkan kelompok umur + script        |
| `pendidikan.blade.php`    | Berdasarkan Pendidikan       | Chart horizontal tingkat pendidikan + script             |
| `pekerjaan.blade.php`     | Berdasarkan Pekerjaan        | Tabel dan grid cards jenis pekerjaan                     |
| `wajib-pilih.blade.php`   | Berdasarkan Wajib Pilih      | Chart bar wajib pilih + script                           |
| `perkawinan.blade.php`    | Berdasarkan Perkawinan       | Grid cards status perkawinan                             |
| `agama.blade.php`         | Berdasarkan Agama            | Grid cards statistik agama                               |

### 3. Controller Methods

**File**: `app/Http/Controllers/Frontend/DemografiController.php`

Setiap section memiliki method terpisah:

```php
private function getDemografiData($tahun)     // Section statistik dasar
private function getUmurData()               // Section piramida umur
private function getPendidikanData()         // Section pendidikan
private function getPekerjaanData()          // Section pekerjaan
private function getWajibPilihData()         // Section wajib pilih
private function getPerkawinanData()         // Section perkawinan
private function getAgamaData()              // Section agama
```

## 🎯 Keuntungan Refactoring

### 1. **Mudah Debug**

-   Setiap section bisa di-debug secara terpisah
-   Error tidak mempengaruhi section lain
-   Code lebih mudah dibaca dan dipahami

### 2. **Modular Structure**

-   Setiap section independen
-   Mudah menambah/hapus section
-   Reusable components

### 3. **Maintenance**

-   Perubahan di satu section tidak affect yang lain
-   Code organization yang lebih baik
-   Easy to locate specific functionality

### 4. **Performance**

-   Chart scripts hanya load untuk section yang membutuhkan
-   Conditional loading untuk optimasi

## 🔧 Cara Menggunakan

### Mengedit Section Tertentu

```php
// Edit file section langsung
resources/views/frontend/Infografis/sections/demografi.blade.php

// Edit data controller method
private function getDemografiData($tahun) {
    // Ubah data di sini
}
```

### Menambah Section Baru

1. Buat file section baru di `sections/`
2. Tambah method di controller
3. Include di `index.blade.php`
4. Update method `infografis()` untuk load data

### Testing Section Individual

Bisa test dengan comment/uncomment include di `index.blade.php`:

```blade
{{-- Section: Statistik Demografi Penduduk --}}
@include('frontend.Infografis.sections.demografi')

{{-- Comment untuk disable section --}}
{{-- @include('frontend.Infografis.sections.kelompok-umur') --}}
```

## 📊 Data Flow

```
infografis() method
    ↓
getTahunTerbaru()
    ↓
getDemografiData() → demografi.blade.php
getUmurData() → kelompok-umur.blade.php
getPendidikanData() → pendidikan.blade.php
getPekerjaanData() → pekerjaan.blade.php
getWajibPilihData() → wajib-pilih.blade.php
getPerkawinanData() → perkawinan.blade.php
getAgamaData() → agama.blade.php
    ↓
array_merge semua data
    ↓
return view dengan all data
```

## 🚀 Next Steps

1. **Database Integration**: Ganti dummy data dengan query database real
2. **API Endpoints**: Buat API untuk setiap section
3. **Caching**: Implement cache untuk data yang jarang berubah
4. **Dynamic Loading**: AJAX load untuk section yang membutuhkan

## ✅ Status

-   ✅ Structure refactoring complete
-   ✅ All sections working
-   ✅ Charts and scripts separated
-   ✅ Controller methods organized
-   ✅ Documentation created

Website infografis sekarang lebih mudah untuk debug dan maintain!

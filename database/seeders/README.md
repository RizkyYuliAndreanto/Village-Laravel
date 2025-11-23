# Database Seeders Documentation

## Overview

Telah dibuat seeders untuk semua model yang tersedia dalam sistem Village Laravel. Seeders ini menyediakan data dummy yang realistis untuk development dan testing.

## Seeders yang Dibuat

### 1. Base Data

-   **TahunDataSeeder**: Data tahun 2020-2024 dengan keterangan masing-masing
-   **StrukturOrganisasiSeeder**: Struktur organisasi pemerintahan desa (10 jabatan)

### 2. Statistik Demografi

-   **DemografiPendudukSeeder**: Data penduduk per tahun (total, L/P, sementara, mutasi)
-   **AgamaStatistikSeeder**: Distribusi agama penduduk (Islam, Katolik, Kristen, Hindu, Buddha, Konghucu, Kepercayaan Lain)
-   **PekerjaanStatistikSeeder**: Data pekerjaan (petani, pegawai, wiraswasta, ibu rumah tangga, dll)
-   **PendidikanStatistikSeeder**: Tingkat pendidikan (tidak sekolah sampai S3)
-   **PerkawinanStatistikSeeder**: Status perkawinan (kawin, cerai hidup/mati, tercatat/tidak)
-   **UmurStatistikSeeder**: Kelompok umur (0-4 tahun sampai 50+ tahun)
-   **WajibPilihStatistikSeeder**: Data pemilih (laki-laki, perempuan, total)
-   **DusunStatistikSeeder**: Data per dusun (5 dusun: Mawar, Melati, Kenanga, Cempaka, Anggrek)

### 3. PPID Documents

-   **PpidDokumenSeeder**: 10 dokumen dengan berbagai kategori (berkala, sertamerta, setiap saat, dikecualikan)

### 4. UMKM & Berita

-   **KategoriUmkmSeeder**: 5 kategori UMKM (Kuliner, Perdagangan, Jasa, Pertanian, Fashion)
-   **UmkmSeeder**: 7 UMKM contoh dengan data lengkap
-   **BeritaSeeder**: 30 berita dummy dengan berbagai kategori

## APBDes Seeders (Sementara Tidak Diaktifkan)

Seeders berikut telah dibuat tapi dikomentari karena fitur belum diimplementasi:

-   **ApbdesTahunSeeder**: Data APBDes per tahun (pendapatan, pengeluaran, saldo)
-   **PendapatanSeeder**: Rincian pendapatan desa per kategori
-   **PengeluaranSeeder**: Rincian pengeluaran desa per bidang
-   **LaporanApbdesSeeder**: Laporan keuangan per semester/tahunan
-   **DetailApbdesSeeder**: Detail anggaran vs realisasi

## Cara Menjalankan

```bash
# Menjalankan semua seeders
php artisan db:seed

# Menjalankan seeder tertentu
php artisan db:seed --class=TahunDataSeeder

# Reset database dan jalankan seeders
php artisan migrate:fresh --seed
```

## Data yang Dihasilkan

### Tahun Data: 2020-2024

-   Total penduduk berkembang dari 8,500 (2020) menjadi 9,200 (2024)
-   Pertumbuhan sekitar 2-3% per tahun
-   Data konsisten antar tabel statistik

### Karakteristik Data:

-   **Realistis**: Berdasarkan pola demografis desa Indonesia
-   **Konsisten**: Data antar tabel saling terkait dan logis
-   **Bervariasi**: Ada pertumbuhan/perubahan dari tahun ke tahun
-   **Lengkap**: Semua field terisi dengan nilai yang masuk akal

### Growth Pattern:

-   Penduduk: +2% per tahun
-   Ekonomi/UMKM: +10% omset per tahun
-   Infrastruktur: Bertumbuh sesuai dengan perkembangan desa

## Technical Notes

### Timestamp Handling

-   Sebagian besar model menggunakan custom timestamp: `create_at` dan `updated_at`
-   Model UmurStatistik sudah diperbaiki untuk konsistensi
-   Semua migration menggunakan format timestamp yang sama

### Foreign Key Relations

-   Semua data statistik terhubung ke `tahun_data`
-   UMKM terhubung ke `kategori_umkm`
-   Laporan APBDes terhubung ke `tahun_data`
-   Detail APBDes terhubung ke `laporan_apbdes`

### Data Integrity

-   Unique constraints pada `(tahun_id, ...)` untuk statistik
-   Proper foreign key relationships
-   Data validation sesuai dengan model rules

## Status

✅ **Siap Digunakan**: Semua seeder non-APBDes
⏸️ **Tertunda**: APBDes seeders (menunggu implementasi fitur)

Last Updated: November 17, 2025

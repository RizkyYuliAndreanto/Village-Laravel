# 📋 DOKUMENTASI PENGGUNAAN FITUR APBDes ADMIN

## 🎯 Gambaran Umum

Sistem APBDes (Anggaran Pendapatan dan Belanja Desa) memungkinkan admin untuk mengelola data keuangan desa secara transparan dan terstruktur. Sistem ini mengikuti standar pelaporan APBDes sesuai regulasi pemerintah.

## 📊 Struktur Data APBDes

```
APBDes System
├── Master Data
│   ├── Bidang APBDes (Kategori Utama)
│   └── Sub Bidang APBDes (Sub Kategori)
├── Laporan APBDes (Container Tahunan)
└── Detail Anggaran (Item-item Anggaran)
```

---

## 🚀 PANDUAN STEP-BY-STEP

### **FASE 1: PERSIAPAN MASTER DATA**

#### 1.1 Setup Bidang APBDes

**📍 Lokasi:** Admin Panel → APBDes → Bidang APBDes

**🎯 Tujuan:** Membuat kategori utama untuk mengelompokkan anggaran

**📝 Langkah-langkah:**

1. Klik menu **"APBDes"** di sidebar admin
2. Pilih **"Bidang APBDes"**
3. Klik tombol **"Create"** (+ Tambah)
4. Isi form berikut:

```
📋 FORM BIDANG APBDes
┌─────────────────────────────────────────┐
│ Kode Bidang*    : PDD01                 │
│ Nama Bidang*    : Pendapatan Desa       │
│ Kategori*       : Pendapatan            │
│ Deskripsi       : Semua jenis pendapa..│
│ Urutan          : 1                     │
│ Status Aktif    : ✓ Ya                  │
└─────────────────────────────────────────┘
```

**✅ Bidang Wajib (Sesuai Regulasi):**

1. **Pendapatan Desa** (Kategori: Pendapatan)
2. **Bidang Penyelenggaraan Pemerintahan Desa** (Kategori: Belanja)
3. **Bidang Pelaksanaan Pembangunan Desa** (Kategori: Belanja)
4. **Bidang Pembinaan Kemasyarakatan** (Kategori: Belanja)
5. **Bidang Pemberdayaan Masyarakat** (Kategori: Belanja)
6. **Bidang Penanggulangan Bencana, Darurat dan Mendesak** (Kategori: Belanja)

> 💡 **Tips:** Data bidang sudah tersedia otomatis jika menjalankan seeder. Cek di list bidang apakah sudah ada.

#### 1.2 Setup Sub Bidang (Opsional)

**📍 Lokasi:** Admin Panel → APBDes → Sub Bidang APBDes

**🎯 Tujuan:** Membuat sub-kategori untuk detail yang lebih spesifik

**Contoh Sub Bidang Pendapatan:**

-   Pendapatan Asli Desa (PAD)
-   Transfer/Dana Desa
-   Pendapatan Lain-lain

---

### **FASE 2: MEMBUAT LAPORAN APBDes**

#### 2.1 Buat Laporan Tahunan

**📍 Lokasi:** Admin Panel → APBDes → Laporan APBDes

**🎯 Tujuan:** Membuat container untuk menyimpan semua data anggaran dalam satu tahun

**📝 Langkah-langkah:**

1. Klik **"Laporan APBDes"**
2. Klik **"Create"**
3. Isi form laporan:

```
📋 FORM LAPORAN APBDes
┌─────────────────────────────────────────┐
│ Tahun*          : 2025                  │
│ Nama Laporan*   : APBDes Desa Banyu..   │
│ Bulan Rilis*    : Maret                 │
│ Deskripsi       : Anggaran Pendapat..   │
│ Status*         : Draft / Diterbitkan   │
└─────────────────────────────────────────┘
```

**🔍 Penjelasan Field:**

-   **Tahun:** Tahun anggaran (pastikan tahun sudah tersedia di master tahun)
-   **Nama Laporan:** Misal "APBDes Desa Banyukambang 2025"
-   **Bulan Rilis:** Bulan publikasi laporan
-   **Status:**
    -   `Draft` = Masih dalam proses input
    -   `Diterbitkan` = Sudah final dan bisa dilihat publik

> ⚠️ **Penting:** Mulai dengan status "Draft" saat input data. Ubah ke "Diterbitkan" setelah semua data lengkap.

---

### **FASE 3: INPUT DETAIL ANGGARAN**

#### 3.1 Input Data Pendapatan

**📍 Lokasi:** Admin Panel → APBDes → Input Anggaran

**🎯 Tujuan:** Memasukkan semua sumber pendapatan desa

**📝 Langkah-langkah:**

1. Klik **"Input Anggaran"**
2. Klik **"Create"**
3. Isi form input:

```
📋 FORM INPUT ANGGARAN - PENDAPATAN
┌─────────────────────────────────────────┐
│ INFORMASI LAPORAN                       │
│ Laporan APBDes* : APBDes Desa Banyu..   │
│ Bidang APBDes*  : Pendapatan Desa       │
│ Sub Bidang      : Pendapatan Asli Desa  │
│                                         │
│ DETAIL ANGGARAN                         │
│ Tipe*           : Pendapatan (auto)     │
│ Uraian*         : Pendapatan Asli Desa  │
│ Anggaran*       : Rp 50.000.000        │
│ Realisasi       : Rp 45.000.000        │
│ % Realisasi     : 90% (auto)           │
│ Bulan Realisasi : Maret                 │
│ Keterangan      : Data realisasi Mar..  │
└─────────────────────────────────────────┘
```

**💡 Fitur Otomatis:**

-   **Tipe** otomatis terisi berdasarkan kategori bidang
-   **% Realisasi** dihitung otomatis dari anggaran dan realisasi
-   **Sub Bidang** menyesuaikan dengan bidang yang dipilih

**📊 Contoh Data Pendapatan:**

1. **Pendapatan Asli Desa (PAD)**

    - Anggaran: Rp 50.000.000
    - Realisasi: Rp 45.000.000

2. **Transfer Dana Desa**

    - Anggaran: Rp 800.000.000
    - Realisasi: Rp 750.000.000

3. **Dana Desa dari Pusat**

    - Anggaran: Rp 500.000.000
    - Realisasi: Rp 500.000.000

4. **Alokasi Dana Desa (ADD)**
    - Anggaran: Rp 300.000.000
    - Realisasi: Rp 280.000.000

#### 3.2 Input Data Belanja per Bidang

**🎯 Tujuan:** Memasukkan semua pengeluaran desa per bidang

**📊 Input untuk setiap bidang belanja:**

**A. Bidang Penyelenggaraan Pemerintahan Desa**

```
1. Belanja Pegawai
   - Anggaran: Rp 200.000.000
   - Realisasi: Rp 180.000.000

2. Belanja Barang dan Jasa
   - Anggaran: Rp 150.000.000
   - Realisasi: Rp 140.000.000

3. Belanja Modal
   - Anggaran: Rp 100.000.000
   - Realisasi: Rp 95.000.000
```

**B. Bidang Pelaksanaan Pembangunan Desa**

```
1. Pembangunan Jalan Desa
   - Anggaran: Rp 300.000.000
   - Realisasi: Rp 280.000.000

2. Pembangunan Saluran Air
   - Anggaran: Rp 200.000.000
   - Realisasi: Rp 185.000.000

3. Pembangunan Balai Desa
   - Anggaran: Rp 150.000.000
   - Realisasi: Rp 120.000.000
```

**C. Bidang Pembinaan Kemasyarakatan**

```
1. Kegiatan Keagamaan
   - Anggaran: Rp 75.000.000
   - Realisasi: Rp 70.000.000

2. Kegiatan Olahraga
   - Anggaran: Rp 50.000.000
   - Realisasi: Rp 45.000.000

3. Kegiatan Seni Budaya
   - Anggaran: Rp 40.000.000
   - Realisasi: Rp 35.000.000
```

**D. Bidang Pemberdayaan Masyarakat**

```
1. Pelatihan Keterampilan
   - Anggaran: Rp 100.000.000
   - Realisasi: Rp 90.000.000

2. Bantuan UMKM
   - Anggaran: Rp 150.000.000
   - Realisasi: Rp 140.000.000

3. Program PKK
   - Anggaran: Rp 50.000.000
   - Realisasi: Rp 45.000.000
```

**E. Bidang Penanggulangan Bencana, Darurat dan Mendesak**

```
1. Dana Tanggap Darurat
   - Anggaran: Rp 50.000.000
   - Realisasi: Rp 30.000.000

2. Peralatan Keselamatan
   - Anggaran: Rp 30.000.000
   - Realisasi: Rp 25.000.000
```

---

### **FASE 4: MONITORING & VALIDASI**

#### 4.1 Cek Dashboard APBDes

**📍 Lokasi:** Admin Panel → APBDes → Dashboard APBDes

**🎯 Tujuan:** Memantau ringkasan dan perhitungan otomatis

**📊 Yang Akan Terlihat:**

-   **Total Pendapatan:** Rp 1.575.000.000
-   **Total Belanja:** Rp 1.470.000.000
-   **Surplus:** Rp 105.000.000
-   **Progress realisasi per bidang**

#### 4.2 Validasi Data

**✅ Checklist Validasi:**

-   [ ] Semua bidang sudah ada datanya
-   [ ] Total anggaran sesuai dengan dokumen resmi
-   [ ] Persentase realisasi masuk akal (tidak >100%)
-   [ ] Balance menunjukkan surplus/defisit yang benar
-   [ ] Tidak ada data yang kosong atau minus

#### 4.3 Finalisasi Laporan

**📝 Langkah Finalisasi:**

1. Buka **"Laporan APBDes"**
2. Edit laporan yang sudah dibuat
3. Ubah status dari **"Draft"** ke **"Diterbitkan"**
4. Simpan perubahan

---

## 🔄 WORKFLOW LENGKAP

```
📋 ALUR KERJA ADMIN APBDes
┌─────────────────────────────────────────┐
│ 1. SETUP MASTER DATA                    │
│    ├─ Bidang APBDes (6 bidang utama)    │
│    └─ Sub Bidang APBDes (opsional)      │
│                                         │
│ 2. BUAT LAPORAN APBDes                  │
│    ├─ Tentukan tahun anggaran           │
│    ├─ Beri nama laporan                 │
│    └─ Set status "Draft"                │
│                                         │
│ 3. INPUT DETAIL ANGGARAN                │
│    ├─ Input semua pendapatan desa       │
│    ├─ Input belanja per bidang          │
│    └─ Isi anggaran & realisasi          │
│                                         │
│ 4. MONITORING & VALIDASI                │
│    ├─ Cek dashboard balance             │
│    ├─ Validasi semua data               │
│    └─ Ubah status ke "Diterbitkan"      │
└─────────────────────────────────────────┘
```

---

## ⚙️ FITUR OTOMATIS SISTEM

### 🧮 Perhitungan Otomatis

-   **Persentase Realisasi:** `(Realisasi ÷ Anggaran) × 100%`
-   **Balance:** `Total Pendapatan - Total Belanja`
-   **Status Balance:** Surplus (positif) / Defisit (negatif)

### 🎨 Visual Indicators

-   **Hijau:** Pendapatan, Surplus, Realisasi >90%
-   **Kuning:** Belanja, Realisasi 70-90%
-   **Merah:** Defisit, Realisasi <70%

### 🔍 Filter & Search

-   Filter berdasarkan laporan, bidang, tipe
-   Search berdasarkan uraian
-   Sorting berdasarkan kolom apapun

---

## ❗ TIPS & BEST PRACTICES

### ✅ DO's (Yang Harus Dilakukan)

-   **Gunakan urutan yang benar:** Master Data → Laporan → Detail
-   **Mulai dengan status Draft** sampai data lengkap
-   **Isi anggaran dan realisasi secara konsisten**
-   **Gunakan keterangan yang jelas** untuk audit trail
-   **Cek dashboard balance** secara berkala

### ❌ DON'Ts (Yang Harus Dihindari)

-   **Jangan skip master data** - akan error saat input detail
-   **Jangan langsung status "Diterbitkan"** sebelum validasi
-   **Jangan input realisasi > anggaran** tanpa penjelasan
-   **Jangan hapus bidang** yang sudah ada datanya
-   **Jangan lupa backup data** sebelum perubahan besar

### 🚨 Troubleshooting

**❓ "Bidang tidak muncul saat input?"**

-   Cek apakah bidang sudah dibuat dan status aktif

**❓ "Persentase tidak terhitung otomatis?"**

-   Pastikan anggaran > 0 dan realisasi sudah diisi

**❓ "Dashboard tidak update?"**

-   Refresh halaman atau clear cache browser

**❓ "Data tidak muncul di frontend?"**

-   Pastikan status laporan sudah "Diterbitkan"

---

## 📈 CONTOH HASIL AKHIR

Setelah semua data diinput, dashboard akan menampilkan:

```
🏆 RINGKASAN APBDes DESA BANYUKAMBANG 2025
┌─────────────────────────────────────────┐
│ 💰 Total Pendapatan    : Rp 1.575.000.000 │
│ 💸 Total Belanja       : Rp 1.470.000.000 │
│ 📊 Balance             : Rp 105.000.000   │
│ ✅ Status              : SURPLUS           │
│                                           │
│ 📋 Realisasi per Bidang:                  │
│ ├─ Pemerintahan Desa   : 85.7% ████████▌  │
│ ├─ Pembangunan Desa    : 89.2% █████████▌ │
│ ├─ Kemasyarakatan      : 90.9% ██████████ │
│ ├─ Pemberdayaan        : 91.7% ██████████ │
│ └─ Tanggap Darurat     : 68.8% ███████▌   │
└─────────────────────────────────────────┘
```

---

## 📞 DUKUNGAN

Jika mengalami kesulitan:

1. **Cek dokumentasi ini kembali**
2. **Lihat data contoh yang sudah ada**
3. **Gunakan fitur search & filter**
4. **Backup data sebelum perubahan besar**

**🎯 Target Akhir:** Data APBDes yang transparan, akurat, dan mudah dipahami masyarakat sesuai dengan banner APBDes yang ada di desa.

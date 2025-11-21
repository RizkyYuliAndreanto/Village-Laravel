# 🚀 QUICK START GUIDE - APBDes Admin

## ⚡ Untuk Admin Baru (5 Menit Setup)

### Step 1: Akses Admin Panel

```
1. Buka browser → http://your-domain.com/admin
2. Login dengan akun admin
3. Lihat menu "APBDes" di sidebar
```

### Step 2: Cek Data Master (1 menit)

```
APBDes → Bidang APBDes
✅ Harus ada 6 bidang:
   - Pendapatan Desa
   - Bidang Penyelenggaraan Pemerintahan Desa
   - Bidang Pelaksanaan Pembangunan Desa
   - Bidang Pembinaan Kemasyarakatan
   - Bidang Pemberdayaan Masyarakat
   - Bidang Penanggulangan Bencana, Darurat dan Mendesak
```

### Step 3: Buat Laporan (2 menit)

```
APBDes → Laporan APBDes → Create
- Tahun: 2025
- Nama: "APBDes Desa [Nama Desa] 2025"
- Bulan: [Bulan saat ini]
- Status: Draft
→ SAVE
```

### Step 4: Input Data (2 menit per item)

```
APBDes → Input Anggaran → Create
- Pilih laporan yang baru dibuat
- Pilih bidang (auto-set tipe)
- Isi uraian, anggaran, realisasi
→ SAVE & ADD MORE
```

### Step 5: Cek Dashboard

```
APBDes → Dashboard APBDes
✅ Lihat balance otomatis terhitung
✅ Cek surplus/defisit
✅ Monitor progress per bidang
```

---

## 🎯 Template Input Cepat

### Template Pendapatan

```
1. PAD               → Rp 50.000.000   (Realisasi: 90%)
2. Dana Desa         → Rp 800.000.000  (Realisasi: 95%)
3. ADD               → Rp 300.000.000  (Realisasi: 85%)
4. Bantuan Provinsi  → Rp 150.000.000  (Realisasi: 80%)
```

### Template Belanja

```
Pemerintahan    → Rp 450.000.000  (3 item)
Pembangunan     → Rp 650.000.000  (3 item)
Kemasyarakatan  → Rp 165.000.000  (3 item)
Pemberdayaan    → Rp 300.000.000  (3 item)
Darurat         → Rp 80.000.000   (2 item)
```

---

## 🔧 Jika Ada Masalah

### Tidak Ada Menu APBDes?

```bash
# Jalankan di terminal:
php artisan migrate
php artisan db:seed --class=BidangApbdesSeeder
```

### Dashboard Kosong?

```
1. Pastikan ada laporan dengan status "Diterbitkan"
2. Pastikan ada data detail anggaran
3. Refresh halaman (Ctrl+F5)
```

### Error saat Input?

```
- Pastikan bidang sudah dibuat
- Pastikan laporan sudah dibuat
- Cek format angka (tanpa titik/koma)
```

---

## 📱 SHORTCUT KEYBOARD

-   `Ctrl + S` = Save form
-   `Ctrl + N` = New record
-   `Ctrl + F` = Search table
-   `Esc` = Close modal
-   `Tab` = Next field
-   `Shift + Tab` = Previous field

Total waktu setup lengkap: **15-30 menit** untuk data APBDes satu tahun.

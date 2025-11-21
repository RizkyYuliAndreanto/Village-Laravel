# Hero Section Background Setup Guide

## 📸 Cara Menambahkan Foto Hero

Untuk mengganti background hero section dengan 3 foto yang Anda miliki, ikuti langkah berikut:

### 1. Persiapan Foto

Pastikan foto Anda memiliki:

-   **Resolusi minimal**: 1920x1080px (Full HD)
-   **Format**: JPG atau PNG
-   **Ukuran file**: Maksimal 2MB per foto untuk loading yang optimal

### 2. Penamaan File

Ganti nama foto Anda sesuai dengan:

-   `hero section 1.jpg` - Foto kantor desa exterior (yang pertama)
-   `hero section 2.jpg` - Foto kantor pelayanan interior
-   `hero section 3.jpg` - Foto kantor desa exterior sudut lain

### 3. Upload Foto

Copy foto-foto tersebut ke direktori:

```
public/images/
```

### 4. Struktur File

Setelah upload, struktur akan seperti ini:

```
public/
├── images/
│   ├── hero section 1.jpg  ← Foto pertama
│   ├── hero section 2.jpg  ← Foto kedua
│   ├── hero section 3.jpg  ← Foto ketiga
│   └── hero/               ← Direktori cadangan (opsional)
```

## 🎨 Analisis Warna & Kontras

Berdasarkan analisis foto yang Anda kirim:

### Foto 1 (Kantor Desa - Eksterior)

-   **Warna dominan**: Langit biru-putih, atap merah bata, dinding kuning/krem
-   **Kecerahan**: Terang (outdoor lighting)
-   **Kontras**: Teks putih dengan shadow gelap ✅

### Foto 2 (Kantor Pelayanan - Interior)

-   **Warna dominan**: Coklat kayu, putih marmer, lighting warm
-   **Kecerahan**: Medium (indoor lighting)
-   **Kontras**: Teks putih dengan backdrop blur ✅

### Foto 3 (Kantor Desa - Sudut Lain)

-   **Warna dominan**: Hijau dedaunan, atap merah, dinding putih-krem
-   **Kecerahan**: Terang (outdoor lighting)
-   **Kontras**: Teks putih dengan shadow gelap ✅

## ⚙️ Fitur Slideshow

### Pengaturan Waktu

-   **Interval**: 5 detik per slide
-   **Transisi**: Fade dengan durasi 1 detik
-   **Auto-play**: Ya, dengan pause on hover

### Kontrol Manual

-   **Indikator**: 3 titik di bawah untuk navigasi manual
-   **Hover**: Pause otomatis saat mouse hover
-   **Click**: Klik indikator untuk loncat ke slide tertentu

### Responsivitas

-   **Desktop**: Background attachment fixed (parallax effect)
-   **Mobile**: Background attachment scroll (performa optimal)

## 🔧 Customisasi Lanjutan

### Mengubah Interval Waktu

Edit di file `hero.blade.php` baris:

```javascript
slideInterval = setInterval(nextSlide, 5000); // 5000 = 5 detik
```

### Menambah/Mengurangi Slide

1. Tambah div `.hero-slide` di HTML
2. Tambah button `.slide-indicator`
3. Update array length di JavaScript

### Mengubah Overlay

Edit opacity overlay di:

```html
<div class="absolute inset-0 bg-black/40"></div>
```

-   `/40` = 40% opacity
-   Ubah angka untuk lebih terang/gelap

## ✅ Checklist Setup

-   [ ] Foto sudah dipersiapkan (1920x1080px, <2MB)
-   [ ] File dinamai sesuai: `hero section 1.jpg`, `hero section 2.jpg`, `hero section 3.jpg`
-   [ ] Upload ke `public/images/`
-   [ ] Test di browser untuk memastikan loading
-   [ ] Cek responsivitas di mobile
-   [ ] Pastikan teks tetap terbaca di semua slide

Setelah setup selesai, hero section akan menampilkan slideshow dengan 3 foto Anda secara bergantian setiap 5 detik! ✨

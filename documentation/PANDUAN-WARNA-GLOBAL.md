# 🎨 DOKUMENTASI SISTEM WARNA GLOBAL WEBSITE DESA

## 📋 DAFTAR CLASS CSS UNTUK KOMPONEN

### 🌈 WARNA DASAR (CSS Variables)

```css
--primary-50: #f0fdfa     /* Background sangat terang */
--primary-100: #ccfbf1    /* Background terang */
--primary-400: #2dd4bf    /* Accent terang */
--primary-500: #14b8a6    /* Primary color */
--primary-600: #0d9488    /* Primary dark */
--primary-700: #0f766e    /* Text heading */
--primary-800: #115e59    /* Text dark */

--secondary-300: #67e8f9  /* Cyan medium */
--secondary-400: #22d3ee  /* Cyan bright */
--secondary-500: #06b6d4  /* Cyan primary */
--secondary-600: #0891b2  /* Cyan dark */
```

### 🧩 KOMPONEN UTAMA

#### NAVBAR

-   `navbar-bg` - Background gradient navbar
-   `navbar-text` - Teks putih untuk menu
-   `navbar-text-secondary` - Teks putih transparan 90%
-   `navbar-hover` - Background hover menu
-   `navbar-active` - Background menu aktif

#### SECTION BACKGROUNDS

-   `section-bg-primary` - Gradient cyan-teal terang (untuk home, profil)
-   `section-bg-secondary` - Gradient teal-cyan terang (untuk infografis)
-   `section-bg-alternate` - Gradient lebih terang (untuk variasi)

#### TEXT COLORS

-   `text-heading` - Untuk judul utama (cyan-800)
-   `text-subheading` - Untuk subjudul (cyan-700)
-   `text-body` - Untuk teks body (cyan-700)
-   `text-muted` - Untuk teks sekunder (cyan-600)

#### CARD COMPONENTS

-   `card-bg` - Background card putih transparan + blur
-   `card-shadow` - Shadow cyan yang lembut
-   `card-hover` - Efek hover untuk card
-   `infografis-card` - Card khusus untuk halaman infografis

#### BUTTON COMPONENTS

-   `btn-primary` - Button gradient cyan-teal
-   `btn-secondary` - Button outline cyan

#### STATISTICS

-   `stat-card` - Card untuk statistik
-   `stat-number` - Angka statistik besar
-   `stat-label` - Label statistik

### 📄 PENGGUNAAN PER HALAMAN

#### HOME PAGE

```html
<!-- Section Background -->
<section class="section-bg-primary">
    <h2 class="text-heading">Judul</h2>
    <p class="text-body">Deskripsi</p>
    <div class="card-bg card-shadow">
        <div class="stat-number">200</div>
        <div class="stat-label">Penduduk</div>
    </div>
</section>
```

#### INFOGRAFIS PAGE

```html
<section class="infografis-section">
    <div class="infografis-card">
        <h3 class="infografis-title">Judul</h3>
        <p class="infografis-subtitle">Subtitle</p>
    </div>
</section>
```

#### UMKM PAGE

```html
<section class="umkm-hero">
    <div class="umkm-card">
        <h3 class="umkm-title">Nama UMKM</h3>
        <p class="umkm-description">Deskripsi</p>
    </div>
</section>
```

### 🔧 CARA MENGGANTI WARNA GLOBAL

#### 1. Untuk mengubah warna UTAMA website:

Edit file: `resources/css/colors.css`
Ubah nilai CSS variables:

```css
:root {
    --primary-500: #14b8a6; /* Ganti dengan warna baru */
    --secondary-500: #06b6d4; /* Ganti dengan warna pendukung */
}
```

#### 2. Untuk mengubah warna SECTION tertentu:

```css
/* Untuk mengubah background semua section */
.section-bg-primary {
    background: linear-gradient(to bottom right, #WARNA-BARU-1, #WARNA-BARU-2);
}
```

#### 3. Untuk mengubah warna TEXT:

```css
.text-heading {
    color: #WARNA-HEADING-BARU;
}
```

### 🎯 KOMPONEN YANG SUDAH DIPERBAIKI

✅ **NAVBAR**: Semua teks putih, gradient cyan-teal
✅ **COMPONENTS**: stat-box, news-card, image-frame, card-info
✅ **INFOGRAFIS**: Semua card menggunakan infografis-card
✅ **BUTTONS**: primary-button menggunakan btn-primary
✅ **FOOTER**: Background gradient yang lembut

### 🚀 CARA UPDATE WARNA SETELAH PERUBAHAN

1. Edit file `resources/css/colors.css`
2. Jalankan: `npm run build`
3. Refresh browser

### 📱 RESPONSIVE CONSIDERATIONS

Semua class CSS sudah responsive dan akan menyesuaikan dengan ukuran layar yang berbeda.

---

**CATATAN PENTING**:

-   Jangan menggunakan class Tailwind langsung seperti `bg-gray-800` atau `text-gray-900`
-   Selalu gunakan class CSS global yang sudah dibuat
-   Untuk perubahan warna, ubah di `colors.css` agar konsisten di seluruh website

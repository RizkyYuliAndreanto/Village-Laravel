# Sistem Warna Global Website Desa

## 📋 Overview
Dokumen ini menjelaskan sistem warna global yang telah diimplementasikan untuk memudahkan maintenance dan perubahan warna secara konsisten di seluruh website.

## 🎨 Struktur Warna Utama

### Primary Colors (Teal/Green Theme)
```css
--primary-50: #f0fdfa;   /* Background sangat terang */
--primary-100: #ccfbf1;  /* Background terang */
--primary-200: #99f6e4;  /* Background medium terang */
--primary-300: #5eead4;  /* Accent terang */
--primary-400: #2dd4bf;  /* Accent medium */
--primary-500: #14b8a6;  /* Primary color */
--primary-600: #0d9488;  /* Primary dark */
--primary-700: #0f766e;  /* Text heading */
--primary-800: #115e59;  /* Text dark */
--primary-900: #134e4a;  /* Text very dark */
```

### Secondary Colors (Cyan Theme)
```css
--secondary-50: #ecfeff;   /* Cyan very light */
--secondary-100: #cffafe;  /* Cyan light */
--secondary-200: #a5f3fc;  /* Cyan medium light */
--secondary-300: #67e8f9;  /* Cyan medium */
--secondary-400: #22d3ee;  /* Cyan bright */
--secondary-500: #06b6d4;  /* Cyan primary */
--secondary-600: #0891b2;  /* Cyan dark */
--secondary-700: #0e7490;  /* Cyan very dark */
--secondary-800: #155e75;  /* Cyan text */
--secondary-900: #164e63;  /* Cyan text dark */
```

## 🧭 Class Mapping per Komponen

### 1. Navbar
```css
.navbar-bg                 /* Background gradient navbar */
.navbar-text              /* Text putih */
.navbar-text-secondary    /* Text putih transparan */
.navbar-logo-border       /* Border logo */
.navbar-hover             /* Hover effect */
.navbar-active            /* State aktif */
```

### 2. Section Backgrounds
```css
.section-bg-primary       /* Background section utama */
.section-bg-secondary     /* Background section alternatif */
.section-bg-alternate     /* Background section ketiga */
.section-bg-dark-fix      /* Fix untuk section gelap */
```

### 3. Text Classes
```css
.text-heading             /* Heading utama */
.text-subheading          /* Sub heading */
.text-body                /* Body text */
.text-muted               /* Text yang lebih samar */
.text-accent              /* Text accent */
```

### 4. Card Components
```css
.card-bg                  /* Background card dengan blur */
.card-border              /* Border card */
.card-shadow              /* Shadow card */
.card-hover               /* Hover effect card */
.professional-card        /* Card dengan styling lengkap */
```

### 5. Button Components
```css
.btn-primary              /* Button utama */
.btn-secondary            /* Button sekunder */
```

### 6. Statistics Components
```css
.stat-number              /* Angka statistik */
.stat-label               /* Label statistik */
.stat-card                /* Card statistik */
```

### 7. Infografis Specific
```css
.infografis-section       /* Background section infografis */
.infografis-card          /* Card infografis */
.infografis-title         /* Title infografis */
.infografis-subtitle      /* Subtitle infografis */
```

### 8. UMKM Specific
```css
.umkm-hero                /* Hero section UMKM */
.umkm-card                /* Card UMKM */
.umkm-title               /* Title UMKM */
.umkm-description         /* Deskripsi UMKM */
```

### 9. APBDes Specific
```css
.apbdes-hero              /* Hero APBDes */
.apbdes-card              /* Card APBDes */
.apbdes-title             /* Title APBDes */
.apbdes-subtitle          /* Subtitle APBDes */

/* Status Colors */
.apbdes-pendapatan        /* Background pendapatan */
.apbdes-pendapatan-light  /* Background terang pendapatan */
.apbdes-pendapatan-progress /* Progress bar background */
.apbdes-pendapatan-bar    /* Progress bar fill */
.apbdes-pendapatan-text   /* Text pendapatan */

.apbdes-belanja           /* Background belanja */
.apbdes-belanja-light     /* Background terang belanja */
.apbdes-belanja-progress  /* Progress bar background */
.apbdes-belanja-bar       /* Progress bar fill */
.apbdes-belanja-text      /* Text belanja */

.apbdes-surplus           /* Status surplus */
.apbdes-surplus-light     /* Background terang surplus */
.apbdes-defisit           /* Status defisit */
.apbdes-defisit-light     /* Background terang defisit */
.apbdes-balance           /* Balance umum */
```

### 10. Footer Specific
```css
.footer-bg                /* Background footer */
.footer-text              /* Text footer */
.footer-title             /* Title footer */
.footer-link              /* Link footer */
```

### 11. Utility Classes
```css
.bg-gradient-primary      /* Gradient utama */
.bg-gradient-light        /* Gradient terang */
.bg-gradient-medium       /* Gradient medium */
.border-primary           /* Border primary */
.border-secondary         /* Border secondary */
```

## 🔧 Cara Mengubah Warna Tema

### 1. Mengubah Warna Utama
Edit file `resources/css/colors.css` pada bagian CSS variables:

```css
:root {
    /* Untuk tema biru, ganti dengan: */
    --primary-500: #3b82f6;  /* Blue-500 */
    --secondary-500: #06b6d4; /* Cyan-500 tetap */
    
    /* Untuk tema hijau, ganti dengan: */
    --primary-500: #10b981;  /* Emerald-500 */
    --secondary-500: #059669; /* Emerald-600 */
    
    /* Untuk tema ungu, ganti dengan: */
    --primary-500: #8b5cf6;  /* Violet-500 */
    --secondary-500: #a855f7; /* Purple-500 */
}
```

### 2. Mengubah Gradient
Edit gradient di file yang sama:

```css
.navbar-bg {
    background: linear-gradient(
        to right,
        var(--primary-400),    /* Sesuaikan dengan tema */
        var(--secondary-400),  /* Sesuaikan dengan tema */
        var(--primary-500)     /* Sesuaikan dengan tema */
    );
}
```

## 📁 File yang Sudah Menggunakan Sistem Global

### ✅ Sudah Dikonversi:
- `resources/css/colors.css` - Sistem warna utama
- `resources/css/app.css` - Component classes
- `resources/views/frontend/layouts/partials/navbar.blade.php`
- `resources/views/frontend/apbdes/sections/section_statistics.blade.php`

### ⚠️ Masih Perlu Dikonversi:
- `resources/views/frontend/umkm/**/*.blade.php`
- `resources/views/frontend/ppid/**/*.blade.php`
- `resources/views/frontend/layouts/partials/submenu.blade.php`
- Beberapa file infografis

## 🚀 Best Practices

### 1. Hindari Hardcode Colors
❌ **Jangan:**
```html
<div class="bg-blue-500 text-white">
```

✅ **Gunakan:**
```html
<div class="btn-primary">
```

### 2. Gunakan Semantic Classes
❌ **Jangan:**
```html
<h1 class="text-gray-800">
```

✅ **Gunakan:**
```html
<h1 class="text-heading">
```

### 3. Konsistensi Komponen
Untuk komponen yang sama, gunakan class yang sama:
```html
<!-- Semua card APBDes -->
<div class="apbdes-card">

<!-- Semua card UMKM -->
<div class="umkm-card">

<!-- Semua card infografis -->
<div class="infografis-card">
```

## 🔍 Cara Debug

### 1. Cek CSS Variables
Buka Developer Tools → Elements → Computed → Cari `--primary-500`

### 2. Validasi Class Usage
```bash
# Cari hardcode colors yang belum diganti
grep -r "bg-blue-\|bg-green-\|bg-red-\|text-blue-\|text-green-\|text-red-" resources/views/frontend/
```

### 3. Test Responsivitas
Pastikan semua komponen responsive dengan class yang ada.

## 📞 Support

Jika ada pertanyaan atau perlu bantuan implementasi:
1. Cek dokumentasi ini terlebih dahulu
2. Test di browser dengan Developer Tools
3. Pastikan file CSS sudah ter-compile dengan `npm run build`

## 🎯 Roadmap

- [ ] Konversi semua file UMKM ke sistem global
- [ ] Konversi file PPID
- [ ] Implementasi dark mode
- [ ] Optimisasi CSS dengan purge unused classes
- [ ] Dokumentasi tema kustomisasi untuk client

---

**Catatan:** Sistem ini dibuat untuk memudahkan maintenance dan perubahan tema secara global. Selalu gunakan class yang sudah tersedia sebelum membuat class baru.
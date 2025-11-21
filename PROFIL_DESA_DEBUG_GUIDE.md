# Profil Desa System - Debug Guide

## 🎯 System Overview

Sistem profil desa dengan 4 section utama yang dapat di-debug secara terpisah:

1. **Visi Misi** (Static Content)
2. **Struktur Organisasi** (Dynamic from Database)
3. **Potensi Desa** (Static Content)
4. **Peta Desa** (Google Maps Integration)

## 🗂️ File Structure

```
resources/views/frontend/
├── layouts/
│   └── profil-desa.blade.php           # Custom layout with animations
└── profil-desa/
    ├── index.blade.php                 # Main page with all sections
    ├── visi-misi.blade.php            # Individual Visi Misi page
    ├── struktur-organisasi.blade.php  # Individual Struktur page
    ├── potensi-desa.blade.php         # Individual Potensi page
    └── peta-desa.blade.php            # Individual Map page
```

## 🎨 Design System

### Colors

-   **Primary**: `bg-profil-primary` (Cyan)
-   **Accent**: `bg-profil-accent` (Teal)
-   **Background**: `bg-profil-bg` (Light gray)
-   **Text Heading**: `text-heading` (Dark)
-   **Text Body**: `text-body` (Gray)

### Animations

-   AOS (Animate On Scroll) enabled
-   Fade-up animations with delays
-   Hover effects on cards
-   Smooth scroll behavior

## 🔗 Routes

```php
/profil-desa                    # Main page (all sections)
/profil-desa/visi-misi         # Visi Misi only
/profil-desa/struktur-organisasi # Struktur only
/profil-desa/potensi-desa      # Potensi only
/profil-desa/peta-desa         # Maps only
```

## 🗄️ Database Schema

### struktur_organisasi Table

```sql
- id_struktur (Primary Key)
- nama (VARCHAR)
- jabatan (VARCHAR)
- foto_url (VARCHAR) - path to photo
- keterangan (TEXT) - description
- create_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## 🧪 Debug Instructions

### 1. Testing Static Sections

**Visi Misi & Potensi Desa** tidak memerlukan database:

```bash
# Test individual pages
curl http://localhost/profil-desa/visi-misi
curl http://localhost/profil-desa/potensi-desa
```

### 2. Testing Dynamic Section (Struktur Organisasi)

**Requires database data:**

```sql
-- Sample data for testing
INSERT INTO struktur_organisasi (nama, jabatan, foto_url, keterangan) VALUES
('Budi Santoso', 'Kepala Desa', 'photos/kepala-desa.jpg', 'Memimpin pemerintahan desa'),
('Siti Aminah', 'Sekretaris Desa', 'photos/sekretaris.jpg', 'Mengelola administrasi desa'),
('Ahmad Yusuf', 'Bendahara', 'photos/bendahara.jpg', 'Mengelola keuangan desa');
```

### 3. Testing Maps Section

**Requires Google Maps API:**

-   Add API key to the script
-   Test coordinates: lat: -7.2186, lng: 107.8874

### 4. Debug Each Section Individually

#### Controller Methods

```php
// Test each method individually
/profil-desa/                    → index()
/profil-desa/visi-misi          → visiMisi()
/profil-desa/struktur-organisasi → strukturOrganisasi()
/profil-desa/potensi-desa       → potensiDesa()
/profil-desa/peta-desa          → petaDesa()
```

#### View Components Debug

1. **Layout Check**: Test `profil-desa.blade.php` layout loads correctly
2. **CSS Check**: Verify Tailwind classes render properly
3. **JS Check**: Test AOS animations work
4. **Data Check**: Verify database connection for struktur organisasi

## 🔧 Troubleshooting

### Common Issues

1. **Database Fields**: Ensure field names match (foto_url, not foto)
2. **Routes**: Check route names in navigation links
3. **Images**: Verify storage path for photos
4. **CSS**: Ensure Tailwind classes are compiled

### Debug Commands

```bash
# Check routes
php artisan route:list | grep profil-desa

# Check database
php artisan tinker
>>> App\Models\StrukturOrganisasi::all()

# Clear cache
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

## 📱 Responsive Design

-   Mobile-first approach
-   Grid layouts adapt to screen size
-   Touch-friendly buttons and navigation
-   Optimized images and content

## 🎯 Features by Section

### Visi Misi

-   ✅ Static content
-   ✅ Timeline/targets
-   ✅ Mission numbering
-   ✅ Call-to-action buttons

### Struktur Organisasi

-   ✅ Dynamic data from DB
-   ✅ Photo placeholders
-   ✅ Card-based layout
-   ✅ Statistics display
-   ✅ Empty state handling

### Potensi Desa

-   ✅ Categorized potentials
-   ✅ Statistical data
-   ✅ Investment opportunities
-   ✅ Detailed breakdowns

### Peta Desa

-   ✅ Google Maps placeholder
-   ✅ Geographic data
-   ✅ Boundary information
-   ✅ Points of interest
-   ✅ Transportation info

## 🚀 Next Steps

1. Add Google Maps API key
2. Seed database with real data
3. Add photo upload functionality
4. Implement search/filter features
5. Add admin panel for content management

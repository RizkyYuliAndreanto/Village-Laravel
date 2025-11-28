@extends('frontend.layouts.main')

@section('title', 'Profil Desa - Desa Banyukambang')

@section('content')
@php
    // Fallback: Jika variabel $strukturOrganisasi tidak dikirim dari controller, 
    // inisialisasi sebagai koleksi kosong untuk menghindari error ->count()
    if (!isset($strukturOrganisasi)) {
        $strukturOrganisasi = collect(); 
    }
@endphp
<!-- Hero Section -->
<div class="section-bg-profil py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Hero Content -->
        <div class="text-center text-white">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6">
                🏘️ Profil Desa Banyukambang
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-4xl mx-auto leading-relaxed">
                Mengenal lebih dekat dengan Desa Banyukambang, Wonoasri, Madiun - dari visi misi, struktur organisasi, 
                potensi desa hingga peta wilayah lengkap
            </p>
            
            <!-- Navigation Menu -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#visi-misi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🎯 Visi & Misi
                </a>
                <a href="#struktur-organisasi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    👥 Struktur Organisasi
                </a>
                <a href="#potensi-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🌾 Potensi Desa
                </a>
                <a href="#peta-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🗺️ Peta Desa
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Section 1: Visi & Misi -->
            @include('frontend.profil-desa.visi-misi')

        <!-- Section 2: Struktur Organisasi -->
            @include('frontend.profil-desa.struktur-organisasi')

        <!-- Section 3: Potensi Desa -->
            @include('frontend.profil-desa.potensi-desa')

        <!-- Section 4: Peta Desa -->
            @include('frontend.profil-desa.peta-desa')
@endsection

@push('styles')
<style>
/* Custom styles untuk profil desa */
.section-bg-profil {
    background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
    position: relative;
    z-index: 1;
}

.card-profil {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(8, 145, 178, 0.1);
    position: relative;
    z-index: 2;
}

/* Ensure all content is visible */
main {
    position: relative;
    z-index: 1;
}

body {
    overflow-x: hidden;
    overflow-y: auto;
}

.text-profil-primary {
    color: #0891b2;
}

.bg-profil-primary {
    background-color: #0891b2;
}

.text-profil-accent {
    color: #0e7490;
}

.bg-profil-accent {
    background-color: #0e7490;
}

.bg-profil-bg {
    background-color: #f8fafc;
}

.text-heading {
    color: #1e293b;
}

.text-body {
    color: #64748b;
}

/* Section dividers */
.section-divider {
    position: relative;
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #0891b2, #0e7490);
    margin: 0 auto 1.5rem;
    border-radius: 2px;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 0;
    left: -20px;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, #0891b2, transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Card hover effects */
.hover-profil-primary:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(8, 145, 178, 0.25);
}

/* Animation classes - Fixed visibility */
.animate-on-scroll {
    opacity: 1 !important; /* Force visibility */
    transform: translateY(0) !important; /* Remove transform */
    transition: all 0.8s ease-out;
}

.animate-on-scroll.in-view {
    opacity: 1;
    transform: translateY(0);
}

.stagger-1 { transition-delay: 0.1s; }
.stagger-2 { transition-delay: 0.2s; }
.stagger-3 { transition-delay: 0.3s; }
.stagger-4 { transition-delay: 0.4s; }
.stagger-5 { transition-delay: 0.5s; }
.stagger-6 { transition-delay: 0.6s; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-padding {
        padding: 3rem 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Back to top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.opacity = '1';
        backToTop.style.pointerEvents = 'auto';
    } else {
        backToTop.style.opacity = '0';
        backToTop.style.pointerEvents = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Maps functionality placeholder
function loadMap() {
    // Placeholder untuk inisialisasi Google Maps
    const mapContainer = document.getElementById('map');
    mapContainer.innerHTML = `
        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center">
            <div class="text-center">
                <div class="text-6xl mb-4">🗺️</div>
                <h4 class="text-xl font-bold text-heading mb-2">Peta Sedang Dimuat</h4>
                <p class="text-body">Integrasi dengan Google Maps akan ditambahkan di sini</p>
            </div>
        </div>
    `;
    
    // TODO: Implementasi Google Maps API
    // const map = new google.maps.Map(mapContainer, {
    //     center: { lat: -7.4347, lng: 109.2912 },
    //     zoom: 15
    // });
}

function zoomIn() {
    console.log('Zoom in');
    // TODO: Implementasi zoom in
}

function zoomOut() {
    console.log('Zoom out');
    // TODO: Implementasi zoom out
}
</script>
@endpush
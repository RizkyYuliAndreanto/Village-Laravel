@extends('frontend.layouts.main')

@section('title', 'Profil Desa - Desa Ngengor')

@section('content')
@php
// Fallback: Init variabel jika tidak dikirim dari controller untuk menghindari error
if (!isset($strukturOrganisasi)) $strukturOrganisasi = collect();

// Default values untuk stats jika belum ada (menghindari error undefined index)
$sdmStats = $sdmStats ?? ['laki_laki' => 0, 'perempuan' => 0, 'kk' => 0];
$pekerjaanStats = $pekerjaanStats ?? ['pertanian' => 0, 'buruh_tani' => 0, 'perdagangan' => 0, 'jasa' => 0, 'pns_tni' => 0, 'wiraswasta' => 0, 'pegawai_swasta' => 0, 'belum_bekerja' => 0];
$pendidikanStats = $pendidikanStats ?? ['sarjana' => 0, 'slta' => 0, 'sltp' => 0, 'sd' => 0, 'tidak_tamat' => 0, 'tidak_sekolah' => 0];
@endphp

<div class="section-bg-profil py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6 animate-on-scroll">
                🏘️ Profil Desa Ngengor
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-4xl mx-auto leading-relaxed animate-on-scroll stagger-1">
                Mengenal lebih dekat dengan Desa Ngengor, Pilangkenceng, Madiun - dari visi misi, struktur organisasi,
                potensi desa hingga peta wilayah lengkap
            </p>

            <div class="flex flex-wrap justify-center gap-4 animate-on-scroll stagger-2">
                <a href="#visi-misi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🎯 Visi & Misi
                </a>
                <a href="#struktur-organisasi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    👥 Struktur Organisasi
                </a>
                <a href="#potensi-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🌾 Potensi Desa
                </a>
                <a href="#peta-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🗺️ Peta Desa
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50">
    <div class="container mx-auto px-4 lg:px-8">
        <!--Visi-Misi-->
        @include('frontend.profil-desa.sections.visi-misi')
        <!--STOK-->
        @include('frontend.profil-desa.sections.struktur-organisasi')
        <!--Potensi Desa-->
        @include('frontend.profil-desa.sections.potensi-desa')
        <!--Peta Desa-->
        @include('frontend.profil-desa.sections.peta-desa')
    </div>
</div>

<button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-profil-primary text-white rounded-full shadow-2xl hover:bg-cyan-600 transition-all duration-300 opacity-0 pointer-events-none z-50 flex items-center justify-center">
    <span class="text-xl font-bold">↑</span>
</button>
@endsection

@push('styles')
<style>
    /* Custom Gradient Background */
    .section-bg-profil {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        position: relative;
        z-index: 1;
    }

    /* Background Pattern Overlay */
    .section-bg-profil::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 10%),
            radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 10%);
        background-size: 100% 100%;
        pointer-events: none;
    }

    .card-profil {
        background: #ffffff;
        position: relative;
        z-index: 2;
    }

    .bg-profil-primary {
        background-color: #0891b2;
    }

    .text-profil-primary {
        color: #0891b2;
    }

    .hover-profil-primary:hover {
        transform: translateY(-8px);
    }

    .text-heading {
        color: #1e293b;
    }

    .text-body {
        color: #64748b;
    }

    /* Section Divider Animation */
    .section-divider {
        position: relative;
        width: 80px;
        height: 4px;
        background: #e2e8f0;
        margin: 0 auto 1.5rem;
        border-radius: 2px;
        overflow: hidden;
    }

    .section-divider::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 40%;
        height: 100%;
        background: #0891b2;
        animation: slideDivider 2s infinite ease-in-out alternate;
    }

    @keyframes slideDivider {
        0% {
            left: 0;
        }

        100% {
            left: 60%;
        }
    }

    /* Smooth Scroll padding for sticky header */
    .scroll-mt-24 {
        scroll-margin-top: 6rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Back to top functionality
    const backToTop = document.getElementById('backToTop');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none');
            backToTop.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Simple fade-in animation on scroll
    const observerOptions = {
        threshold: 0.1
    };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-10');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card-profil').forEach(el => {
        el.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
        observer.observe(el);
    });
</script>
@endpush
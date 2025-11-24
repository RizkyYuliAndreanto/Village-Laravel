@extends('frontend.layouts.main')

@section('content')

    {{-- Hero Section --}}
    @include('frontend.home.sections.hero')

    {{-- Profil Desa Section --}}
    @include('frontend.home.sections.profil-desa')

    {{-- Peta Desa Section --}}
    @include('frontend.home.sections.peta-desa')

    {{-- SOTK Section --}}
    @include('frontend.home.sections.sotk')

    {{-- Statistik Penduduk Section --}}
    @include('frontend.home.sections.statistik-penduduk')

    {{-- APBD Desa Section --}}
    @include('frontend.home.sections.apbd-desa')

    {{-- Berita Desa Section --}}
    @include('frontend.home.sections.berita-desa')

    {{-- Potensi Desa Section --}}
    @include('frontend.home.sections.potensi-desa')

    {{-- Galeri Desa Section --}}
    @include('frontend.home.sections.galeri-desa')

@endsection

@push('styles')
<style>
    /* Custom styles untuk home page sections */
    .section-container {
        @apply transition-all duration-300;
    }
    
    .stat-box-animated {
        @apply transform hover:scale-105 transition-transform duration-200;
    }
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations untuk stat boxes
        const statBoxes = document.querySelectorAll('.stat-box');
        
        // Intersection Observer untuk animasi saat scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, {
            threshold: 0.1
        });
        
        statBoxes.forEach(box => {
            observer.observe(box);
        });
    });
</script>
@endpush
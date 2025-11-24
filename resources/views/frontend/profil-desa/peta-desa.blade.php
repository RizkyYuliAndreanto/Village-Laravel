@extends('frontend.layouts.main')

@section('title', 'Peta Desa - Desa Ngengor')

@section('content')
<!-- Hero Section with Breadcrumb -->
<section class="bg-gradient-to-br from-profil-primary via-profil-accent to-teal-700 text-white py-16">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Peta Desa Ngengor</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Lokasi geografis dan pembagian wilayah Desa Ngengor, Pilangkenceng, Madiun, Jawa Timur
            </p>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-20 bg-gradient-to-br from-white to-profil-bg">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-heading mb-4">Lokasi & Geografis</h2>
            <p class="text-lg text-body max-w-3xl mx-auto">
                Desa Banyukambang terletak di kawasan pegunungan dengan pemandangan alam yang indah
                dan udara yang sejuk
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-profil-primary to-profil-accent mx-auto mt-6"></div>
        </div>

        <!-- Interactive Map -->
        <div class="mb-16" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Map Header -->
                <div class="bg-gradient-to-r from-profil-primary to-profil-accent text-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">🗺️</span>
                            <div>
                                <h3 class="text-xl font-bold">Peta Interaktif</h3>
                                <p class="text-white/90 text-sm">Klik dan drag untuk menjelajahi wilayah</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded text-sm transition-all">Satelit</button>
                            <button class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded text-sm transition-all">Jalan</button>
                            <button class="bg-white/20 hover:bg-white/30 px-3 py-1 rounded text-sm transition-all">Terrain</button>
                        </div>
                    </div>
                </div>

                <!-- Map Container -->
                <div class="relative">
                    <div id="google-map" class="w-full rounded-lg overflow-hidden shadow-lg">
                        <!-- Google Maps Embed -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3301.716534966608!2d111.65516857411542!3d-7.478635773736988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5a292282275%3A0x8c8fde03ede35c!2sDesa%20ngengor!5e1!3m2!1sen!2sid!4v1763925548991!5m2!1sen!2sid"
                            width="100%"
                            height="480"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Desa Ngengor">
                        </iframe>

                    </div>

                    <!-- Map Info Overlay -->
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg p-3 max-w-xs">
                        <div class="text-sm">
                            <p class="font-semibold text-heading">📍 Desa Ngengor</p>
                            <p class="text-body">Kec. Pilangkenceng, Kab. Madiun</p>
                            <p class="text-body">Jawa Timur, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Map Info -->
                <div class="p-6 bg-profil-bg">
                    <div class="grid md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span>Kantor Desa</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                            <span>Fasilitas Umum</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <span>Area Wisata</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-profil-primary to-profil-accent text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Kunjungi Desa Ngengor</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Nikmati keindahan alam pegunungan dan kehangatan masyarakat desa yang ramah dan bersahabat
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('profil-desa.potensi-desa') }}"
                class="bg-white text-profil-primary px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all">
                Lihat Potensi Desa
            </a>
            <a href="{{ route('profil-desa.index') }}"
                class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-profil-primary transition-all">
                Kembali ke Profil
            </a>
        </div>
    </div>
</section>

<!-- Map is now embedded directly via iframe -->
@endsection

@push('styles')
<style>
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
</style>
@endpush
@extends('frontend.layouts.main')

@section('title', 'Struktur Organisasi - Desa Banyukambang')

@section('content')
<!-- Hero Section with Breadcrumb -->
<section class="bg-gradient-to-br from-profil-primary via-profil-accent to-teal-700 text-white py-16">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                <li>›</li>
                <li><a href="{{ route('profil-desa.index') }}" class="hover:underline">Profil Desa</a></li>
                <li>›</li>
                <li class="font-semibold">Struktur Organisasi</li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Struktur Organisasi</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Pemerintahan Desa Banyukambang yang melayani dengan dedikasi dan transparansi
            </p>
        </div>
    </div>
</section>

<!-- Struktur Organisasi Content -->
<section class="py-20 bg-gradient-to-br from-white to-profil-bg">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-heading mb-4">Tim Pemerintahan Desa</h2>
            <p class="text-lg text-body max-w-3xl mx-auto">
                Struktur organisasi pemerintahan Desa Banyukambang yang siap melayani masyarakat 
                dengan profesional dan amanah
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-profil-primary to-profil-accent mx-auto mt-6"></div>
        </div>

        @if($strukturOrganisasi && $strukturOrganisasi->count() > 0)
            <!-- Organizational Chart Style -->
            <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8">
                @foreach($strukturOrganisasi as $index => $struktur)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="struktur-card">
                        <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Photo Section -->
                            <div class="relative h-64 bg-gradient-to-br from-cyan-100 to-blue-100">
                                @if($struktur->foto_url)
                                    <img src="{{ asset('storage/' . $struktur->foto_url) }}" 
                                         alt="{{ $struktur->nama }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div class="w-24 h-24 bg-profil-primary rounded-full flex items-center justify-center">
                                            <span class="text-3xl text-white">👤</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                                
                                <!-- Position Badge -->
                                <div class="absolute top-4 right-4">
                                    <div class="bg-white/90 backdrop-blur-sm text-profil-primary px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ sprintf('%02d', $index + 1) }}
                                    </div>
                                </div>
                                
                                <!-- Name Overlay -->
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-xl font-bold text-white mb-1">{{ $struktur->nama }}</h3>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <!-- Position -->
                                <div class="mb-4">
                                    <div class="bg-gradient-to-r from-profil-primary to-profil-accent text-white px-4 py-2 rounded-lg text-center">
                                        <p class="font-semibold">{{ $struktur->jabatan }}</p>
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                @if($struktur->keterangan)
                                    <div class="mb-4">
                                        <p class="text-sm text-body leading-relaxed">{{ $struktur->keterangan }}</p>
                                    </div>
                                @endif
                                
                                <!-- Additional Info -->
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-2">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        <span>Aktif</span>
                                    </div>
                                    <div class="text-xs">
                                        ID: {{ $struktur->id_struktur }}
                                    </div>
                                </div>
                                
                                <!-- Contact Button -->
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <button class="w-full bg-profil-bg hover:bg-profil-primary hover:text-white text-profil-primary py-2 rounded-lg transition-all duration-300 font-medium">
                                        <span class="flex items-center justify-center space-x-2">
                                            <span>💬</span>
                                            <span>Hubungi</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Statistics Section -->
            <div class="mt-16 grid md:grid-cols-4 gap-6" data-aos="fade-up" data-aos-delay="600">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">👥</span>
                    </div>
                    <div class="text-2xl font-bold text-profil-primary mb-1">{{ $strukturOrganisasi->count() }}</div>
                    <div class="text-sm text-gray-600">Total Pengurus</div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">🏛️</span>
                    </div>
                    <div class="text-2xl font-bold text-profil-primary mb-1">5</div>
                    <div class="text-sm text-gray-600">Bidang Kerja</div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">⭐</span>
                    </div>
                    <div class="text-2xl font-bold text-profil-primary mb-1">24/7</div>
                    <div class="text-sm text-gray-600">Jam Layanan</div>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">🎯</span>
                    </div>
                    <div class="text-2xl font-bold text-profil-primary mb-1">100%</div>
                    <div class="text-sm text-gray-600">Komitmen</div>
                </div>
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16" data-aos="fade-up">
                <div class="w-32 h-32 bg-profil-bg rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-6xl">👥</span>
                </div>
                <h3 class="text-2xl font-bold text-heading mb-4">Data Struktur Organisasi Belum Tersedia</h3>
                <p class="text-body mb-8 max-w-md mx-auto">
                    Saat ini data struktur organisasi sedang dalam proses pembaruan. 
                    Silakan kembali lagi nanti atau hubungi kantor desa untuk informasi lebih lanjut.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('profil-desa.index') }}" 
                       class="bg-profil-primary text-white px-8 py-3 rounded-full font-semibold hover:bg-profil-accent transition-all">
                        Kembali ke Profil Desa
                    </a>
                    <a href="#" 
                       class="border-2 border-profil-primary text-profil-primary px-8 py-3 rounded-full font-semibold hover:bg-profil-primary hover:text-white transition-all">
                        Hubungi Kantor Desa
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Organization Chart Section (Optional) -->
@if($strukturOrganisasi && $strukturOrganisasi->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-heading mb-4">Bagan Organisasi</h2>
            <p class="text-lg text-body">Struktur hierarki pemerintahan Desa Banyukambang</p>
        </div>
        
        <!-- Simple Organizational Chart -->
        <div class="flex justify-center" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-profil-bg p-8 rounded-2xl shadow-lg max-w-4xl w-full">
                <div class="text-center text-gray-600">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <p class="text-sm mb-2">📊 Bagan Organisasi Interaktif</p>
                        <p class="text-xs">Sedang dalam pengembangan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-profil-primary to-profil-accent text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Butuh Bantuan atau Informasi?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Tim pemerintahan desa siap melayani kebutuhan masyarakat dengan profesional dan transparan
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('profil-desa.visi-misi') }}" 
               class="bg-white text-profil-primary px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all">
                Lihat Visi Misi
            </a>
            <a href="{{ route('profil-desa.potensi-desa') }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-profil-primary transition-all">
                Potensi Desa
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.text-profil-primary { color: #0891b2; }
.bg-profil-primary { background-color: #0891b2; }
.text-profil-accent { color: #0e7490; }
.bg-profil-accent { background-color: #0e7490; }
.bg-profil-bg { background-color: #f8fafc; }
.text-heading { color: #1e293b; }
.text-body { color: #64748b; }
</style>
@endpush
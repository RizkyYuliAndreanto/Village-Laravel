@extends('frontend.layouts.main')

@section('title', 'Dashboard UMKM')

@section('content')

<!-- Header Section -->
<section class="py-5 hero-gradient">
    <div class="container">
        <div class="rounded p-4" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);">
            <div class="row align-items-center">
                <div class="col-md-8 text-white mb-4 mb-md-0">
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-4 border border-white/30">
                        <i class="fas fa-store text-blue-100 mr-2"></i>
                        <span class="text-blue-100 font-medium">UMKM Desa Ngengor</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Dashboard UMKM</h1>
                    <p class="text-xl text-blue-100 max-w-2xl">
                        Pantau dan analisis perkembangan Usaha Mikro Kecil Menengah di Desa Ngengor
                    </p>
                </div>
                <div class="text-center text-white">
                    <div class="text-5xl font-bold mb-2">
                        {{ \App\Models\Umkm::count() }}
                    </div>
                    <div class="text-blue-100 text-lg font-medium">Total UMKM</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gradient-to-br from-blue-50 to-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- UMKM Aktif -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-xs font-medium">Aktif</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    {{ \App\Models\Umkm::where('status_usaha', 'aktif')->count() }}
                </div>
                <div class="text-gray-600">UMKM Aktif</div>
            </div>

            <!-- UMKM Tidak Aktif -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-pause-circle text-red-600 text-xl"></i>
                    </div>
                    <span class="text-red-600 bg-red-100 px-2 py-1 rounded-full text-xs font-medium">Non-Aktif</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    {{ \App\Models\Umkm::where('status_usaha', '!=', 'aktif')->count() }}
                </div>
                <div class="text-gray-600">UMKM Tidak Aktif</div>
            </div>

            <!-- Total Omset -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-blue-600 bg-blue-100 px-2 py-1 rounded-full text-xs font-medium">Omset</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    Rp {{ number_format(\App\Models\Umkm::where('status_usaha', 'aktif')->sum('omset_per_bulan'), 0, ',', '.') }}
                </div>
                <div class="text-gray-600">Total Omset/Bulan</div>
            </div>

            <!-- Kategori UMKM -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-blue-100 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-purple-600 bg-purple-100 px-2 py-1 rounded-full text-xs font-medium">Kategori</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 mb-1">
                    {{ \App\Models\KategoriUmkm::count() }}
                </div>
                <div class="text-gray-600">Jenis Kategori</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('umkm.index') }}" class="btn-primary group">
                <i class="fas fa-list mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                Lihat Daftar UMKM
            </a>
            <a href="{{ route('infografis.index') }}" class="btn-secondary group">
                <i class="fas fa-chart-bar mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                Lihat Infografis
            </a>
        </div>
    </div>
</section>

<!-- Footer Info -->
<section class="py-12 bg-gradient-to-br from-white to-blue-50">
    <div class="container mx-auto px-6">
        <div class="bg-blue-50 rounded-2xl p-8 border border-blue-200">
            <div class="flex flex-col md:flex-row items-center justify-between text-blue-700">
                <div class="mb-4 md:mb-0">
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span class="font-medium">Terakhir Diperbarui:</span>
                        <span class="ml-2">{{ now()->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-6">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>Data real-time dari sistem desa</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .btn-primary {
        @apply inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all duration-300;
    }
    
    .btn-secondary {
        @apply inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-lg border-2 border-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300;
    }
</style>
@endpush
@extends('frontend.layouts.main')

@section('title', 'Dashboard UMKM')

@section('content')

<!-- Header Section -->
<section class="py-16 bg-gradient-to-r from-cyan-300 via-cyan-400 to-teal-400">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-center">
                <div class="lg:col-span-3 text-white">
                    <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-4 border border-white/30">
                        <i class="fas fa-store text-gray-700 mr-2"></i>
                        <span class="text-gray-700 font-medium">UMKM Desa Ngengor</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Dashboard UMKM</h1>
                    <p class="text-xl text-gray-700 max-w-2xl">
                        Pantau dan analisis perkembangan Usaha Mikro Kecil Menengah di Desa Ngengor
                    </p>
                </div>
                <div class="text-center text-white">
                    <div class="text-5xl font-bold mb-2">
                        {{ \App\Models\Umkm::count() }}
                    </div>
                    <div class="text-gray-700 text-lg font-medium">Total UMKM</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-gradient-to-br from-cyan-50 via-white to-cyan-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- UMKM Aktif -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-xs font-medium">Aktif</span>
                </div>
                <div class="text-3xl font-bold text-cyan-800 mb-1">
                    {{ \App\Models\Umkm::where('status_usaha', 'aktif')->count() }}
                </div>
                <div class="text-gray-600">UMKM Aktif</div>
            </div>

            <!-- Total Kategori -->
            <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tags text-cyan-600 text-xl"></i>
                    </div>
                    <span class="text-cyan-600 bg-cyan-100 px-2 py-1 rounded-full text-xs font-medium">Kategori</span>
                </div>
                <div class="text-3xl font-bold text-cyan-800 mb-1">
                    {{ \App\Models\KategoriUmkm::count() }}
                </div>
                <div class="text-gray-600">Kategori UMKM</div>
            </div>

            <!-- UMKM dengan WhatsApp -->
            <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                    </div>
                    <span class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-xs font-medium">WhatsApp</span>
                </div>
                <div class="text-3xl font-bold text-cyan-800 mb-1">
                    {{ \App\Models\Umkm::whereNotNull('whatsapp')->count() }}
                </div>
                <div class="text-gray-600">Ada WhatsApp</div>
            </div>

            <!-- UMKM dengan Media Sosial -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-share-alt text-pink-600 text-xl"></i>
                    </div>
                    <span class="text-pink-600 bg-pink-100 px-2 py-1 rounded-full text-xs font-medium">Sosial</span>
                </div>
                <div class="text-3xl font-bold text-cyan-800 mb-1">
                    {{ \App\Models\Umkm::where(function($q) { $q->whereNotNull('sosial_instagram')->orWhereNotNull('sosial_facebook'); })->count() }}
                </div>
                <div class="text-gray-600">Ada Media Sosial</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Kategori Chart -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6">
                <h3 class="text-xl font-bold text-blue-800 mb-6 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>UMKM per Kategori
                </h3>
                <div class="space-y-4">
                    @foreach(\App\Models\KategoriUmkm::withCount('umkms')->orderBy('umkms_count', 'desc')->take(5)->get() as $kategori)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <span class="text-2xl mr-3">{{ $kategori->icon }}</span>
                                <span class="font-medium text-gray-800">{{ $kategori->nama_kategori }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 bg-blue-100 rounded-full h-2 mr-3">
                                    @php
                                        $percentage = \App\Models\Umkm::count() > 0 ? ($kategori->umkms_count / \App\Models\Umkm::count()) * 100 : 0;
                                    @endphp
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="font-bold text-blue-800">{{ $kategori->umkms_count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Lokasi Chart -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6">
                <h3 class="text-xl font-bold text-blue-800 mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>UMKM per Dusun
                </h3>
                <div class="space-y-4">
                    @php
                        $dusunStats = \App\Models\Umkm::selectRaw('dusun, COUNT(*) as count')
                            ->whereNotNull('dusun')
                            ->groupBy('dusun')
                            ->orderBy('count', 'desc')
                            ->take(5)
                            ->get();
                    @endphp
                    @foreach($dusunStats as $stat)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-home text-blue-600 mr-3"></i>
                                <span class="font-medium text-gray-800">{{ $stat->dusun }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-32 bg-green-100 rounded-full h-2 mr-3">
                                    @php
                                        $percentage = \App\Models\Umkm::count() > 0 ? ($stat->count / \App\Models\Umkm::count()) * 100 : 0;
                                    @endphp
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="font-bold text-green-800">{{ $stat->count }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent UMKM -->
        <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-blue-800 flex items-center">
                    <i class="fas fa-clock mr-2"></i>UMKM Terbaru
                </h3>
                <a href="{{ route('umkm.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach(\App\Models\Umkm::latest()->take(6)->get() as $umkm)
                    <div class="border border-blue-100 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start space-x-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-xl">{{ $umkm->kategori->icon }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-cyan-800 truncate">{{ $umkm->nama }}</h4>
                                <p class="text-sm text-gray-600">{{ $umkm->pemilik }}</p>
                                <p class="text-xs text-blue-600">{{ $umkm->kategori->nama_kategori }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 text-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
                <a href="{{ route('umkm.index') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua UMKM
                </a>
                
                <a href="{{ route('umkm.index') }}" 
                   class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Daftarkan UMKM
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
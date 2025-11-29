@extends('frontend.layouts.main')

@section('title', $kategori->nama_kategori . ' - Kategori UMKM')
@section('meta_description', 'UMKM kategori ' . $kategori->nama_kategori . ' di desa kami. Temukan berbagai usaha berkualitas.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-teal-400 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-gray-700 text-sm">
                <li>
                    <a href="{{ route('umkm.index') }}" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-home mr-1"></i>UMKM
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ $kategori->nama_kategori }}</span>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gradient-to-br from-cyan-50 via-white to-cyan-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Category Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-cyan-500 to-teal-500 text-white rounded-xl shadow-lg p-8 text-center">
                <div class="mb-4">
                    <span class="text-6xl">{{ $kategori->icon }}</span>
                </div>
                <h1 class="text-4xl font-bold mb-4">{{ $kategori->nama_kategori }}</h1>
                
                @if($kategori->deskripsi)
                    <p class="text-xl text-white/90 mb-4 max-w-3xl mx-auto">{{ $kategori->deskripsi }}</p>
                @endif
                
                <p class="text-white/80 flex items-center justify-center">
                    <i class="fas fa-store mr-2"></i>
                    {{ $umkms->total() }} UMKM tersedia dalam kategori ini
                </p>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6 mb-8">
            <form method="GET" action="{{ route('umkm.kategori', $kategori->slug) }}">
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Search Box -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-teal-800 mb-2">
                            <i class="fas fa-search mr-2"></i>Pencarian
                        </label>
                        <input type="text" 
                               name="search" 
                               class="w-full px-4 py-2 border border-cyan-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors duration-200" 
                               placeholder="Cari nama UMKM atau pemilik..."
                               value="{{ $search }}">
                    </div>

                    <!-- Dusun Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-teal-800 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Dusun
                        </label>
                        <select name="dusun" class="w-full px-4 py-2 border border-cyan-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors duration-200">
                            <option value="">Semua Dusun</option>
                            @foreach($dusuns as $dusunItem)
                                <option value="{{ $dusunItem }}" 
                                        {{ $dusun == $dusunItem ? 'selected' : '' }}>
                                    {{ $dusunItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 text-white font-semibold py-2 px-4 rounded-lg shadow-lg transform transition duration-300 hover:scale-105 hover:shadow-xl">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        @if($search || $dusun)
            <div class="bg-cyan-50 border-l-4 border-cyan-500 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <div class="mr-3">
                        <i class="fas fa-info-circle text-cyan-600"></i>
                    </div>
                    <div>
                        <p class="text-cyan-800 font-medium">
                            Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM
                            @if($search) 
                                untuk pencarian "<strong>{{ $search }}</strong>"
                            @endif
                            @if($dusun)
                                di dusun "<strong>{{ $dusun }}</strong>"
                            @endif
                            dalam kategori {{ $kategori->nama_kategori }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- UMKM Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6">
            @forelse($umkms as $umkm)
                <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <!-- UMKM Logo/Image -->
                    <div class="h-32 md:h-48 bg-gradient-to-br from-cyan-50 to-white flex items-center justify-center p-2 md:p-4">
                        @if($umkm->logo_path)
                            <img src="{{ asset('storage/' . $umkm->logo_path) }}" 
                                 alt="{{ $umkm->nama }}" 
                                 class="max-h-24 md:max-h-40 max-w-full rounded-lg shadow-sm object-cover">
                        @else
                            <div class="text-center text-cyan-600">
                                <i class="fas fa-store text-3xl md:text-5xl mb-1 md:mb-2"></i>
                                <div class="text-xs md:text-sm font-medium">{{ Str::limit($umkm->nama, 15) }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="p-3 md:p-6">
                        <!-- UMKM Name -->
                        <h3 class="text-sm md:text-xl font-bold text-teal-900 mb-1 md:mb-2 leading-tight">{{ Str::limit($umkm->nama, 25) }}</h3>
                        
                        <!-- Owner -->
                        <p class="text-teal-700 mb-2 md:mb-3 flex items-center text-xs md:text-sm">
                            <i class="fas fa-user mr-1 md:mr-2 text-xs"></i>{{ Str::limit($umkm->pemilik, 20) }}
                        </p>

                        <!-- Description -->
                        <p class="text-gray-600 mb-2 md:mb-4 text-xs md:text-sm leading-relaxed hidden md:block">
                            {{ Str::limit($umkm->deskripsi, 100) }}
                        </p>

                        <!-- Contact Info -->
                        <div class="space-y-1 md:space-y-2 mb-2 md:mb-4">
                            @if($umkm->dusun)
                                <div class="text-xs md:text-sm flex items-center text-teal-700">
                                    <i class="fas fa-map-marker-alt mr-1 md:mr-2 text-cyan-600 text-xs"></i>
                                    <span class="truncate">{{ $umkm->dusun }}</span>
                                    @if($umkm->rt && $umkm->rw)
                                        <span class="text-cyan-600 hidden sm:inline"> RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            @if($umkm->telepon)
                                <div class="text-xs md:text-sm flex items-center text-teal-700 hidden md:flex">
                                    <i class="fas fa-phone mr-1 md:mr-2 text-cyan-600 text-xs"></i>
                                    <span>{{ $umkm->telepon }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="bg-gradient-to-r from-cyan-50 to-white px-3 md:px-6 py-2 md:py-4 border-t border-cyan-100">
                        <div class="flex justify-between items-center">
                            <!-- Social Media Links -->
                            <div class="flex space-x-1 md:space-x-2">
                                @if($umkm->whatsapp)
                                    <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-1 md:p-2 rounded-lg transition-colors duration-200" 
                                       target="_blank" 
                                       title="WhatsApp">
                                        <i class="fab fa-whatsapp text-xs md:text-sm"></i>
                                    </a>
                                @endif
                                
                                @if($umkm->sosial_instagram)
                                    <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                       class="bg-pink-500 hover:bg-pink-600 text-white p-1 md:p-2 rounded-lg transition-colors duration-200" 
                                       target="_blank" 
                                       title="Instagram">
                                        <i class="fab fa-instagram text-xs md:text-sm"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Detail Button -->
                            <a href="{{ route('umkm.show', $umkm->slug) }}" 
                               class="bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 text-white font-medium py-1 md:py-2 px-2 md:px-4 rounded-lg transition-all duration-200 flex items-center text-xs md:text-sm">
                                <i class="fas fa-eye mr-1 md:mr-2 text-xs"></i><span class="hidden sm:inline">Detail</span><span class="sm:hidden">Info</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No Results -->
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-xl shadow-lg border border-cyan-100/50">
                        <i class="fas fa-search text-6xl text-cyan-300 mb-4"></i>
                        <h4 class="text-2xl font-bold text-blue-800 mb-2">Tidak ada UMKM ditemukan</h4>
                        <p class="text-blue-600 mb-6">Coba ubah kriteria pencarian Anda</p>
                        <a href="{{ route('umkm.kategori', $kategori->slug) }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                            <i class="fas fa-refresh mr-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($umkms->hasPages())
            <div class="flex justify-center mt-8">
                {{ $umkms->links() }}
            </div>
        @endif

        <!-- Back to All Categories -->
        <div class="mt-8 text-center">
            <a href="{{ route('umkm.index') }}" 
               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Semua UMKM
            </a>
        </div>
    </div>
</section>
@endsection
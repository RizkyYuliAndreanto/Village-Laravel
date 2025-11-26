@extends('frontend.layouts.main')

@section('title', 'Daftar UMKM')
@section('meta_description', 'Temukan dan jelajahi UMKM terbaik di desa kami. Produk berkualitas dari usaha mikro kecil menengah lokal.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-teal-400 py-16">
    <div class="flex justify-center mb-6 w-full">
                @include('frontend.layouts.partials.submenu')
            </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
                <i class="fas fa-store mr-4"></i>UMKM Desa
            </h1>
            <p class="text-xl text-gray-700 max-w-2xl mx-auto">
                Temukan dan jelajahi {{ $totalUmkm }} UMKM dari {{ $totalKategori }} kategori di desa kami
            </p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gradient-to-br from-cyan-50 via-white to-cyan-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6 mb-8">
            <form method="GET" action="{{ route('umkm.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
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

                    <!-- Kategori Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-teal-800 mb-2">
                            <i class="fas fa-tags mr-1"></i>Kategori
                        </label>
                        <select name="kategori" class="w-full px-4 py-2 border border-cyan-200 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-colors duration-200">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                        {{ $kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->icon }} {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dusun Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-teal-800 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>Dusun
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
        @if($search || $kategori_id || $dusun)
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
                            @if($kategori_id)
                                @php $selectedKategori = $kategoris->find($kategori_id); @endphp
                                dalam kategori "<strong>{{ $selectedKategori->nama_kategori }}</strong>"
                            @endif
                            @if($dusun)
                                di dusun "<strong>{{ $dusun }}</strong>"
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- UMKM Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($umkms as $umkm)
                <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <!-- UMKM Logo/Image -->
                    <div class="h-48 bg-gradient-to-br from-cyan-50 to-white flex items-center justify-center p-4">
                        @if($umkm->logo_url)
                        <img src="{{ asset('storage/' . $umkm->logo_url) }}" 
     alt="{{ $umkm->nama }}" 
     class="max-h-40 max-w-full rounded-lg shadow-sm">
                        @else
                            <div class="text-center text-cyan-600">
                                <i class="fas fa-store text-5xl mb-2"></i>
                                <div class="text-sm font-medium">{{ $umkm->nama }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <!-- Kategori Badge -->
                        <div class="mb-4">
                            <span class="inline-block bg-gradient-to-r from-cyan-500 to-teal-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                            </span>
                        </div>

                        <!-- UMKM Name -->
                        <h3 class="text-xl font-bold text-teal-900 mb-2">{{ $umkm->nama }}</h3>
                        
                        <!-- Owner -->
                        <p class="text-teal-700 mb-3 flex items-center">
                            <i class="fas fa-user mr-2"></i>{{ $umkm->pemilik }}
                        </p>

                        <!-- Description -->
                        <p class="text-gray-600 mb-4 text-sm leading-relaxed">
                            {{ Str::limit($umkm->deskripsi, 100) }}
                        </p>

                        <!-- Contact Info -->
                        <div class="space-y-2 mb-4">
                            @if($umkm->dusun)
                                <div class="text-sm flex items-center text-teal-700">
                                    <i class="fas fa-map-marker-alt mr-2 text-cyan-600"></i>
                                    <span>{{ $umkm->dusun }}</span>
                                    @if($umkm->rt && $umkm->rw)
                                        <span class="text-cyan-600"> RT {{ $umkm->rt }}/RW {{ $umkm->rw }}</span>
                                    @endif
                                </div>
                            @endif
                            
                            @if($umkm->telepon)
                                <div class="text-sm flex items-center text-teal-700">
                                    <i class="fas fa-phone mr-2 text-cyan-600"></i>
                                    <span>{{ $umkm->telepon }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="bg-gradient-to-r from-cyan-50 to-white px-6 py-4 border-t border-cyan-100">
                        <div class="flex justify-between items-center">
                            <!-- Social Media Links -->
                            <div class="flex space-x-2">
                                @if($umkm->whatsapp)
                                    <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200" 
                                       target="_blank" 
                                       title="WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                                
                                @if($umkm->sosial_instagram)
                                    <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                       class="bg-pink-500 hover:bg-pink-600 text-white p-2 rounded-lg transition-colors duration-200" 
                                       target="_blank" 
                                       title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Detail Button -->
                            <a href="{{ route('umkm.show', $umkm->slug) }}" 
                               class="bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 flex items-center">
                                <i class="fas fa-eye mr-2"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- No Results -->
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white rounded-xl shadow-lg border border-cyan-100/50">
                        <i class="fas fa-search text-6xl text-cyan-300 mb-4"></i>
                        <h4 class="text-2xl font-bold text-teal-800 mb-2">Tidak ada UMKM ditemukan</h4>
                        <p class="text-cyan-600 mb-6">Coba ubah kriteria pencarian Anda</p>
                        <a href="{{ route('umkm.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
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
    </div>
</section>
@endsection


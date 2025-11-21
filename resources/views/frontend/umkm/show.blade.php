@extends('frontend.layouts.main')

@section('title', $umkm->nama . ' - Detail UMKM')
@section('meta_description', 'Detail lengkap UMKM ' . $umkm->nama . ' - ' . Str::limit($umkm->deskripsi, 150))

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
                    <a href="{{ route('umkm.kategori', $umkm->kategori->slug) }}" class="hover:text-gray-800 transition-colors duration-200">
                        {{ $umkm->kategori->nama_kategori }}
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-gray-800 font-medium">{{ $umkm->nama }}</span>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gradient-to-br from-cyan-50 via-white to-cyan-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- UMKM Header -->
                <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <!-- UMKM Logo -->
                            @if($umkm->logo_url)
                                <img src="{{ $umkm->logo_url }}" 
                                     alt="{{ $umkm->nama }}" 
                                     class="max-h-48 max-w-full rounded-lg shadow-md mb-4 mx-auto">
                            @else
                                <div class="bg-cyan-50 rounded-lg p-8 mb-4">
                                    <i class="fas fa-store text-6xl text-cyan-400"></i>
                                </div>
                            @endif
                            
                            <!-- Kategori Badge -->
                            <span class="inline-block bg-gradient-to-r from-cyan-500 to-teal-500 text-white text-sm font-semibold px-4 py-2 rounded-full">
                                {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                            </span>
                        </div>

                        <div class="md:col-span-2">
                            <!-- UMKM Name & Owner -->
                            <h1 class="text-3xl font-bold text-teal-900 mb-3">{{ $umkm->nama }}</h1>
                            <p class="text-teal-700 mb-4 text-lg flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>Pemilik: <strong>{{ $umkm->pemilik }}</strong></span>
                            </p>

                            <!-- Contact Information -->
                            <div>
                                <h5 class="text-xl font-bold text-teal-800 mb-4 flex items-center">
                                    <i class="fas fa-address-book mr-2"></i>Informasi Kontak
                                </h5>
                                
                                <div class="space-y-3">
                                    <!-- Address -->
                                    @if($umkm->alamat || $umkm->dusun)
                                        <div class="flex items-start">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-3 mt-1"></i>
                                            <div>
                                                <strong class="text-teal-800">Alamat:</strong>
                                                <div class="text-gray-700 mt-1">
                                                    @if($umkm->alamat)
                                                        {{ $umkm->alamat }}<br>
                                                    @endif
                                                    @if($umkm->dusun)
                                                        Dusun {{ $umkm->dusun }}
                                                        @if($umkm->rt && $umkm->rw)
                                                            RT {{ $umkm->rt }}/RW {{ $umkm->rw }}
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Phone -->
                                    @if($umkm->telepon)
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-green-500 mr-3"></i>
                                            <div>
                                                <strong class="text-teal-800">Telepon:</strong>
                                                <a href="tel:{{ $umkm->telepon }}" class="text-cyan-600 hover:text-cyan-800 ml-2">
                                                    {{ $umkm->telepon }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Email -->
                                    @if($umkm->email)
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-cyan-500 mr-3"></i>
                                            <div>
                                                <strong class="text-teal-800">Email:</strong>
                                                <a href="mailto:{{ $umkm->email }}" class="text-cyan-600 hover:text-cyan-800 ml-2">
                                                    {{ $umkm->email }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($umkm->deskripsi)
                    <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6">
                        <h3 class="text-xl font-bold text-teal-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Tentang UMKM
                        </h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($umkm->deskripsi)) !!}
                        </div>
                    </div>
                @endif

                <!-- Products -->
                @if($umkm->produk)
                    <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6">
                        <h3 class="text-xl font-bold text-teal-800 mb-4 flex items-center">
                            <i class="fas fa-box-open mr-2"></i>Produk & Layanan
                        </h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($umkm->produk)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Social Media & Contact -->
                <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6">
                    <h3 class="text-lg font-bold text-teal-800 mb-4 flex items-center">
                        <i class="fas fa-share-alt mr-2"></i>Hubungi Kami
                    </h3>
                    
                    <div class="space-y-3">
                        @if($umkm->whatsapp)
                            <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                               target="_blank"
                               class="flex items-center w-full bg-green-500 hover:bg-green-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fab fa-whatsapp mr-3 text-lg"></i>
                                <span>WhatsApp</span>
                            </a>
                        @endif
                        
                        @if($umkm->sosial_instagram)
                            <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                               target="_blank"
                               class="flex items-center w-full bg-pink-500 hover:bg-pink-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fab fa-instagram mr-3 text-lg"></i>
                                <span>Instagram</span>
                            </a>
                        @endif
                        
                        @if($umkm->sosial_facebook)
                            <a href="https://facebook.com/{{ $umkm->sosial_facebook }}" 
                               target="_blank"
                               class="flex items-center w-full bg-cyan-500 hover:bg-cyan-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fab fa-facebook mr-3 text-lg"></i>
                                <span>Facebook</span>
                            </a>
                        @endif
                        
                        @if($umkm->website)
                            <a href="{{ $umkm->website }}" 
                               target="_blank"
                               class="flex items-center w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                <i class="fas fa-globe mr-3 text-lg"></i>
                                <span>Website</span>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="bg-white rounded-xl shadow-lg border border-cyan-100/50 p-6">
                    <h3 class="text-lg font-bold text-teal-800 mb-4 flex items-center">
                        <i class="fas fa-info mr-2"></i>Info Singkat
                    </h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kategori:</span>
                            <span class="font-medium text-teal-800">{{ $umkm->kategori->nama_kategori }}</span>
                        </div>
                        
                        @if($umkm->dusun)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dusun:</span>
                                <span class="font-medium text-teal-800">{{ $umkm->dusun }}</span>
                            </div>
                        @endif
                        
                        @if($umkm->tahun_berdiri)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tahun Berdiri:</span>
                                <span class="font-medium text-teal-800">{{ $umkm->tahun_berdiri }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Terdaftar:</span>
                            <span class="font-medium text-blue-800">{{ $umkm->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="bg-white rounded-xl shadow-lg border border-blue-100/50 p-6">
                    <a href="{{ route('umkm.index') }}" 
                       class="flex items-center justify-center w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Kembali ke Daftar UMKM</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
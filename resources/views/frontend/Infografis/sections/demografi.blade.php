{{-- Section: Statistik Demografi Penduduk --}}
<section class="min-h-screen infografis-section py-8 sm:py-12 lg:py-20 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-12 h-12 sm:w-16 sm:h-16 lg:w-32 lg:h-32 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-full blur-xl"></div>
        <div class="absolute top-40 right-20 w-8 h-8 sm:w-12 sm:h-12 lg:w-24 lg:h-24 bg-gradient-to-br from-green-400 to-teal-400 rounded-full blur-lg"></div>
        <div class="absolute bottom-20 left-1/4 w-6 h-6 sm:w-10 sm:h-10 lg:w-20 lg:h-20 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full blur-md"></div>
        <div class="absolute bottom-40 right-1/3 w-10 h-10 sm:w-14 sm:h-14 lg:w-28 lg:h-28 bg-gradient-to-br from-orange-400 to-yellow-400 rounded-full blur-lg"></div>
    </div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Hero Section with Icons -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12 lg:gap-16 mb-8 sm:mb-12 lg:mb-16 items-center">
            <!-- Left Side: Text Content -->
            <div class="text-center lg:text-left order-2 lg:order-1">
                <div class="mb-3 sm:mb-4 lg:mb-6">
                    <div class="inline-flex items-center gap-2 sm:gap-3 bg-white/80 backdrop-blur-sm px-3 py-2 sm:px-4 sm:py-2 lg:px-6 lg:py-3 rounded-full shadow-lg mb-3 sm:mb-4">
                        <img src="{{ asset('images/infografis/icon-total-penduduk-Du2cCbAO.svg') }}" alt="Total Penduduk" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8">
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wider">Data Demografi</span>
                    </div>
                </div>
                <h3 class="hero-title text-xl sm:text-2xl lg:text-4xl xl:text-5xl font-extrabold mb-3 sm:mb-4 lg:mb-6 infografis-title leading-tight">
                    Statistik Demografi 
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                        Penduduk
                    </span>
                </h3>
                <p class="hero-subtitle text-sm sm:text-base lg:text-lg xl:text-xl infografis-subtitle max-w-2xl leading-relaxed">
                    Berikut merupakan data terbaru demografi penduduk Desa Banyukambang untuk tahun
                    <span id="tahun-display-demografi" class="font-bold text-primary-700 px-2 py-1 bg-blue-100 rounded">
                        {{ $tahunAktif ?? $tahunDataTerbaru->tahun ?? date('Y') }}
                    </span>.
                </p>
                
                
            </div>
            
            <!-- Right Side: Visual Elements -->
            <div class="flex justify-center lg:justify-end order-1 lg:order-2">
                <div class="relative">
                    <!-- Main circle with icons -->
                    <div class="w-48 h-48 sm:w-64 sm:h-64 lg:w-80 lg:h-80 relative">
                        <!-- Center circle -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 sm:w-32 sm:h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full shadow-2xl flex items-center justify-center">
                            <img src="{{ asset('images/infografis/icon-total-penduduk-Du2cCbAO.svg') }}" alt="Demografi" class="w-12 h-12 sm:w-16 sm:h-16 text-white">
                        </div>
                        
                        <!-- Orbiting icons -->
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce">
                            <img src="{{ asset('images/infografis/icon-laki-CmERQRaD.svg') }}" alt="Laki-laki" class="w-6 h-6 sm:w-10 sm:h-10">
                        </div>
                        
                        <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-pulse">
                            <img src="{{ asset('images/infografis/icon-perempuan-BCmUG8mA.svg') }}" alt="Perempuan" class="w-6 h-6 sm:w-10 sm:h-10">
                        </div>
                        
                        <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-bounce">
                            <img src="{{ asset('images/infografis/icon-kepala-keluarga-D4UfE36x.svg') }}" alt="Keluarga" class="w-6 h-6 sm:w-10 sm:h-10">
                        </div>
                        
                        <div class="absolute top-1/2 left-0 transform -translate-x-1/2 -translate-y-1/2 w-12 h-12 sm:w-16 sm:h-16 bg-white rounded-full shadow-lg flex items-center justify-center animate-pulse">
                            <img src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" alt="Desa" class="w-6 h-6 sm:w-10 sm:h-10 rounded-full">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'demografi',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? $tahunDataTerbaru->tahun ?? date('Y')
        ])

        <!-- Main Stats Grid -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12 border border-white/20">
            <div class="text-center mb-8 sm:mb-10 lg:mb-12">
                <h4 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-3 sm:mb-4">Detail Statistik Penduduk</h4>
                <p class="text-sm sm:text-base lg:text-lg text-gray-600">Klik pada setiap statistik untuk melihat detail lebih lanjut</p>
            </div>
            
            <div id="demografi-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                <!-- Total Penduduk Card -->
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/infografis/icon-total-penduduk-Du2cCbAO.svg') }}" alt="Total Penduduk" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ number_format($totalPenduduk ?? 0) }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Total Penduduk</div>
                        </div>
                    </div>
                </div>

                <!-- Laki-laki Card -->
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-cyan-500 to-teal-500 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/infografis/icon-laki-CmERQRaD.svg') }}" alt="Laki-laki" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ number_format($totalLaki ?? 0) }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Laki-laki</div>
                        </div>
                    </div>
                </div>

                <!-- Perempuan Card -->
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-pink-500 to-rose-500 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/infografis/icon-perempuan-BCmUG8mA.svg') }}" alt="Perempuan" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ number_format($totalPerempuan ?? 0) }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Perempuan</div>
                        </div>
                    </div>
                </div>

                <!-- Penduduk Sementara Card -->
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/infografis/icon-kepala-keluarga-D4UfE36x.svg') }}" alt="Penduduk Sementara" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ number_format($pendudukSementara ?? 0) }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Penduduk Sementara</div>
                        </div>
                    </div>
                </div>

                <!-- Mutasi Penduduk Card -->
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" alt="Mutasi Penduduk" class="w-5 h-5 sm:w-6 sm:h-6 lg:w-8 lg:h-8 rounded-full">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ number_format($mutasiPenduduk ?? 0) }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Mutasi Penduduk</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
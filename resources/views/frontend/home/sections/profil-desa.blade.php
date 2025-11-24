{{-- Section: Profil Desa --}}
<section class="section-container relative pt-16 pb-10">
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-50/50 to-white/80 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(6,182,212,0.05),transparent_50%)]"></div>
    </div>

    <div class="relative container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
            
            <div class="flex-shrink-0 lg:w-1/2" data-aos="fade-right">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-cyan-400 to-teal-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
                    
                    {{-- Menggunakan Logo Kabupaten Madiun yang ada di folder public/images --}}
                    <img class="relative rounded-2xl shadow-2xl w-3/4 lg:w-2/3 mx-auto transform group-hover:scale-105 transition duration-500 bg-white p-4"
                         src="{{ asset('images/Logo_kabupaten_madiun.gif') }}"
                         onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'"
                         alt="Profil Desa Ngengor">
                    
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-cyan-500 to-teal-600 text-white px-4 py-2 rounded-full shadow-lg animate-bounce delay-700">
                        <i class="fas fa-award mr-2"></i>
                        <span class="font-semibold">Desa Digital</span>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2 space-y-8" data-aos="fade-left">
                <div class="inline-flex items-center bg-cyan-100 text-cyan-800 px-4 py-2 rounded-full font-medium">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Tentang Desa Ngengor
                </div>

                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Jelajahi 
                    <span class="bg-gradient-to-r from-cyan-500 to-teal-700 bg-clip-text text-transparent">
                        Desa Digital
                    </span>
                </h2>

                <div class="space-y-4">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Melalui platform digital ini, Anda dapat mengeksplorasi segala aspek kehidupan 
                        dan pemerintahan Desa Ngengor dengan mudah dan transparan.
                    </p>
                    <p class="text-gray-600">
                        Dari informasi demografis, potensi ekonomi, hingga berita terkini - semua tersedia 
                        dalam satu portal terpadu untuk melayani masyarakat dengan lebih baik.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 py-6">
                    <div class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center group-hover:bg-cyan-600 transition-colors duration-300">
                            <i class="fas fa-users text-cyan-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xl text-gray-900">
                                {{ isset($totalPenduduk) ? number_format($totalPenduduk) : '5,420' }}
                            </p>
                            <p class="text-sm text-gray-600">Penduduk</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center group-hover:bg-cyan-600 transition-colors duration-300">
                            <i class="fas fa-store text-cyan-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xl text-gray-900">
                                {{-- Hitung langsung dari Model UMKM --}}
                                {{ \App\Models\Umkm::where('status_usaha', 'aktif')->count() }}+
                            </p>
                            <p class="text-sm text-gray-600">UMKM Aktif</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center group-hover:bg-cyan-600 transition-colors duration-300">
                            <i class="fas fa-map text-cyan-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xl text-gray-900">
                                {{-- Cek apakah Model DusunStatistik ada datanya --}}
                                @if(class_exists('\App\Models\DusunStatistik'))
                                    {{ \App\Models\DusunStatistik::count() ?: 8 }}
                                @else
                                    8
                                @endif
                            </p>
                            <p class="text-sm text-gray-600">Dusun</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-300">
                            <i class="fas fa-digital-tachograph text-blue-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <div>
                            <p class="font-bold text-xl text-gray-900">100%</p>
                            <p class="text-sm text-gray-600">Digital</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('infografis.index') }}" class="btn-primary group shadow-lg hover:shadow-cyan-500/30 transition-all">
                        <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                        Lihat Demografi
                    </a>
                    <a href="{{ route('profil-desa.index') }}" class="btn-secondary group shadow-lg hover:shadow-gray-400/20 transition-all">
                        <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Profil Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
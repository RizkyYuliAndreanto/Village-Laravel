{{-- Section: Profil Desa --}}
<section class="section-container relative pt-24">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-cyan-50/50 to-white/80">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(6,182,212,0.05),transparent_50%)]"></div>
    </div>

    <div class="relative container mx-auto px-6">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
            
            <!-- Image Side -->
            <div class="flex-shrink-0 lg:w-1/2">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-cyan-400 to-teal-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-500"></div>
                    <img class="relative rounded-2xl shadow-2xl w-full max-w-lg mx-auto transform group-hover:scale-105 transition duration-500"
                        src="{{ asset('images/logo-placeholder.jpg') }}"
                        alt="Profil Desa Banyukambang">
                    
                    <!-- Floating badge -->
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-cyan-500 to-teal-600 text-white px-4 py-2 rounded-full shadow-lg">
                        <i class="fas fa-award mr-2"></i>
                        <span class="font-semibold">Desa Digital</span>
                    </div>
                </div>
            </div>

            <!-- Content Side -->
            <div class="lg:w-1/2 space-y-8">
                <!-- Badge -->
                <div class="inline-flex items-center bg-cyan-100 text-cyan-800 px-4 py-2 rounded-full font-medium">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    Tentang Desa Banyukambang
                </div>

                <!-- Title -->
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                    Jelajahi 
                    <span class="bg-gradient-to-r from-cyan-500 to-teal-700 bg-clip-text text-transparent">
                        Desa Digital
                    </span>
                </h2>

                <!-- Description -->
                <div class="space-y-4">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Melalui platform digital ini, Anda dapat mengeksplorasi segala aspek kehidupan 
                        dan pemerintahan Desa Banyukambang dengan mudah dan transparan.
                    </p>
                    <p class="text-gray-600">
                        Dari informasi demografis, potensi ekonomi, hingga berita terkini - semua tersedia 
                        dalam satu portal terpadu untuk melayani masyarakat dengan lebih baik.
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-2 gap-4 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">9,200+</p>
                            <p class="text-sm text-gray-600">Penduduk</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">15+</p>
                            <p class="text-sm text-gray-600">UMKM Aktif</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-map text-cyan-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">8</p>
                            <p class="text-sm text-gray-600">Dusun</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-digital-tachograph text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">100%</p>
                            <p class="text-sm text-gray-600">Digital</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('infografis.index') }}" class="btn-primary group">
                        <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                        Lihat Demografi
                    </a>
                    <a href="{{ route('profil-desa.index') }}" class="btn-secondary group">
                        <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                        Profil Lengkap
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Section: Potensi Desa --}}
<section class="min-h-screen flex flex-col justify-center py-10 sm:py-16 section-bg-primary">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center text-body mb-8 sm:mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-heading">Potensi Desa Banyukambang</h2>
            <p class="text-body max-w-4xl mx-auto text-sm sm:text-base">
                Informasi tentang potensi dan kemajuan Desa di berbagai bidang seperti ekonomi,
                pariwisata, pertanian, industri kreatif, dan kelestarian lingkungan
            </p>
        </div>
        
        @if(isset($potensiDesa) && count($potensiDesa) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                @foreach($potensiDesa as $potensi)
                    <div class="text-center">
                        <x-circle-image-frame 
                            image="{{ $potensi->gambar ? asset('storage/'.$potensi->gambar) : asset('images/logo-placeholder.jpg') }}" 
                            alt="{{ $potensi->nama }}" />
                        <h3 class="text-xl font-bold text-heading mt-6">
                            {{ $potensi->nama }}
                        </h3>
                        <p class="text-body mt-2 max-w-xs mx-auto">
                            {{ $potensi->deskripsi }}
                        </p>
                        @if($potensi->kategori)
                            <span class="inline-block mt-2 px-3 py-1 bg-primary-100 text-primary-800 text-xs font-medium rounded-full">
                                {{ $potensi->kategori }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            {{-- Data potensi berdasarkan data real desa --}}
            <div class="flex overflow-x-auto space-x-4 pb-4 horizontal-scroll sm:grid sm:grid-cols-2 md:grid-cols-3 sm:gap-6 lg:gap-8 sm:space-x-0 sm:overflow-visible sm:pb-0 max-w-6xl mx-auto">
                <div class="flex-none w-64 sm:w-auto text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/lahan-persawahan.jpg') }}" 
                        alt="Lahan Pertanian" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        Lahan Pertanian
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        Lahan pertanian seluas 100 ha yang menjadi sumber ekonomi utama masyarakat desa.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                        Pertanian
                    </span>
                </div>
                
                <div class="flex-none w-64 sm:w-auto text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/lahan-perkebunan.jpg') }}" 
                        alt="Lahan Perkebunan" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        Lahan Perkebunan
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        Perkebunan seluas 13 ha yang menghasilkan berbagai komoditas untuk ekonomi desa.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                        Perkebunan
                    </span>
                </div>
                
                <div class="text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/SDM.jpg') }}" 
                        alt="Sumber Daya Manusia" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        SDM Berkualitas
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        1.697 jiwa penduduk dengan 658 KK yang menjadi kekuatan pembangunan desa.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                        SDM
                    </span>
                </div>
                
                <div class="text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/pekerja-pertaniaan.jpg') }}" 
                        alt="Tenaga Kerja Pertanian" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        Tenaga Kerja Pertanian
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        305 orang tenaga kerja di sektor pertanian sebagai penghasilan utama penduduk.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                        Tenaga Kerja
                    </span>
                </div>
                
                <div class="text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/tenaga-pendidik.jpg') }}" 
                        alt="Tenaga Pendidik" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        Tenaga Pendidik
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        1.397 orang lulusan berbagai jenjang pendidikan yang berkontribusi pada pembangunan.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                        Pendidikan
                    </span>
                </div>
                
                <div class="text-center">
                    <x-circle-image-frame 
                        image="{{ asset('images/fasilitas-umum.jpg') }}" 
                        alt="Fasilitas Umum" />
                    <h3 class="text-xl font-bold text-heading mt-6">
                        Fasilitas Umum
                    </h3>
                    <p class="text-body mt-2 max-w-xs mx-auto">
                        Lapangan olahraga, tempat pendidikan, dan fasilitas umum lainnya untuk mendukung aktivitas masyarakat.
                    </p>
                    <span class="inline-block mt-2 px-3 py-1 bg-cyan-100 text-cyan-800 text-xs font-medium rounded-full">
                        Fasilitas
                    </span>
                </div>
            </div>
        @endif
        
        <div class="flex justify-center sm:justify-end mt-8 sm:mt-10 px-2">
            <a href="{{ route('umkm.index') }}" 
               class="inline-block px-6 py-2 rounded-lg transition-all duration-300 text-white font-semibold text-center"
               style="background: linear-gradient(135deg, #14b8a6, #0891b2); width: 100%; max-width: 200px;">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>
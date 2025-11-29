<section id="galeri" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        {{-- Section Header --}}
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Galeri Desa</h2>
            <div class="w-24 h-1 bg-primary-500 mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Dokumentasi kegiatan terkini dan produk unggulan UMKM Desa Ngengor.
            </p>
        </div>

        {{-- Gallery Grid --}}
        @if($galeri->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galeri as $item)
                    <a href="{{ $item->url }}" class="group relative block overflow-hidden rounded-2xl shadow-lg aspect-[4/5] cursor-pointer">
                        {{-- Image --}}
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->title }}" 
                             class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110">
                        
                        {{-- Overlay Gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                        {{-- Content Overlay --}}
                        <div class="absolute bottom-0 left-0 p-6 w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            {{-- Badge Type --}}
                            <span class="inline-block px-3 py-1 mb-2 text-xs font-bold text-white uppercase tracking-wider rounded-full 
                                {{ $item->type == 'Berita' ? 'bg-primary-500' : 'bg-orange-500' }}">
                                {{ $item->type }}
                            </span>

                            {{-- Title --}}
                            <h3 class="text-white text-lg font-bold leading-tight line-clamp-2 mb-1 group-hover:text-primary-300 transition-colors">
                                {{ $item->title }}
                            </h3>
                            
                            {{-- View Details Text --}}
                            <div class="overflow-hidden h-0 group-hover:h-6 transition-all duration-300">
                                <span class="text-sm text-gray-300 flex items-center mt-2">
                                    Lihat Detail <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-images text-6xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-600">Belum ada galeri yang ditampilkan</h3>
                <p class="text-gray-500">Galeri akan muncul otomatis dari data Berita dan UMKM.</p>
            </div>
        @endif

        {{-- Button Selengkapnya (Opsional) --}}
        <div class="mt-12 text-center">
    {{-- UPDATE href ini --}}
    <a href="{{ route('galeri.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-primary-700 bg-primary-100 hover:bg-primary-200 transition-colors duration-300">
        Lihat Semua Galeri
        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </a>
</div>
    </div>
</section>
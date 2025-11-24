<section class="py-20 bg-gray-50" id="berita">
    <div class="container mx-auto px-6">
        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-heading mb-4">
                Kabar Desa Terbaru
            </h2>
            <div class="w-24 h-1 bg-primary mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-body max-w-2xl mx-auto">
                Dapatkan informasi terkini mengenai kegiatan, pengumuman, dan perkembangan pembangunan di desa kami.
            </p>
        </div>

        {{-- Grid Berita --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($beritaTerbaru as $item)
                <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    {{-- Image Thumbnail --}}
                    <div class="relative h-56 overflow-hidden bg-gray-200">
                        @if(!empty($item->gambar) || !empty($item->image))
                            <img src="{{ asset('storage/' . ($item->gambar ?? $item->image)) }}" 
                                 alt="{{ $item->judul }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        {{-- Badge Kategori --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full shadow-md">
                                {{ $item->kategori ?? 'Berita Desa' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-grow">
                        {{-- Meta Date --}}
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</span>
                        </div>

                        {{-- Judul --}}
                        <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('berita.show', $item->id) }}" class="focus:outline-none">
                                {{ $item->judul }}
                            </a>
                        </h3>

                        {{-- Excerpt --}}
                        <p class="text-gray-600 mb-4 line-clamp-3 text-sm flex-grow">
                            {{ Str::limit(strip_tags($item->isi), 120) }}
                        </p>

                        {{-- Read More Link --}}
                        <div class="pt-4 mt-auto border-t border-gray-100">
                            <a href="{{ route('berita.show', $item->id) }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group-hover:translate-x-1 duration-300">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <p class="text-lg text-gray-500 font-medium">Belum ada berita yang diterbitkan saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Button Lihat Semua --}}
        <div class="text-center mt-8">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 md:text-lg md:px-10 transition-all shadow-lg hover:shadow-blue-500/30">
                Lihat Semua Berita
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>
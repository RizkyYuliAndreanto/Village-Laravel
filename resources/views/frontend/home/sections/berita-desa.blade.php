{{-- Section: Berita Desa --}}
<section class="min-h-screen flex flex-col justify-center section-bg-secondary py-16 sm:py-20">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-8 sm:mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-heading">Berita Desa</h2>
            <p class="text-body text-sm sm:text-base">
                Update terbaru seputar kegiatan, pengumuman, dan pembangunan desa
            </p>
        </div>
        
        @if($berita && $berita->count() > 0)
            <div class="max-w-6xl mx-auto">
                <!-- Berita Utama -->
                <div class="flex overflow-x-auto space-x-4 pb-4 mb-8 horizontal-scroll sm:grid sm:grid-cols-2 md:grid-cols-3 sm:gap-6 lg:gap-10 sm:mb-10 sm:space-x-0 sm:overflow-visible sm:pb-0">
                    @foreach($berita->take(3) as $item)
                        <x-news-card 
                            title="{{ $item->judul }}" 
                            summary="{{ Str::limit($item->isi, 100) }}"
                            date="{{ $item->created_at->format('d M Y') }}"
                            image="{{ $item->gambar_url ? asset('storage/'.$item->gambar_url) : asset('images/logo-placeholder.jpg') }}"
                            url="{{ route('berita.show', $item->id) }}" />
                    @endforeach
                </div>
                
                @if($berita->count() > 3)
                    <!-- Berita Lainnya -->
                    <div class="flex overflow-x-auto space-x-4 pb-4 sm:grid sm:grid-cols-2 md:grid-cols-3 sm:gap-6 lg:gap-10 sm:space-x-0 sm:overflow-visible sm:pb-0">
                        @foreach($berita->skip(3)->take(3) as $item)
                            <x-news-card 
                                title="{{ $item->judul }}" 
                                summary="{{ Str::limit($item->isi, 80) }}"
                                date="{{ $item->created_at->format('d M Y') }}"
                                image="{{ $item->gambar_url ? asset('storage/'.$item->gambar_url) : asset('images/logo-placeholder.jpg') }}"
                                url="{{ route('berita.show', $item->id) }}"
                                size="small" />
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            {{-- Data dummy jika belum ada berita --}}
            <div class="max-w-6xl mx-auto">
                <div class="flex overflow-x-auto space-x-4 pb-4 mb-8 sm:grid sm:grid-cols-2 md:grid-cols-3 sm:gap-6 lg:gap-10 sm:mb-10 sm:space-x-0 sm:overflow-visible sm:pb-0">
                    <div class="flex-none w-72 sm:w-auto"><x-news-card title="Judul Berita Desa 1" summary="Ringkasan berita tentang kegiatan desa yang menarik dan informatif." /></div>
                    <div class="flex-none w-72 sm:w-auto"><x-news-card title="Judul Berita Desa 2" summary="Ringkasan berita tentang pembangunan infrastruktur desa." /></div>
                    <div class="flex-none w-72 sm:w-auto"><x-news-card title="Judul Berita Desa 3" summary="Ringkasan berita tentang program pemberdayaan masyarakat." /></div>
                </div>
                <div class="flex overflow-x-auto space-x-4 pb-4 sm:grid sm:grid-cols-2 md:grid-cols-3 sm:gap-6 lg:gap-10 sm:space-x-0 sm:overflow-visible sm:pb-0">
                    <x-news-card title="Berita Pengumuman" summary="Pengumuman penting untuk warga desa." size="small" />
                    <x-news-card title="Berita Kegiatan" summary="Laporan kegiatan sosial masyarakat." size="small" />
                    <x-news-card title="Berita Pembangunan" summary="Update progress pembangunan desa." size="small" />
                </div>
            </div>
        @endif
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('berita.index') }}" 
               class="btn-primary px-6 py-2 rounded-lg transition-all duration-300">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>
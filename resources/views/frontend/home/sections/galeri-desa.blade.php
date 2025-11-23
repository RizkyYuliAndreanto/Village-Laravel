{{-- Section: Galeri Desa --}}
<section class="min-h-screen flex flex-col justify-center py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-blue-800 dark:text-blue-200 mb-2">Galeri Desa</h2>
        <p class="mb-10 text-blue-600 dark:text-blue-300">Kegiatan Warga Desa Banyukambang</p>
        
        @if(isset($galeri) && count($galeri) > 0)
            {{-- Galeri dari database --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto mb-6">
                @foreach($galeri->take(4) as $item)
                    <x-image-frame 
                        title="{{ $item->judul }}" 
                        summary="{{ $item->deskripsi ?: 'Kegiatan Desa' }}" 
                        image="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('images/logo-placeholder.jpg') }}"
                        date="{{ $item->created_at ? $item->created_at->format('d M Y') : '' }}" />
                @endforeach
            </div>
            
            @if(count($galeri) > 4)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                    @foreach($galeri->skip(4)->take(4) as $item)
                        <x-image-frame 
                            title="{{ $item->judul }}" 
                            summary="{{ $item->deskripsi ?: 'Kegiatan Desa' }}" 
                            image="{{ $item->gambar ? asset('storage/'.$item->gambar) : asset('images/logo-placeholder.jpg') }}"
                            date="{{ $item->created_at ? $item->created_at->format('d M Y') : '' }}" />
                    @endforeach
                </div>
            @endif
        @else
            {{-- Data dummy jika belum ada galeri --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto mb-6">
                <x-image-frame title="Gotong Royong" summary="Kegiatan gotong royong warga desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Rapat Desa" summary="Musyawarah desa bulanan" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Festival Desa" summary="Perayaan hari kemerdekaan" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Pembangunan" summary="Progress pembangunan infrastruktur" image="{{ asset('images/logo-placeholder.jpg') }}" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
                <x-image-frame title="Pelatihan UMKM" summary="Workshop pemberdayaan ekonomi" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Posyandu" summary="Kegiatan pelayanan kesehatan" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Pertanian" summary="Aktivitas pertanian warga" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-image-frame title="Budaya" summary="Pelestarian budaya lokal" image="{{ asset('images/logo-placeholder.jpg') }}" />
            </div>
        @endif
        
        <div class="flex mt-8 justify-end">
            {{-- <a href="{{ route('galeri.index') }}"
                class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
                Lihat Selengkapnya →
            </a> --}}
            <div class="inline-block px-6 py-2.5 bg-blue-400 text-white font-semibold rounded-lg shadow cursor-not-allowed">
                Galeri Segera Hadir
            </div>
        </div>
    </div>
</section>
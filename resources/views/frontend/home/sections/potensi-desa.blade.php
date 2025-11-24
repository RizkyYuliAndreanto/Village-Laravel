<section class="py-20 bg-white" id="potensi">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div class="max-w-2xl mb-4 md:mb-0">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Potensi Desa</h2>
                <div class="w-20 h-1 bg-blue-600 rounded-full mb-4"></div>
                <p class="text-gray-600">Menjelajahi kekayaan produk lokal dan usaha mikro kecil menengah (UMKM) yang menjadi penggerak ekonomi desa.</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 flex items-center group">
                Jelajahi Semua
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($potensiDesa as $umkm)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 group">
                    <div class="relative h-64 overflow-hidden">
                        {{-- Cover Image --}}
                        @if($umkm->foto_url || $umkm->image)
                             {{-- Support format array jika foto multiple, atau string single path --}}
                            @php
                                $foto = is_array($umkm->foto_url) ? ($umkm->foto_url[0] ?? null) : $umkm->foto_url;
                            @endphp
                            <img src="{{ asset('storage/' . $foto) }}" 
                                 alt="{{ $umkm->nama_umkm ?? $umkm->nama_usaha }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-full">
                                {{ $umkm->kategori->nama_kategori ?? 'UMKM' }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('umkm.show', $umkm->slug ?? $umkm->id) }}">
                                {{ $umkm->nama_umkm ?? $umkm->nama_usaha }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2 mb-4">
                            {{ Str::limit($umkm->deskripsi, 100) }}
                        </p>
                        
                        <div class="flex items-center text-sm text-gray-500 pt-4 border-t border-gray-100">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $umkm->pemilik }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Belum ada data potensi desa yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<section class="py-20 bg-gray-50" id="sotk">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Perangkat Desa</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4">Struktur Organisasi Pemerintahan Desa</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($sotk as $pamong)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group">
                    <div class="relative h-80 overflow-hidden bg-gray-200">
                        @if($pamong->foto || $pamong->image)
                            <img src="{{ asset('storage/' . ($pamong->foto ?? $pamong->image)) }}" 
                                 alt="{{ $pamong->nama }}" 
                                 class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                        @else
                            {{-- Placeholder jika tidak ada foto --}}
                            <div class="w-full h-full flex items-center justify-center bg-gray-300">
                                <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $pamong->nama }}</h3>
                        <p class="text-blue-600 font-medium text-sm uppercase tracking-wide">{{ $pamong->jabatan }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500">Data perangkat desa belum tersedia.</p>
                </div>
            @endforelse
        </div>
        
        <div class="text-center mt-10">
            <a href="{{ route('struktur.index') }}" class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-600 hover:text-white transition duration-300">
                Lihat Struktur Lengkap
            </a>
        </div>
    </div>
</section>
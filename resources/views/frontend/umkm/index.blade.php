@extends('frontend.layouts.main')

@section('content')

<section class="bg-gray-50 dark:bg-gray-900 py-12 pt-24 min-h-screen">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 dark:text-gray-100 mb-3">
                <i class="fas fa-store text-indigo-600 dark:text-indigo-400 me-2"></i>
                UMKM Desa
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">
                Temukan dan jelajahi {{ $totalUmkm }} UMKM dari {{ $totalKategori }} kategori di desa kami.
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
            <form method="GET" action="{{ route('umkm.index') }}">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-search me-1"></i>Pencarian
                        </label>
                        <input type="text" 
                               name="search" 
                               class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" 
                               placeholder="Cari nama UMKM..."
                               value="{{ $search }}">
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-tags me-1"></i>Kategori
                        </label>
                        <select name="kategori" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" 
                                        {{ $kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->icon }} {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-map-marker-alt me-1"></i>Dusun
                        </label>
                        <select name="dusun" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">Semua Dusun</option>
                            @foreach($dusuns as $dusunItem)
                                <option value="{{ $dusunItem }}" 
                                        {{ $dusun == $dusunItem ? 'selected' : '' }}>
                                    {{ $dusunItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1 flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>

                    <div class="col-span-2 md:col-span-1 flex items-end">
                         <a href="{{ route('umkm.index') }}" class="w-full bg-gray-300 text-gray-800 font-semibold py-2.5 px-4 rounded-lg shadow-md hover:bg-gray-400 transition text-center">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        @if($search || $kategori_id || $dusun)
            <div class="bg-indigo-50 dark:bg-indigo-900/50 border-l-4 border-indigo-500 p-4 rounded-lg text-indigo-700 dark:text-indigo-300 mb-8 shadow-md">
                <i class="fas fa-info-circle me-2"></i>
                Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM
                @if($search) 
                    untuk pencarian "<strong>{{ $search }}</strong>"
                @endif
                @if($kategori_id)
                    @php $selectedKategori = $kategoris->find($kategori_id); @endphp
                    dalam kategori "<strong>{{ $selectedKategori->nama_kategori }}</strong>"
                @endif
                @if($dusun)
                    di dusun "<strong>{{ $dusun }}</strong>"
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($umkms as $umkm)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 h-full flex flex-col">
                    
                    <div class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4" 
                            style="height: 200px;">
                        @if($umkm->logo_url)
                            {{-- Menggunakan asset('storage/') untuk logo --}}
                            <img src="{{ $umkm->logo_url ? asset('storage/' . $umkm->logo_url) : asset('images/logo-placeholder.jpg') }}" 
                                 alt="{{ $umkm->nama }}" 
                                 class="rounded-lg object-contain w-full h-full" 
                                 style="max-height: 180px; max-width: 100%;">
                        @else
                            <div class="text-center text-gray-400 dark:text-gray-600">
                                <i class="fas fa-store fa-4x mb-2"></i>
                                <div class="text-sm font-medium">{{ $umkm->nama }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        
                        <div class="mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $umkm->nama }}</h5>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                            <i class="fas fa-user me-1"></i>Pemilik: {{ $umkm->pemilik }}
                        </p>

                        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 flex-grow">
                            {{ Str::limit(strip_tags($umkm->deskripsi), 100) }}
                        </p>

                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-3 border-t pt-3 border-gray-100 dark:border-gray-700">
                            @if($umkm->dusun)
                                <div class="mb-1">
                                    <i class="fas fa-map-marker-alt text-red-500 me-2 w-4 inline-block"></i>
                                    {{ $umkm->dusun }}
                                    @if($umkm->rt && $umkm->rw)
                                        RT {{ $umkm->rt }}/RW {{ $umkm->rw }}
                                    @endif
                                </div>
                            @endif
                            
                            @if($umkm->telepon)
                                <div>
                                    <i class="fas fa-phone text-green-500 me-2 w-4 inline-block"></i>
                                    {{ $umkm->telepon }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                        <div class="flex justify-between items-center">
                            <div>
                                @if($umkm->whatsapp)
                                    <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                       class="text-green-500 hover:text-green-600 p-2 rounded-full transition" 
                                       target="_blank" title="WhatsApp">
                                        <i class="fab fa-whatsapp fa-lg"></i>
                                    </a>
                                @endif
                                
                                @if($umkm->sosial_instagram)
                                    <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                       class="text-pink-500 hover:text-pink-600 p-2 rounded-full transition" 
                                       target="_blank" title="Instagram">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                @endif
                            </div>

                            <a href="{{ route('umkm.show', $umkm->slug) }}" 
                               class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition text-sm">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <i class="fas fa-search fa-4x text-gray-400 dark:text-gray-600 mb-3"></i>
                    <h4 class="text-gray-600 dark:text-gray-300 text-xl font-semibold">Tidak ada UMKM ditemukan</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Coba ubah kriteria pencarian Anda.</p>
                    <a href="{{ route('umkm.index') }}" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition">
                        <i class="fas fa-refresh me-1"></i>Reset Filter
                    </a>
                </div>
            @endforelse
        </div>

        @if($umkms->hasPages())
            <div class="mt-8">
                {{ $umkms->links('pagination::tailwind') }} {{-- Menggunakan pagination view Tailwind --}}
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
// Auto-submit form when filter changes
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[name="kategori"], select[name="dusun"]').forEach(function(element) {
        element.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>
@endpush
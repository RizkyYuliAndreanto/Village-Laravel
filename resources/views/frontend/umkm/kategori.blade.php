@extends('frontend.layouts.main')

@section('title', $kategori->nama_kategori . ' - Kategori UMKM')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 py-12 pt-24 min-h-screen">
    <div class="container mx-auto px-6 max-w-6xl">
        
        <nav class="mb-4 text-sm text-gray-500 dark:text-gray-400" aria-label="breadcrumb">
            <ol class="flex space-x-2">
                <li>
                    <a href="{{ route('umkm.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                        <i class="fas fa-home me-1"></i>UMKM
                    </a>
                </li>
                <li class="font-semibold text-gray-700 dark:text-gray-300">
                    / {{ $kategori->nama_kategori }}
                </li>
            </ol>
        </nav>

        <div class="mb-8">
            <div class="bg-indigo-600 dark:bg-indigo-700 text-white rounded-xl shadow-2xl overflow-hidden">
                <div class="p-8 md:p-12 text-center">
                    <div class="mb-4">
                        <span class="text-6xl" style="font-size: 4rem;">{{ $kategori->icon }}</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-3">{{ $kategori->nama_kategori }}</h1>
                    
                    @if($kategori->deskripsi)
                        <p class="text-xl opacity-90 max-w-3xl mx-auto mb-4">{{ $kategori->deskripsi }}</p>
                    @endif
                    
                    <p class="text-sm opacity-80 mb-0">
                        <i class="fas fa-store me-2"></i>
                        {{ $umkms->total() }} UMKM tersedia dalam kategori ini
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg mb-8">
            <form method="GET" action="{{ route('umkm.kategori', $kategori->slug) }}">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <div class="col-span-2 md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-search me-1"></i>Pencarian dalam {{ $kategori->nama_kategori }}
                        </label>
                        <input type="text" 
                               name="search" 
                               class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm" 
                               placeholder="Cari nama UMKM atau pemilik..."
                               value="{{ $search }}">
                    </div>

                    <div class="col-span-1 md:col-span-1">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-map-marker-alt me-1"></i>Dusun
                        </label>
                        <select name="dusun" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm">
                            <option value="">Semua Dusun</option>
                            @foreach($dusuns as $dusunItem)
                                <option value="{{ $dusunItem }}" 
                                        {{ $dusun == $dusunItem ? 'selected' : '' }}>
                                    {{ $dusunItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 md:col-span-1 flex items-end">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($search || $dusun)
            <div class="bg-indigo-50 dark:bg-indigo-900/50 border-l-4 border-indigo-500 p-4 rounded-lg text-indigo-700 dark:text-indigo-300 mb-8 shadow-md">
                <i class="fas fa-info-circle me-2"></i>
                Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM {{ $kategori->nama_kategori }}
                @if($search) 
                    untuk pencarian "<strong>{{ $search }}</strong>"
                @endif
                @if($dusun)
                    di dusun "<strong>{{ $dusun }}</strong>"
                @endif
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            {{-- Menggunakan stat box kustom --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg text-center">
                <i class="fas fa-store fa-2x text-indigo-600 dark:text-indigo-400 mb-2"></i>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $umkms->total() }}</h4>
                <small class="text-gray-500 dark:text-gray-400">Total UMKM</small>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg text-center">
                <i class="fas fa-map-marker-alt fa-2x text-green-600 dark:text-green-400 mb-2"></i>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $dusuns->count() }}</h4>
                <small class="text-gray-500 dark:text-gray-400">Dusun</small>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg text-center">
                <i class="fas fa-check-circle fa-2x text-blue-500 dark:text-blue-400 mb-2"></i>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activeCount }}</h4>
                <small class="text-gray-500 dark:text-gray-400">Aktif</small>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-lg text-center">
                <i class="fab fa-whatsapp fa-2x text-green-500 dark:text-green-400 mb-2"></i>
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $whatsappCount }}</h4>
                <small class="text-gray-500 dark:text-gray-400">WhatsApp</small>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($umkms as $umkm)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden hover:shadow-2xl transform hover:-translate-y-1 transition duration-300 h-full flex flex-col">
                    
                    <div class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-4" 
                            style="height: 200px;">
                        @if($umkm->logo_url)
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
                            @if($umkm->status_usaha == \App\Models\Umkm::STATUS_AKTIF)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                    <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                                </span>
                            @endif
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

                            @if(isset($umkm->tahun_berdiri)) {{-- Asumsi ada kolom tahun_berdiri di Umkm Model --}}
                                <div>
                                    <i class="fas fa-calendar text-blue-500 me-2 w-4 inline-block"></i>
                                    Berdiri {{ $umkm->tahun_berdiri }}
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
                    <div class="mb-6" style="font-size: 4rem; opacity: 0.3;">
                        {{ $kategori->icon }}
                    </div>
                    <h4 class="text-gray-600 dark:text-gray-300 text-xl font-semibold">Belum ada UMKM dalam kategori ini</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        @if($search || $dusun)
                            Tidak ada UMKM yang sesuai dengan kriteria pencarian Anda.
                        @else
                            Kategori {{ $kategori->nama_kategori }} belum memiliki UMKM yang terdaftar.
                        @endif
                    </p>
                    
                    @if($search || $dusun)
                        <a href="{{ route('umkm.kategori', $kategori->slug) }}" class="bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition me-2">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </a>
                    @endif
                    
                    <a href="{{ route('umkm.index') }}" class="bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-gray-400 transition">
                        <i class="fas fa-arrow-left me-1"></i>Lihat Semua UMKM
                    </a>
                </div>
            @endforelse
        </div>

        @if($umkms->hasPages())
            <div class="mt-8">
                {{ $umkms->links('pagination::tailwind') }}
            </div>
        @endif

        @if($otherCategories->count() > 0)
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-2xl font-bold text-gray-800 dark:text-white mb-5">
                    <i class="fas fa-tags me-2 text-indigo-600 dark:text-indigo-400"></i>Kategori Lainnya
                </h4>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($otherCategories as $otherKategori)
                        <a href="{{ route('umkm.kategori', $otherKategori->slug) }}" 
                           class="group block no-underline">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border-2 border-transparent hover:border-indigo-500 transition-all duration-300 transform hover:-translate-y-1 h-full text-center">
                                <div class="mb-3 text-4xl text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 transition" style="font-size: 2.5rem;">
                                    {{ $otherKategori->icon }}
                                </div>
                                <h6 class="text-lg font-bold text-gray-800 dark:text-white mb-1 group-hover:text-indigo-600 transition">{{ $otherKategori->nama_kategori }}</h6>
                                <small class="text-gray-500 dark:text-gray-400">
                                    {{ $otherKategori->umkm_count ?? 0 }} UMKM
                                </small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
// Auto-submit form when filter changes
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('select[name="dusun"]').addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush
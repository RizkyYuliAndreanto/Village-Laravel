@extends('frontend.layouts.main')

@section('title', 'Galeri Desa')
@section('meta_description', 'Galeri foto dan dokumentasi kegiatan Desa - koleksi gambar dari berita dan UMKM terbaru')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                📸 Galeri Desa
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                Dokumentasi visual kegiatan dan potensi Desa melalui koleksi foto dari berita dan UMKM
            </p>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="bg-white py-8 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search Input -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Cari berdasarkan judul atau penulis..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <!-- Type Filter -->
            <div class="flex gap-2">
                <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>📷 Semua</option>
                    <option value="berita" {{ $type == 'berita' ? 'selected' : '' }}>📰 Berita</option>
                    <option value="umkm" {{ $type == 'umkm' ? 'selected' : '' }}>🏪 UMKM</option>
                </select>
                
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                
                @if($search || $type != 'all')
                    <a href="{{ route('galeri.index') }}" 
                       class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                @endif
            </div>
        </form>
        
        <!-- Stats -->
        @if($totalItems > 0)
            <div class="mt-4 text-center text-gray-600">
                Menampilkan {{ count($items) }} dari {{ $totalItems }} gambar
                @if($search) untuk pencarian "{{ $search }}" @endif
                @if($type != 'all') dalam kategori {{ $type }} @endif
            </div>
        @endif
    </div>
</section>

<!-- Gallery Grid -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(count($items) > 0)
            <!-- Image Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach($items as $item)
                    <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Image -->
                        <div class="aspect-square overflow-hidden bg-gray-200">
                            <img src="{{ $item['image'] }}" 
                                 alt="{{ $item['title'] }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 cursor-pointer"
                                 onclick="openImageModal('{{ $item['image'] }}', '{{ $item['title'] }}', '{{ $item['description'] }}')">
                        </div>
                        
                        <!-- Type Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-2 py-1 text-xs font-medium rounded-full text-white
                                {{ $item['type'] == 'berita' ? 'bg-blue-600' : 'bg-green-600' }}">
                                {{ $item['type'] == 'berita' ? '📰 Berita' : '🏪 UMKM' }}
                            </span>
                        </div>
                        
                        <!-- Overlay Info -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                <h3 class="font-semibold text-sm line-clamp-2 mb-1">{{ $item['title'] }}</h3>
                                <p class="text-xs text-gray-300 mb-2">{{ $item['description'] }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs">{{ $item['date'] }}</span>
                                    <a href="{{ $item['url'] }}" 
                                       class="text-xs bg-white/20 hover:bg-white/30 px-2 py-1 rounded-lg transition-colors">
                                        <i class="fas fa-external-link-alt mr-1"></i>Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($totalPages > 1)
                <div class="flex justify-center">
                    <nav class="flex items-center space-x-2">
                        <!-- Previous -->
                        @if($currentPage > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}" 
                               class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        
                        <!-- Page Numbers -->
                        @php
                            $start = max(1, $currentPage - 2);
                            $end = min($totalPages, $currentPage + 2);
                        @endphp
                        
                        @for($i = $start; $i <= $end; $i++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" 
                               class="px-3 py-2 border rounded-lg transition-colors
                                   {{ $i == $currentPage 
                                       ? 'bg-blue-600 text-white border-blue-600' 
                                       : 'bg-white border-gray-300 hover:bg-gray-50' }}">
                                {{ $i }}
                            </a>
                        @endfor
                        
                        <!-- Next -->
                        @if($currentPage < $totalPages)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}" 
                               class="px-3 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </nav>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-images text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-4">Tidak Ada Gambar</h3>
                    <p class="text-gray-500 mb-8">
                        @if($search)
                            Tidak ditemukan gambar untuk pencarian "{{ $search }}"
                        @else
                            Belum ada gambar yang tersedia untuk ditampilkan
                        @endif
                    </p>
                    @if($search || $type != 'all')
                        <a href="{{ route('galeri.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-refresh mr-2"></i>
                            Lihat Semua Gambar
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/80 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-5xl max-h-full">
        <!-- Close Button -->
        <button onclick="closeImageModal()" 
                class="absolute -top-4 -right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center text-black hover:bg-gray-200 transition-colors z-10">
            <i class="fas fa-times"></i>
        </button>
        
        <!-- Modal Content -->
        <div class="bg-white rounded-xl overflow-hidden shadow-2xl max-h-full flex flex-col">
            <!-- Image -->
            <div class="flex-1 overflow-hidden">
                <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[70vh] object-contain">
            </div>
            
            <!-- Info -->
            <div class="p-6 border-t">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-800 mb-2"></h3>
                <p id="modalDescription" class="text-gray-600"></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openImageModal(imageSrc, title, description) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDescription').textContent = description;
    
    const modal = document.getElementById('imageModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush
@endsection
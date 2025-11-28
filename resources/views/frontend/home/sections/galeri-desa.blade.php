{{-- Section: Galeri Desa --}}
<section class="min-h-screen flex flex-col justify-center py-10 sm:py-16 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-blue-800 dark:text-blue-200 mb-2">Galeri Desa</h2>
        <p class="mb-8 sm:mb-10 text-blue-600 dark:text-blue-300 text-sm sm:text-base">Kegiatan Warga Desa Banyukambang</p>
        
        <div id="galeriContainer" class="flex overflow-x-auto space-x-3 pb-4 horizontal-scroll sm:grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 sm:gap-4 lg:gap-6 sm:space-x-0 sm:overflow-visible sm:pb-0 max-w-6xl mx-auto mb-6">
            {{-- Loading placeholder --}}
            @for($i = 0; $i < 8; $i++)
                <div class="flex-none w-48 sm:w-auto animate-pulse">
                    <div class="bg-gray-300 aspect-square rounded-lg mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-3 bg-gray-300 rounded w-3/4"></div>
                </div>
            @endfor
        </div>
        
        <div class="flex mt-6 sm:mt-8 justify-center sm:justify-end px-2">
            <a href="{{ route('galeri.index') }}"
                class="w-full sm:w-auto text-center inline-block px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load galeri images from API
    fetch('{{ route('galeri.api') }}?limit=8')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('galeriContainer');
            
            if (data.success && data.data.length > 0) {
                container.innerHTML = '';
                
                data.data.forEach(item => {
                    const imageFrame = `
                        <div class="flex-none w-48 sm:w-auto relative group cursor-pointer transform hover:scale-105 transition-transform duration-300"
                             onclick="window.location.href='${item.url}'">
                            <div class="aspect-square overflow-hidden rounded-lg shadow-lg">
                                <img src="${item.image}" 
                                     alt="${item.title}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.src='{{ asset('images/logo-placeholder.jpg') }}'">
                            </div>
                            
                            <!-- Type Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2 py-1 text-xs font-medium rounded-full text-white ${item.type === 'berita' ? 'bg-blue-600' : 'bg-green-600'}">
                                    ${item.type === 'berita' ? '📰' : '🏪'}
                                </span>
                            </div>
                            
                            <!-- Info Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                    <h3 class="font-semibold text-sm line-clamp-2 mb-1">${item.title}</h3>
                                    <p class="text-xs text-gray-300 mb-2">${item.description}</p>
                                    <span class="text-xs">${item.date}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    container.innerHTML += imageFrame;
                });
            } else {
                // Fallback to static content if no data
                container.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <div class="text-gray-500 mb-4">
                            <i class="fas fa-images text-4xl mb-2"></i>
                            <p>Galeri akan segera hadir dengan foto-foto dari berita dan UMKM</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.log('Error loading galeri:', error);
            // Keep loading animation if error
        });
});
</script>
@endpush
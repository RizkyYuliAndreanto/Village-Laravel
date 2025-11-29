@extends('frontend.layouts.berita')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-4 md:py-8">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-4 md:mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-xs md:text-sm">
                <li><a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Beranda</a></li>
                <li class="text-primary-400">/</li>
                <li><a href="{{ route('berita.index') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Berita</a></li>
                <li class="text-primary-400">/</li>
                <li class="text-primary-800 font-medium">{{ Str::limit($berita->judul, 30) }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Content Section -->
<div class="bg-white py-6 md:py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 md:gap-12">

            <!-- Konten utama -->
            <main class="lg:col-span-3">
                <article class="card-bg rounded-xl md:rounded-2xl overflow-hidden shadow-lg">
                    
                    <!-- Featured Image -->
                    @if ($berita->image_url)
                        <div class="relative">
                            <img src="{{ $berita->image_url }}" 
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-48 md:h-64 lg:h-96 object-cover"
                                 onerror="this.style.display='none'">
                            
                            <!-- Kategori Badge -->
                            <div class="absolute top-3 md:top-6 left-3 md:left-6">
                                <span class="px-3 md:px-4 py-1 md:py-2 bg-primary-500 text-white rounded-full text-xs md:text-sm font-medium shadow-lg">
                                    📂 {{ ucfirst($berita->kategori) }}
                                </span>
                            </div>
                            
                            <!-- Views Badge -->
                            <div class="absolute top-3 md:top-6 right-3 md:right-6">
                                <span class="px-2 md:px-3 py-1 md:py-2 bg-black bg-opacity-50 text-white rounded-full text-xs md:text-sm flex items-center space-x-1 md:space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>{{ number_format($berita->views ?? 0) }}</span>
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="p-4 md:p-8 lg:p-12">
                        <!-- Title -->
                        <h1 class="text-xl md:text-3xl lg:text-4xl font-bold text-heading mb-4 md:mb-6 leading-tight">
                            {{ $berita->judul }}
                        </h1>

                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-3 md:gap-6 mb-6 md:mb-8 text-xs md:text-sm text-muted">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium">{{ $berita->penulis }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $berita->created_at->translatedFormat('d F Y, H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ ceil(str_word_count(strip_tags($berita->konten ?? $berita->isi)) / 200) }} menit baca</span>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="prose prose-sm md:prose-lg max-w-none text-body leading-relaxed">
                            {!! $berita->konten ?? $berita->isi !!}
                        </div>
                        
                        <!-- Social Share -->
                        <div class="mt-8 md:mt-12 pt-6 md:pt-8 border-t border-primary-100">
                            <h4 class="text-base md:text-lg font-semibold text-heading mb-3 md:mb-4">📢 Bagikan Berita Ini</h4>
                            <div class="flex flex-wrap gap-2 md:gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                    <span>📘 Facebook</span>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" 
                                   target="_blank"
                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-sky-500 text-white rounded-xl hover:bg-sky-600 transition-colors">
                                    <span>🐦 Twitter</span>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" 
                                   target="_blank"
                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                                    <span>📱 WhatsApp</span>
                                </a>
                                <button onclick="copyToClipboard()" 
                                        class="inline-flex items-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors">
                                    <span>🔗 Copy Link</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Berita Terkait -->
                @if($beritaTerkait->count() > 0)
                <section class="mt-8 md:mt-12">
                    <h2 class="text-xl md:text-2xl font-bold text-heading mb-4 md:mb-8 flex items-center">
                        <span class="text-2xl md:text-3xl mr-2 md:mr-3">📰</span>
                        Berita Terkait
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        @foreach($beritaTerkait as $item)
                            <article class="card-bg rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                                <a href="{{ route('berita.show', $item->id) }}" class="block">
                                    @if($item->gambar_url)
                                        <img src="{{ $item->image_url }}" 
                                             alt="{{ $item->judul }}"
                                             class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-32 bg-gradient-to-r from-primary-100 to-secondary-100 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="p-4">
                                        <h4 class="font-semibold text-heading group-hover:text-primary-600 transition-colors line-clamp-2 mb-2">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-sm text-muted">
                                            {{ $item->created_at->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
                @endif
            </main>

            <!-- Sidebar -->
            <aside class="space-y-6 md:space-y-8 mt-8 lg:mt-0">
                <!-- Berita Terbaru -->
                <div class="card-bg rounded-xl md:rounded-2xl p-4 md:p-6">
                    <h3 class="text-lg md:text-xl font-bold text-heading mb-4 md:mb-6 flex items-center">
                        <span class="text-xl md:text-2xl mr-2">🔥</span>
                        Berita Terbaru
                    </h3>

                    <div class="space-y-4">
                        @foreach($beritaTerbaru as $item)
                            <article class="group">
                                <a href="{{ route('berita.show', $item->id) }}" class="block">
                                    <div class="flex space-x-3">
                                        @if($item->gambar_url)
                                            <img src="{{ $item->image_url }}" 
                                                 alt="{{ $item->judul }}"
                                                 class="w-16 h-16 object-cover rounded-lg flex-shrink-0 group-hover:scale-105 transition-transform">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-sm text-heading group-hover:text-primary-600 transition-colors line-clamp-2 mb-1">
                                                {{ $item->judul }}
                                            </h4>
                                            <div class="flex items-center text-xs text-muted space-x-2">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>{{ $item->created_at->translatedFormat('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                            
                            @if(!$loop->last)
                                <hr class="border-primary-100">
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-primary-100">
                        <a href="{{ route('berita.index') }}" 
                           class="btn-secondary w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-medium">
                            <span>📰 Lihat Semua Berita</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card-bg rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-heading mb-4 flex items-center">
                        <span class="text-xl mr-2">📊</span>
                        Statistik
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-body">Dibaca</span>
                            <span class="font-semibold text-primary-600">{{ number_format($berita->views ?? 0) }}x</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-body">Kategori</span>
                            <span class="font-semibold text-primary-600">{{ ucfirst($berita->kategori) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-body">Dipublikasi</span>
                            <span class="font-semibold text-primary-600">{{ $berita->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="card-bg rounded-2xl p-6">
                    <a href="{{ route('berita.index') }}" 
                       class="btn-secondary w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>🔙 Kembali ke Daftar Berita</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- JavaScript for copy link functionality -->
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Success feedback
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<span>✅ Link Disalin!</span>';
        button.classList.add('bg-green-600', 'hover:bg-green-700');
        button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600', 'hover:bg-green-700');
            button.classList.add('bg-gray-600', 'hover:bg-gray-700');
        }, 2000);
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<span>✅ Link Disalin!</span>';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    });
}
</script>
@endsection

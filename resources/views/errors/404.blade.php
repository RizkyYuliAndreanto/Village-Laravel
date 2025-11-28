@extends('frontend.layouts.main')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-50 via-secondary-50 to-cyan-50 flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" width=\"32\" height=\"32\" fill=\"none\" stroke=\"%2314b8a6\"><path d=\"M0 0.5H32M0 8.5H32M0 16.5H32M0 24.5H32M0.5 0V32M8.5 0V32M16.5 0V32M24.5 0V32\"/></svg></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Village Logo Animation -->
        <div class="mb-8 relative">
            <div class="inline-flex items-center justify-center w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 navbar-bg rounded-full animate-pulse shadow-2xl"></div>
                <div class="relative z-10 w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <img class="w-20 h-20 rounded-full border-2 border-primary-500" 
                         src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" 
                         alt="Logo Desa Banyukambang">
                </div>
            </div>
        </div>

        <!-- 404 Number with Village Style -->
        <div class="mb-8">
            <h1 class="text-9xl sm:text-[12rem] font-extrabold text-transparent bg-gradient-to-r from-primary-500 via-secondary-400 to-cyan-500 bg-clip-text animate-bounce leading-none tracking-tight">
                404
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-4xl font-bold text-primary-800 mb-4">
                🏘️ Halaman Tidak Ditemukan
            </h2>
            <p class="text-lg sm:text-xl text-primary-600 mb-6 leading-relaxed max-w-2xl mx-auto">
                Mohon maaf, halaman yang Anda cari tidak dapat ditemukan di website 
                <span class="font-semibold text-primary-700">Desa Banyukambang</span>. 
                Mungkin halaman tersebut telah dipindahkan atau alamat yang Anda masukkan salah.
            </p>
        </div>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Home Card -->
            <a href="{{ route('home') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-primary-200 hover:border-primary-400">
                <div class="text-primary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🏠
                </div>
                <h3 class="text-xl font-bold text-primary-800 mb-2">Beranda</h3>
                <p class="text-primary-600 text-sm">Kembali ke halaman utama website desa</p>
                <div class="mt-4 inline-flex items-center text-primary-600 font-medium">
                    <span class="mr-2">Kunjungi</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Profil Desa Card -->
            <a href="{{ route('profil-desa.index') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-secondary-200 hover:border-secondary-400">
                <div class="text-secondary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    ℹ️
                </div>
                <h3 class="text-xl font-bold text-secondary-800 mb-2">Profil Desa</h3>
                <p class="text-secondary-600 text-sm">Informasi lengkap tentang Desa Banyukambang</p>
                <div class="mt-4 inline-flex items-center text-secondary-600 font-medium">
                    <span class="mr-2">Lihat Profil</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>

            <!-- Infografis Card -->
            <a href="{{ route('infografis.index') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-cyan-200 hover:border-cyan-400">
                <div class="text-cyan-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    📊
                </div>
                <h3 class="text-xl font-bold text-cyan-800 mb-2">Infografis</h3>
                <p class="text-cyan-600 text-sm">Data dan statistik desa dalam bentuk visual</p>
                <div class="mt-4 inline-flex items-center text-cyan-600 font-medium">
                    <span class="mr-2">Lihat Data</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>
        </div>

        <!-- Secondary Navigation -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
            <a href="{{ route('umkm.index') }}" 
               class="flex items-center justify-center bg-white border-2 border-primary-300 hover:border-primary-500 text-gray-800 px-6 py-4 rounded-lg font-bold hover:bg-primary-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-store mr-3 text-primary-600"></i>
                <span class="text-gray-800 font-bold" style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">UMKM Desa</span>
            </a>

            <a href="{{ route('belanja.index') }}" 
               class="flex items-center justify-center bg-white border-2 border-secondary-300 hover:border-secondary-500 text-gray-800 px-6 py-4 rounded-lg font-bold hover:bg-secondary-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-coins mr-3 text-secondary-600"></i>
                <span class="text-gray-800 font-bold" style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">APBDES</span>
            </a>

            <a href="{{ route('berita.index') }}" 
               class="flex items-center justify-center bg-white border-2 border-cyan-300 hover:border-cyan-500 text-gray-800 px-6 py-4 rounded-lg font-bold hover:bg-cyan-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-newspaper mr-3 text-cyan-600"></i>
                <span class="text-gray-800 font-bold" style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Berita Desa</span>
            </a>
        </div>

        <!-- Help Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-primary-200">
            <div class="text-5xl mb-4">🤝</div>
            <h3 class="text-2xl font-bold text-primary-800 mb-4">Butuh Bantuan?</h3>
            <p class="text-primary-600 mb-6 leading-relaxed">
                Jika Anda mengalami kesulitan menemukan informasi yang Anda cari, 
                jangan ragu untuk menghubungi kami melalui kontak yang tersedia.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <div class="flex items-center text-primary-700">
                    <i class="fas fa-phone mr-3 text-primary-500"></i>
                    <span class="font-medium">Kantor Desa: (0351) XXX-XXXX</span>
                </div>
                <div class="flex items-center text-primary-700">
                    <i class="fas fa-envelope mr-3 text-primary-500"></i>
                    <span class="font-medium">Email: info@desa-banyukambang.id</span>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-12">
            <button onclick="window.history.back()" 
                    class="inline-flex items-center px-8 py-3 bg-white border-2 border-primary-400 hover:border-primary-600 text-gray-800 font-bold rounded-full hover:bg-primary-50 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-3 text-primary-600"></i>
                <span style="text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Kembali ke Halaman Sebelumnya</span>
            </button>
        </div>

    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-primary-300/20 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
    <div class="absolute top-1/4 right-10 w-16 h-16 bg-secondary-300/20 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-cyan-300/20 rounded-full animate-bounce" style="animation-delay: 1.5s;"></div>
    <div class="absolute bottom-1/4 right-1/4 w-24 h-24 bg-primary-200/20 rounded-full animate-bounce" style="animation-delay: 2s;"></div>

</div>

@push('styles')
<style>
/* Custom animations for village theme */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Village-themed gradient backgrounds */
.navbar-bg {
    background: linear-gradient(135deg, var(--secondary-400), var(--primary-500), var(--secondary-500));
}

/* Enhanced hover effects */
.hover-lift:hover {
    transform: translateY(-8px) scale(1.05);
}

/* Responsive text shadows */
.text-shadow {
    text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Smooth background gradients */
.bg-village-gradient {
    background: linear-gradient(
        135deg,
        var(--primary-50) 0%,
        var(--secondary-50) 25%,
        var(--primary-100) 50%,
        var(--secondary-100) 75%,
        var(--primary-50) 100%
    );
}

/* Custom card shadows */
.village-shadow {
    box-shadow: 
        0 10px 25px rgba(20, 184, 166, 0.1),
        0 4px 10px rgba(34, 211, 238, 0.1);
}

/* Loading state for images */
img {
    transition: opacity 0.3s ease;
}

img:not([src]) {
    opacity: 0;
}

/* Mobile-specific animations */
@media (max-width: 640px) {
    .animate-bounce {
        animation-duration: 2s;
    }
}

/* Dark mode compatibility */
@media (prefers-color-scheme: dark) {
    .bg-white\/90 {
        background-color: rgba(255, 255, 255, 0.95);
    }
}
</style>
@endpush

@push('scripts')
<script>
// Enhanced error page interactions
document.addEventListener('DOMContentLoaded', function() {
    // Add subtle parallax effect to floating elements
    const floatingElements = document.querySelectorAll('.absolute.animate-bounce');
    
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        floatingElements.forEach((element, index) => {
            const speed = (index + 1) * 0.5;
            const x = (mouseX - 0.5) * speed;
            const y = (mouseY - 0.5) * speed;
            
            element.style.transform = `translate(${x}px, ${y}px)`;
        });
    });
    
    // Add click tracking for analytics (if needed)
    const navigationCards = document.querySelectorAll('a[href]');
    
    navigationCards.forEach(card => {
        card.addEventListener('click', function() {
            // Track 404 navigation attempts
            if (typeof gtag !== 'undefined') {
                gtag('event', '404_navigation', {
                    'event_category': 'Error Pages',
                    'event_label': this.href
                });
            }
        });
    });
    
    // Auto-hide notification after some time (if any)
    setTimeout(() => {
        const notifications = document.querySelectorAll('.alert');
        notifications.forEach(notification => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        });
    }, 5000);
});

// Add some village-themed Easter eggs
let konami = [];
const konamiCode = [
    'ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown',
    'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight',
    'KeyB', 'KeyA'
];

document.addEventListener('keydown', function(e) {
    konami.push(e.code);
    konami = konami.slice(-10);
    
    if (konami.join('') === konamiCode.join('')) {
        // Easter egg: Show village fun fact
        alert('🎉 Fun Fact: Desa Banyukambang memiliki sistem digital yang modern untuk melayani warga dengan lebih baik!');
        konami = [];
    }
});
</script>
@endpush
@endsection
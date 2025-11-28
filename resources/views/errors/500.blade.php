@extends('frontend.layouts.main')

@section('title', 'Server Bermasalah')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50 flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" width=\"32\" height=\"32\" fill=\"none\" stroke=\"%23dc2626\"><path d=\"M0 0.5H32M0 8.5H32M0 16.5H32M0 24.5H32M0.5 0V32M8.5 0V32M16.5 0V32M24.5 0V32\"/></svg>'); background-size: 32px 32px;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Village Logo Animation -->
        <div class="mb-8 relative">
            <div class="inline-flex items-center justify-center w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-orange-500 rounded-full animate-pulse shadow-2xl"></div>
                <div class="relative z-10 w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <img class="w-20 h-20 rounded-full border-2 border-red-500" 
                         src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" 
                         alt="Logo Desa Banyukambang">
                </div>
            </div>
        </div>

        <!-- 500 Number -->
        <div class="mb-8">
            <h1 class="text-9xl sm:text-[12rem] font-extrabold text-transparent bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500 bg-clip-text animate-pulse leading-none tracking-tight">
                500
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-4xl font-bold text-red-800 mb-4">
                🚧 Server Sedang Bermasalah
            </h2>
            <p class="text-lg sm:text-xl text-red-600 mb-6 leading-relaxed max-w-2xl mx-auto">
                Mohon maaf, terjadi kesalahan pada server website 
                <span class="font-semibold text-red-700">Desa Banyukambang</span>. 
                Tim teknis kami sedang bekerja untuk memperbaiki masalah ini.
            </p>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-lg max-w-2xl mx-auto">
                <div class="flex items-center">
                    <div class="text-yellow-600 mr-3">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-yellow-800 font-medium">Silakan coba lagi dalam beberapa menit atau hubungi administrator.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12 max-w-2xl mx-auto">
            <!-- Home Card -->
            <a href="{{ route('home') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-primary-200 hover:border-primary-400">
                <div class="text-primary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🏠
                </div>
                <h3 class="text-xl font-bold text-primary-800 mb-2">Kembali ke Beranda</h3>
                <p class="text-primary-600 text-sm">Coba akses halaman utama yang lebih stabil</p>
            </a>

            <!-- Refresh Card -->
            <button onclick="window.location.reload()" 
                    class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-secondary-200 hover:border-secondary-400 w-full">
                <div class="text-secondary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🔄
                </div>
                <h3 class="text-xl font-bold text-secondary-800 mb-2">Coba Lagi</h3>
                <p class="text-secondary-600 text-sm">Muat ulang halaman ini</p>
            </button>
        </div>

        <!-- Status Information -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-red-200 mb-12">
            <div class="text-5xl mb-4">⚙️</div>
            <h3 class="text-2xl font-bold text-red-800 mb-4">Status Server</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                <div class="bg-red-50 rounded-lg p-4">
                    <div class="text-red-500 text-2xl mb-2">🔴</div>
                    <div class="text-red-700 font-medium">Web Server</div>
                    <div class="text-red-600 text-sm">Sedang Diperbaiki</div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="text-yellow-500 text-2xl mb-2">🟡</div>
                    <div class="text-yellow-700 font-medium">Database</div>
                    <div class="text-yellow-600 text-sm">Monitoring</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-green-500 text-2xl mb-2">🟢</div>
                    <div class="text-green-700 font-medium">Network</div>
                    <div class="text-green-600 text-sm">Berjalan Normal</div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-orange-200">
            <div class="text-5xl mb-4">📞</div>
            <h3 class="text-2xl font-bold text-orange-800 mb-4">Butuh Bantuan Segera?</h3>
            <p class="text-orange-600 mb-6 leading-relaxed">
                Jika masalah berlanjut atau Anda membutuhkan bantuan segera, silakan hubungi tim teknis kami.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <div class="flex items-center text-orange-700">
                    <i class="fas fa-phone mr-3 text-orange-500"></i>
                    <span class="font-medium">Emergency: (0351) XXX-XXXX</span>
                </div>
                <div class="flex items-center text-orange-700">
                    <i class="fas fa-envelope mr-3 text-orange-500"></i>
                    <span class="font-medium">support@desa-banyukambang.id</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-red-300/20 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
    <div class="absolute top-1/4 right-10 w-16 h-16 bg-orange-300/20 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-yellow-300/20 rounded-full animate-bounce" style="animation-delay: 1.5s;"></div>
    <div class="absolute bottom-1/4 right-1/4 w-24 h-24 bg-red-200/20 rounded-full animate-bounce" style="animation-delay: 2s;"></div>

</div>

@push('styles')
<style>
.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}

@keyframes pulse-slow {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

/* Error-specific styling */
.error-gradient {
    background: linear-gradient(135deg, #fee2e2, #fef3c7, #fef3c7);
}
</style>
@endpush

@push('scripts')
<script>
// Auto-refresh after 2 minutes
setTimeout(function() {
    if (confirm('Server mungkin sudah diperbaiki. Ingin mencoba memuat ulang halaman?')) {
        window.location.reload();
    }
}, 120000);

// Track error for analytics
if (typeof gtag !== 'undefined') {
    gtag('event', 'exception', {
        'description': '500_error_page_view',
        'fatal': false
    });
}
</script>
@endpush
@endsection
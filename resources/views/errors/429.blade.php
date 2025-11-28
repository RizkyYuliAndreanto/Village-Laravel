@extends('frontend.layouts.main')

@section('title', 'Terlalu Banyak Permintaan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-pink-50 to-rose-50 flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" width=\"32\" height=\"32\" fill=\"none\" stroke=\"%23dc2626\"><path d=\"M0 0.5H32M0 8.5H32M0 16.5H32M0 24.5H32M0.5 0V32M8.5 0V32M16.5 0V32M24.5 0V32\"/></svg>'); background-size: 32px 32px;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Village Logo with Speed Meter Animation -->
        <div class="mb-8 relative">
            <div class="inline-flex items-center justify-center w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 bg-gradient-to-r from-red-500 to-pink-500 rounded-full animate-pulse shadow-2xl"></div>
                <div class="relative z-10 w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <div class="relative">
                        <img class="w-16 h-16 rounded-full border-2 border-red-500" 
                             src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" 
                             alt="Logo Desa Banyukambang">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white animate-bounce">
                            <i class="fas fa-tachometer-alt text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 429 Number -->
        <div class="mb-8">
            <h1 class="text-9xl sm:text-[12rem] font-extrabold text-transparent bg-gradient-to-r from-red-500 via-pink-500 to-rose-500 bg-clip-text animate-pulse leading-none tracking-tight">
                429
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-4xl font-bold text-red-800 mb-4">
                🚦 Terlalu Banyak Permintaan
            </h2>
            <p class="text-lg sm:text-xl text-red-600 mb-6 leading-relaxed max-w-2xl mx-auto">
                Anda telah melakukan terlalu banyak permintaan ke website <span class="font-semibold text-red-700">Desa Banyukambang</span> 
                dalam waktu yang singkat. Sistem kami membatasi akses untuk menjaga kinerja dan keamanan website.
            </p>
            <div class="bg-red-100 border-l-4 border-red-500 p-4 rounded-lg max-w-2xl mx-auto">
                <div class="flex items-start">
                    <div class="text-red-600 mr-3 mt-0.5">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-red-800 font-medium mb-1">Tunggu sebentar sebelum mencoba lagi:</p>
                        <div id="waitTime" class="text-red-700 text-lg font-bold mb-2">
                            Mohon tunggu <span id="countdown">60</span> detik
                        </div>
                        <p class="text-red-600 text-sm">
                            Sistem akan otomatis mengizinkan akses setelah waktu tunggu berakhir.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rate Limit Info -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-red-200 mb-12">
            <div class="text-5xl mb-4">📊</div>
            <h3 class="text-2xl font-bold text-red-800 mb-6">Batas Kecepatan Akses</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                    <div class="text-red-600 text-3xl mb-3">🔢</div>
                    <h4 class="font-bold text-red-800 mb-2">Batas Normal</h4>
                    <p class="text-red-700 text-sm">60 permintaan per menit untuk penggunaan normal</p>
                </div>
                
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-6 border border-pink-200">
                    <div class="text-pink-600 text-3xl mb-3">⚡</div>
                    <h4 class="font-bold text-pink-800 mb-2">Akses Cepat</h4>
                    <p class="text-pink-700 text-sm">Terdeteksi aktivitas terlalu cepat berturut-turut</p>
                </div>
                
                <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-xl p-6 border border-rose-200">
                    <div class="text-rose-600 text-3xl mb-3">🛡️</div>
                    <h4 class="font-bold text-rose-800 mb-2">Perlindungan</h4>
                    <p class="text-rose-700 text-sm">Melindungi server dari overload</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12 max-w-2xl mx-auto">
            <!-- Wait and Retry -->
            <button id="retryBtn" onclick="attemptRetry()" disabled
                    class="group bg-gray-100 rounded-xl p-6 shadow-xl border border-gray-300 cursor-not-allowed opacity-50 transition-all duration-300 w-full">
                <div class="text-gray-400 mb-4 text-4xl">
                    ⏳
                </div>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Tunggu & Coba Lagi</h3>
                <p class="text-gray-500 text-sm">Akan aktif setelah waktu tunggu berakhir</p>
                <div class="mt-4 inline-flex items-center text-gray-500 font-medium">
                    <span class="mr-2" id="retryText">Mohon Tunggu</span>
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </button>

            <!-- Back to Home -->
            <a href="{{ route('home') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-primary-200 hover:border-primary-400">
                <div class="text-primary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🏠
                </div>
                <h3 class="text-xl font-bold text-primary-800 mb-2">Halaman Utama</h3>
                <p class="text-primary-600 text-sm">Kembali ke beranda dan mulai browsing normal</p>
                <div class="mt-4 inline-flex items-center text-primary-600 font-medium">
                    <span class="mr-2">Ke Beranda</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>
        </div>

        <!-- Usage Guidelines -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-green-200 mb-12">
            <div class="text-5xl mb-4">📋</div>
            <h3 class="text-2xl font-bold text-green-800 mb-6">Panduan Penggunaan yang Baik</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <!-- Do's -->
                <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                    <div class="text-green-600 text-2xl mb-4 flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <h4 class="font-bold text-green-800">Yang Sebaiknya Dilakukan</h4>
                    </div>
                    <ul class="space-y-3 text-left">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-green-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-green-700 text-sm">Tunggu halaman selesai loading sebelum klik lain</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-green-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-green-700 text-sm">Beri jeda 1-2 detik antar navigasi</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-green-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-green-700 text-sm">Gunakan menu navigasi dengan normal</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-check text-green-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-green-700 text-sm">Refresh halaman jika diperlukan</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Don'ts -->
                <div class="bg-red-50 rounded-xl p-6 border border-red-200">
                    <div class="text-red-600 text-2xl mb-4 flex items-center">
                        <i class="fas fa-times-circle mr-3"></i>
                        <h4 class="font-bold text-red-800">Yang Sebaiknya Dihindari</h4>
                    </div>
                    <ul class="space-y-3 text-left">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-times text-red-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-red-700 text-sm">Menekan tombol berulang kali dengan cepat</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-times text-red-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-red-700 text-sm">Refresh halaman berkali-kali dalam waktu singkat</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-times text-red-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-red-700 text-sm">Menggunakan bot atau script otomatis</span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-times text-red-600 text-sm mt-1 flex-shrink-0"></i>
                            <span class="text-red-700 text-sm">Membuka terlalu banyak tab sekaligus</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-xl border border-blue-200">
            <div class="text-4xl mb-3">📞</div>
            <h3 class="text-xl font-bold text-blue-800 mb-4">Butuh Bantuan?</h3>
            <p class="text-blue-600 text-sm mb-4">
                Jika masalah berlanjut atau Anda merasa ini adalah kesalahan sistem, 
                silakan hubungi administrator desa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="tel:+6285123456789" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300">
                    <i class="fas fa-phone mr-2"></i>
                    <span>Telepon: (0351) 123-456</span>
                </a>
                <a href="mailto:admin@banyukambang.desa.id" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-300">
                    <i class="fas fa-envelope mr-2"></i>
                    <span>Email Admin</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Floating Elements with slower animation -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-red-300/20 rounded-full animate-pulse"></div>
    <div class="absolute top-1/4 right-10 w-16 h-16 bg-pink-300/20 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-rose-300/20 rounded-full animate-pulse" style="animation-delay: 2s;"></div>

</div>

@push('scripts')
<script>
// Rate limit countdown
let timeLeft = 60;
let countdownTimer;

function startCountdown() {
    countdownTimer = setInterval(function() {
        timeLeft--;
        
        document.getElementById('countdown').textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(countdownTimer);
            enableRetry();
        }
    }, 1000);
}

function enableRetry() {
    const retryBtn = document.getElementById('retryBtn');
    const retryText = document.getElementById('retryText');
    const waitTimeDiv = document.getElementById('waitTime');
    
    // Update UI
    retryBtn.disabled = false;
    retryBtn.classList.remove('bg-gray-100', 'border-gray-300', 'cursor-not-allowed', 'opacity-50');
    retryBtn.classList.add('bg-white/90', 'border-green-200', 'hover:border-green-400', 'hover:shadow-2xl', 'hover:-translate-y-2', 'cursor-pointer');
    
    retryText.textContent = 'Coba Lagi Sekarang';
    waitTimeDiv.innerHTML = '<span class="text-green-600 font-bold">✅ Anda dapat mencoba lagi sekarang</span>';
    
    // Update icon
    retryBtn.querySelector('.text-gray-400').className = 'text-green-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300';
    retryBtn.querySelector('.text-gray-400').textContent = '🔄';
}

function attemptRetry() {
    if (timeLeft <= 0) {
        // Try to go back to previous page or reload
        if (document.referrer && document.referrer !== window.location.href) {
            window.location.href = document.referrer;
        } else {
            window.location.reload();
        }
    }
}

// Start countdown immediately
startCountdown();

// Track rate limit for analytics
if (typeof gtag !== 'undefined') {
    gtag('event', 'rate_limit_exceeded', {
        'event_category': 'Security',
        'event_label': 'Too_many_requests',
        'custom_map': {'rate_limit_duration': 60}
    });
}

// Show notification after countdown
setTimeout(function() {
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification('Website Desa Banyukambang', {
            body: 'Anda sudah dapat mengakses website lagi.',
            icon: '{{ asset("images/Logo_kabupaten_madiun.gif") }}'
        });
    }
}, 60000);
</script>
@endpush
@endsection
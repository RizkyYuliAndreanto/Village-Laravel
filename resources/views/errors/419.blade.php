@extends('frontend.layouts.main')

@section('title', 'Sesi Telah Berakhir')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" width=\"32\" height=\"32\" fill=\"none\" stroke=\"%23f59e0b\"><path d=\"M0 0.5H32M0 8.5H32M0 16.5H32M0 24.5H32M0.5 0V32M8.5 0V32M16.5 0V32M24.5 0V32\"/></svg>'); background-size: 32px 32px;"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Village Logo with Clock Animation -->
        <div class="mb-8 relative">
            <div class="inline-flex items-center justify-center w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full animate-pulse shadow-2xl"></div>
                <div class="relative z-10 w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <div class="relative">
                        <img class="w-16 h-16 rounded-full border-2 border-amber-500" 
                             src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" 
                             alt="Logo Desa Banyukambang">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white animate-spin" style="animation-duration: 2s;">
                            <i class="fas fa-clock text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 419 Number -->
        <div class="mb-8">
            <h1 class="text-9xl sm:text-[12rem] font-extrabold text-transparent bg-gradient-to-r from-amber-500 via-yellow-500 to-orange-500 bg-clip-text animate-pulse leading-none tracking-tight">
                419
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-4xl font-bold text-amber-800 mb-4">
                ⏰ Sesi Telah Berakhir
            </h2>
            <p class="text-lg sm:text-xl text-amber-600 mb-6 leading-relaxed max-w-2xl mx-auto">
                Sesi Anda di website <span class="font-semibold text-amber-700">Desa Banyukambang</span> telah berakhir 
                untuk menjaga keamanan data. Ini terjadi setelah tidak ada aktivitas dalam waktu tertentu 
                atau saat token keamanan sudah tidak valid.
            </p>
            <div class="bg-amber-100 border-l-4 border-amber-500 p-4 rounded-lg max-w-2xl mx-auto">
                <div class="flex items-start">
                    <div class="text-amber-600 mr-3 mt-0.5">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-amber-800 font-medium mb-1">Langkah yang perlu dilakukan:</p>
                        <ul class="text-amber-700 text-sm space-y-1 list-disc list-inside">
                            <li>Muat ulang halaman ini</li>
                            <li>Isi ulang form dengan data yang sama</li>
                            <li>Pastikan koneksi internet stabil</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12 max-w-2xl mx-auto">
            <!-- Refresh Card -->
            <button onclick="window.location.reload()" 
                    class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-amber-200 hover:border-amber-400 w-full">
                <div class="text-amber-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🔄
                </div>
                <h3 class="text-xl font-bold text-amber-800 mb-2">Muat Ulang</h3>
                <p class="text-amber-600 text-sm">Refresh halaman untuk memulai sesi baru</p>
                <div class="mt-4 inline-flex items-center text-amber-600 font-medium">
                    <span class="mr-2">Refresh Sekarang</span>
                    <i class="fas fa-sync-alt group-hover:rotate-180 transition-transform duration-300"></i>
                </div>
            </button>

            <!-- Back to Home -->
            <a href="{{ route('home') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-primary-200 hover:border-primary-400">
                <div class="text-primary-500 mb-4 text-4xl group-hover:scale-110 transition-transform duration-300">
                    🏠
                </div>
                <h3 class="text-xl font-bold text-primary-800 mb-2">Halaman Utama</h3>
                <p class="text-primary-600 text-sm">Kembali ke beranda dengan sesi baru</p>
                <div class="mt-4 inline-flex items-center text-primary-600 font-medium">
                    <span class="mr-2">Ke Beranda</span>
                    <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                </div>
            </a>
        </div>

        <!-- Security Information -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-yellow-200 mb-12">
            <div class="text-5xl mb-4">🛡️</div>
            <h3 class="text-2xl font-bold text-yellow-800 mb-6">Mengapa Sesi Berakhir?</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border border-yellow-200">
                    <div class="text-yellow-600 text-3xl mb-3">⏰</div>
                    <h4 class="font-bold text-yellow-800 mb-2">Timeout Otomatis</h4>
                    <p class="text-yellow-700 text-sm">Tidak ada aktivitas dalam 30 menit terakhir</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
                    <div class="text-orange-600 text-3xl mb-3">🔐</div>
                    <h4 class="font-bold text-orange-800 mb-2">Keamanan Data</h4>
                    <p class="text-orange-700 text-sm">Melindungi informasi sensitif desa</p>
                </div>
                
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                    <div class="text-amber-600 text-3xl mb-3">🔑</div>
                    <h4 class="font-bold text-amber-800 mb-2">Token Expired</h4>
                    <p class="text-amber-700 text-sm">Token keamanan perlu diperbaharui</p>
                </div>
            </div>
        </div>

        <!-- Help Tips -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-green-200">
            <div class="text-5xl mb-4">💡</div>
            <h3 class="text-2xl font-bold text-green-800 mb-4">Tips untuk Menghindari Timeout</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                        <i class="fas fa-check text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <h5 class="font-medium text-green-800 mb-1">Aktif Berkala</h5>
                        <p class="text-green-600 text-sm">Lakukan aktivitas setiap 15-20 menit</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                        <i class="fas fa-save text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <h5 class="font-medium text-green-800 mb-1">Simpan Progres</h5>
                        <p class="text-green-600 text-sm">Simpan data secara berkala saat mengisi form</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                        <i class="fas fa-wifi text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <h5 class="font-medium text-green-800 mb-1">Koneksi Stabil</h5>
                        <p class="text-green-600 text-sm">Pastikan internet tidak terputus</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                        <i class="fas fa-window-restore text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <h5 class="font-medium text-green-800 mb-1">Satu Tab</h5>
                        <p class="text-green-600 text-sm">Gunakan hanya satu tab untuk website desa</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Auto-refresh countdown -->
    <div id="autoRefresh" class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg p-4 border border-amber-200 hidden">
        <div class="flex items-center space-x-3">
            <div class="text-amber-500">
                <i class="fas fa-clock text-lg"></i>
            </div>
            <div>
                <div class="font-medium text-gray-800 text-sm">Auto refresh dalam</div>
                <div id="countdown" class="text-amber-600 font-bold text-lg">30</div>
            </div>
            <button onclick="cancelAutoRefresh()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-amber-300/20 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
    <div class="absolute top-1/4 right-10 w-16 h-16 bg-yellow-300/20 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-orange-300/20 rounded-full animate-bounce" style="animation-delay: 1.5s;"></div>

</div>

@push('scripts')
<script>
// Auto refresh functionality
let autoRefreshTimer;
let countdownTimer;
let timeLeft = 30;

function startAutoRefresh() {
    document.getElementById('autoRefresh').classList.remove('hidden');
    
    countdownTimer = setInterval(function() {
        timeLeft--;
        document.getElementById('countdown').textContent = timeLeft;
        
        if (timeLeft <= 0) {
            window.location.reload();
        }
    }, 1000);
}

function cancelAutoRefresh() {
    clearInterval(countdownTimer);
    document.getElementById('autoRefresh').classList.add('hidden');
}

// Start auto refresh after 5 seconds
setTimeout(startAutoRefresh, 5000);

// Track session expiry for analytics
if (typeof gtag !== 'undefined') {
    gtag('event', 'session_expired', {
        'event_category': 'Security',
        'event_label': 'CSRF_token_expired'
    });
}

// Preserve form data if available
if (localStorage.getItem('formData')) {
    console.log('Form data tersimpan di localStorage, akan dipulihkan setelah refresh');
}
</script>
@endpush
@endsection
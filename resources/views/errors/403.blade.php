@extends('frontend.layouts.main')

@section('title', 'Akses Ditolak')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 flex items-center justify-center relative overflow-hidden">
    
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 32 32\" width=\"32\" height=\"32\" fill=\"none\" stroke=\"%237c3aed\"><path d=\"M0 0.5H32M0 8.5H32M0 16.5H32M0 24.5H32M0.5 0V32M8.5 0V32M16.5 0V32M24.5 0V32\"/></svg>')></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        
        <!-- Village Logo with Lock Animation -->
        <div class="mb-8 relative">
            <div class="inline-flex items-center justify-center w-32 h-32 mx-auto mb-6">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full animate-pulse shadow-2xl"></div>
                <div class="relative z-10 w-28 h-28 bg-white rounded-full flex items-center justify-center shadow-xl">
                    <div class="relative">
                        <img class="w-16 h-16 rounded-full border-2 border-purple-500" 
                             src="{{ asset('images/Logo_kabupaten_madiun.gif') }}" 
                             alt="Logo Desa Banyukambang">
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 403 Number -->
        <div class="mb-8">
            <h1 class="text-9xl sm:text-[12rem] font-extrabold text-transparent bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-500 bg-clip-text animate-pulse leading-none tracking-tight">
                403
            </h1>
        </div>

        <!-- Error Message -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-4xl font-bold text-purple-800 mb-4">
                🚫 Akses Ditolak
            </h2>
            <p class="text-lg sm:text-xl text-purple-600 mb-6 leading-relaxed max-w-2xl mx-auto">
                Mohon maaf, Anda tidak memiliki izin untuk mengakses halaman ini di website 
                <span class="font-semibold text-purple-700">Desa Banyukambang</span>. 
                Halaman ini mungkin memerlukan otorisasi khusus atau terbatas untuk pengguna tertentu.
            </p>
            <div class="bg-purple-100 border-l-4 border-purple-500 p-4 rounded-lg max-w-2xl mx-auto">
                <div class="flex items-center">
                    <div class="text-purple-600 mr-3">
                        <i class="fas fa-shield-alt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-purple-800 font-medium">Halaman ini dilindungi untuk menjaga keamanan data desa.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Information -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-purple-200 mb-12">
            <div class="text-5xl mb-4">🔐</div>
            <h3 class="text-2xl font-bold text-purple-800 mb-6">Jenis Akses Terbatas</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                    <div class="text-purple-500 text-3xl mb-3">👨‍💼</div>
                    <h4 class="font-bold text-purple-800 mb-2">Admin Desa</h4>
                    <p class="text-purple-600 text-sm">Panel administrasi untuk pengelola website</p>
                </div>
                
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-indigo-500 text-3xl mb-3">📊</div>
                    <h4 class="font-bold text-indigo-800 mb-2">Data Internal</h4>
                    <p class="text-indigo-600 text-sm">Informasi yang hanya untuk pihak berwenang</p>
                </div>
                
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-6 border border-pink-200">
                    <div class="text-pink-500 text-3xl mb-3">🛡️</div>
                    <h4 class="font-bold text-pink-800 mb-2">Keamanan</h4>
                    <p class="text-pink-600 text-sm">Area yang dilindungi sistem keamanan</p>
                </div>
            </div>
        </div>

        <!-- Navigation Options -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <!-- Home Card -->
            <a href="{{ route('home') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-primary-200 hover:border-primary-400">
                <div class="text-primary-500 mb-4 text-3xl group-hover:scale-110 transition-transform duration-300">
                    🏠
                </div>
                <h3 class="text-lg font-bold text-primary-800 mb-2">Halaman Utama</h3>
                <p class="text-primary-600 text-sm">Kembali ke beranda yang aman</p>
            </a>

            <!-- Login Card -->
            <a href="{{ route('login') }}" 
               class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-purple-200 hover:border-purple-400">
                <div class="text-purple-500 mb-4 text-3xl group-hover:scale-110 transition-transform duration-300">
                    🔑
                </div>
                <h3 class="text-lg font-bold text-purple-800 mb-2">Login</h3>
                <p class="text-purple-600 text-sm">Masuk dengan akun yang berwenang</p>
            </a>

            <!-- Contact Card -->
            <button onclick="showContactModal()" 
                    class="group bg-white/90 backdrop-blur-sm rounded-xl p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 border border-indigo-200 hover:border-indigo-400 w-full">
                <div class="text-indigo-500 mb-4 text-3xl group-hover:scale-110 transition-transform duration-300">
                    📞
                </div>
                <h3 class="text-lg font-bold text-indigo-800 mb-2">Minta Akses</h3>
                <p class="text-indigo-600 text-sm">Hubungi administrator</p>
            </button>
        </div>

        <!-- Public Services -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-xl border border-green-200">
            <div class="text-5xl mb-4">🌟</div>
            <h3 class="text-2xl font-bold text-green-800 mb-4">Layanan Publik yang Tersedia</h3>
            <p class="text-green-600 mb-6 leading-relaxed">
                Nikmati berbagai informasi dan layanan publik yang dapat diakses secara bebas.
            </p>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <a href="{{ route('profil-desa.index') }}" class="flex flex-col items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300">
                    <i class="fas fa-info-circle text-green-500 text-2xl mb-2"></i>
                    <span class="text-green-800 text-sm font-medium">Profil Desa</span>
                </a>
                
                <a href="{{ route('infografis.index') }}" class="flex flex-col items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-300">
                    <i class="fas fa-chart-bar text-blue-500 text-2xl mb-2"></i>
                    <span class="text-blue-800 text-sm font-medium">Infografis</span>
                </a>
                
                <a href="{{ route('umkm.index') }}" class="flex flex-col items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-300">
                    <i class="fas fa-store text-yellow-500 text-2xl mb-2"></i>
                    <span class="text-yellow-800 text-sm font-medium">UMKM</span>
                </a>
                
                <a href="{{ route('berita.index') }}" class="flex flex-col items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-300">
                    <i class="fas fa-newspaper text-red-500 text-2xl mb-2"></i>
                    <span class="text-red-800 text-sm font-medium">Berita</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-xl max-w-md w-full p-8 relative">
            <button onclick="hideContactModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <div class="text-center mb-6">
                <div class="text-4xl mb-4">📞</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Hubungi Administrator</h3>
                <p class="text-gray-600">Untuk mendapatkan akses ke halaman ini</p>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-phone text-primary-500 mr-3"></i>
                    <div>
                        <div class="font-medium text-gray-800">Kantor Desa</div>
                        <div class="text-gray-600">(0351) XXX-XXXX</div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-envelope text-secondary-500 mr-3"></i>
                    <div>
                        <div class="font-medium text-gray-800">Email Admin</div>
                        <div class="text-gray-600">admin@desa-banyukambang.id</div>
                    </div>
                </div>
                
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <i class="fas fa-clock text-cyan-500 mr-3"></i>
                    <div>
                        <div class="font-medium text-gray-800">Jam Kerja</div>
                        <div class="text-gray-600">Senin - Jumat, 08:00 - 16:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-purple-300/20 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
    <div class="absolute top-1/4 right-10 w-16 h-16 bg-pink-300/20 rounded-full animate-bounce" style="animation-delay: 1s;"></div>
    <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-indigo-300/20 rounded-full animate-bounce" style="animation-delay: 1.5s;"></div>

</div>

@push('scripts')
<script>
function showContactModal() {
    document.getElementById('contactModal').classList.remove('hidden');
}

function hideContactModal() {
    document.getElementById('contactModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('contactModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideContactModal();
    }
});

// Track access attempt for analytics
if (typeof gtag !== 'undefined') {
    gtag('event', 'exception', {
        'description': '403_access_denied',
        'fatal': false
    });
}

// Modal functions
function showContactModal() {
    document.getElementById('contactModal').style.display = 'flex';
}

function hideContactModal() {
    document.getElementById('contactModal').style.display = 'none';
}
</script>
@endpush
@endsection
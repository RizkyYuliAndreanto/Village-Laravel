<footer class="relative navbar-bg backdrop-blur-lg text-white overflow-hidden border-t border-white/20">
    <!-- Pastikan FontAwesome ter-load -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- CSS untuk memastikan visibility -->
    <style>
        footer {
            font-family: system-ui, -apple-system, sans-serif !important;
        }
        .footer-icon {
            display: inline-block;
            width: 16px;
            text-align: center;
            margin-right: 8px;
            font-weight: bold;
        }
        .footer-link {
            color: rgba(255,255,255,0.8) !important;
            transition: color 0.2s ease;
        }
        .footer-link:hover {
            color: white !important;
        }
    </style>
    
    <div class="absolute inset-0 bg-white/5"></div>

    <div class="relative container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Logo & Deskripsi --}}
            <div class="lg:col-span-2">
                <div class="flex items-start gap-4 mb-4">
                    <div class="relative">
                        <img class="h-12 w-12 rounded-lg shadow-lg border-2 navbar-logo-border"
                            src="{{ asset('images/Logo_kabupaten_madiun.gif') }}"
                            alt="Logo Desa Banyukambang">
                        <div class="absolute inset-0 rounded-lg bg-white/10"></div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold navbar-text mb-1">Desa Banyukambang</h3>
                        <p class="navbar-text-secondary text-sm font-medium">Kec. Wonoasri, Kab. Madiun</p>
                    </div>
                </div>

                <p class="navbar-text-secondary text-sm leading-relaxed max-w-md mb-4">
                    Portal digital terpadu untuk layanan masyarakat, informasi desa, dan pengembangan UMKM lokal.
                </p>

                <div class="flex space-x-3">
                    <a href="#" class="bg-white/20 hover:bg-white/30 p-2 px-3 rounded-full transition-all duration-300 hover:scale-110 group text-white font-medium text-sm">
                        📘 FB
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 p-2 px-3 rounded-full transition-all duration-300 hover:scale-110 group text-white font-medium text-sm">
                        📷 IG
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 p-2 px-3 rounded-full transition-all duration-300 hover:scale-110 group text-white font-medium text-sm">
                        📺 YT
                    </a>
                </div>
            </div>

            {{-- Tautan Cepat --}}
            <div>
                <h3 class="text-base font-bold navbar-text mb-4 flex items-center">
                    <i class="fas fa-link mr-2 navbar-text-secondary text-sm"></i>
                    Tautan Cepat
                </h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">🏠</span>Beranda</a></li>
                    <li><a href="{{ route('profil-desa.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">ℹ️</span>Profil Desa</a></li>
                    <li><a href="{{ route('infografis.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">📊</span>Infografis</a></li>
                    <li><a href="{{ route('umkm.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">🏪</span>UMKM</a></li>
                </ul>
            </div>

            {{-- Layanan --}}
            <div>
                <h3 class="text-base font-bold navbar-text mb-4 flex items-center">
                    <i class="fas fa-cogs mr-2 navbar-text-secondary text-sm"></i>
                    Layanan
                </h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('belanja.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">💰</span>APBDes</a></li>
                    <li><a href="{{ route('berita.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">📰</span>Berita</a></li>
                    <li><a href="{{ route('ppid.index') }}" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">📁</span>PPID</a></li>
                    <li><a href="/admin" class="footer-link hover:text-white flex items-center text-sm group">
                        <span class="footer-icon">🔐</span>Login Admin</a></li>
                </ul>
            </div>
        </div>

        {{-- Kontak --}}
        <div class="mt-8 pt-6 border-t border-white/20">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-full text-center">
                        <span class="text-white text-lg">📍</span>
                    </div>
                    <div>
                        <p class="text-white/70 text-xs">Alamat</p>
                        <p class="text-white font-medium text-sm">Desa Banyukambang, Wonoasri</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-full text-center">
                        <span class="text-white text-lg">📞</span>
                    </div>
                    <div>
                        <p class="text-white/70 text-xs">Telepon</p>
                        <p class="text-white font-medium text-sm">+62 xxx xxxx xxxx</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-2 rounded-full text-center">
                        <span class="text-white text-lg">📧</span>
                    </div>
                    <div>
                        <p class="text-white/70 text-xs">Email</p>
                        <p class="text-white font-medium text-sm">Desabanyukambang@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-6 pt-4 border-t border-white/20 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                <p class="text-white/80 text-xs">
                    &copy; {{ date('Y') }} <strong class="text-white">Desa Banyukambang</strong>. Hak cipta dilindungi.
                </p>
                <p class="text-white/70 text-xs">
                    💻 Dikembangkan dengan ❤️
                </p>
            </div>
        </div>
    </div>
</footer>

<footer class="relative navbar-bg backdrop-blur-lg text-white overflow-hidden border-t border-white/20">
    <div class="absolute inset-0 bg-black/10"></div>

    <div class="relative container mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        {{-- Main Footer Content --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Branding --}}
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-3">
                    <img class="h-10 w-10 rounded-lg shadow-lg border-2 navbar-logo-border"
                         src="{{ asset('images/Logo_kabupaten_madiun.gif') }}"
                         alt="Logo Desa Banyukambang">
                    <div>
                        <h3 class="text-lg font-semibold navbar-text">Desa Banyukambang</h3>
                        <p class="text-sm navbar-text-secondary">Kec. Wonoasri, Kab. Madiun</p>
                    </div>
                </div>
                
                <p class="text-sm navbar-text-secondary mb-4 max-w-md leading-relaxed">
                    Portal digital untuk layanan masyarakat dan pengembangan UMKM lokal.
                </p>
                
                {{-- Social Media --}}
                <div class="flex gap-2">
                    <a href="#" class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded-lg transition-all navbar-text text-sm font-medium">
                        Facebook
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded-lg transition-all navbar-text text-sm font-medium">
                        Instagram  
                    </a>
                    <a href="#" class="bg-white/20 hover:bg-white/30 px-3 py-2 rounded-lg transition-all navbar-text text-sm font-medium">
                        YouTube
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="navbar-text font-semibold mb-3">Menu</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('profil-desa.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">Profil Desa</a></li>
                    <li><a href="{{ route('infografis.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">Infografis</a></li>
                    <li><a href="{{ route('umkm.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">UMKM</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="navbar-text font-semibold mb-3">Layanan</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('belanja.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">APBDes</a></li>
                    <li><a href="{{ route('berita.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">Berita</a></li>
                    <li><a href="{{ route('ppid.index') }}" class="navbar-text-secondary text-sm hover:text-white transition-colors">PPID</a></li>
                    <li><a href="/admin" class="navbar-text-secondary text-sm hover:text-white transition-colors">Login Admin</a></li>
                </ul>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="border-t border-white/20 pt-6 mt-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="navbar-text-secondary">📍</span>
                    <span class="navbar-text-secondary">Desa Banyukambang, Wonoasri</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="navbar-text-secondary">📞</span>
                    <span class="navbar-text-secondary">+62 xxx xxxx xxxx</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="navbar-text-secondary">📧</span>
                    <span class="navbar-text-secondary">Desabanyukambang@gmail.com</span>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-white/20 pt-4 mt-4 text-center">
            <p class="text-sm navbar-text-secondary">
                &copy; {{ date('Y') }} <span class="navbar-text font-semibold">Desa Banyukambang</span>. Hak cipta dilindungi.
            </p>
        </div>
        
    </div>
</footer>

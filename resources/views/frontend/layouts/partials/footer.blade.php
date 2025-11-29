<footer class="relative bg-gradient-to-r from-blue-800 via-blue-700 to-blue-800 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600/10 to-secondary-600/10">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent"></div>
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-blue-300 to-blue-400"></div>
    </div>

    <div class="relative container mx-auto py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Logo & Deskripsi --}}
            <div class="lg:col-span-2">
                <div class="flex items-start gap-6 mb-6">
                    <div class="relative">
                        <img class="h-16 w-16 rounded-xl shadow-lg border-2 border-blue-300/30"
                            src="{{ asset('images/Kabupaten_Madiun.png') }}"
                            alt="Logo Desa Ngengor">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-br from-blue-400/20 to-transparent"></div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-2">Desa Ngengor</h3>
                        <p class="text-blue-200 font-medium">Kec. Pilangkenceng, Kab. Madiun</p>
                    </div>
                </div>
                <p class="text-blue-100 text-base leading-relaxed max-w-md">
                    Portal digital terpadu untuk layanan masyarakat, informasi desa, dan pengembangan UMKM lokal.
                    Membangun transparansi dan aksesibilitas dalam pemerintahan desa.
                </p>
                <!-- <div class="flex space-x-4 mt-6">
                    <a href="#" class="bg-blue-600/50 hover:bg-blue-500 p-3 rounded-full transition-all duration-300 hover:scale-110 group">
                        <i class="fab fa-facebook-f text-white group-hover:rotate-12 transition-transform duration-300"></i>
                    </a>
                    <a href="#" class="bg-blue-600/50 hover:bg-blue-500 p-3 rounded-full transition-all duration-300 hover:scale-110 group">
                        <i class="fab fa-instagram text-white group-hover:rotate-12 transition-transform duration-300"></i>
                    </a>
                    <a href="#" class="bg-blue-600/50 hover:bg-blue-500 p-3 rounded-full transition-all duration-300 hover:scale-110 group">
                        <i class="fab fa-youtube text-white group-hover:rotate-12 transition-transform duration-300"></i>
                    </a>
                </div> -->
            </div>

            {{-- Tautan Cepat --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-link mr-2 text-blue-300"></i>
                    Tautan Cepat
                </h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-home w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>Beranda</a></li>
                    <li><a href="{{ route('profil-desa.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-info-circle w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>Profil Desa</a></li>
                    <li><a href="{{ route('infografis.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-chart-bar w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>Infografis</a></li>
                    <li><a href="{{ route('umkm.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-store w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>UMKM</a></li>
                </ul>
            </div>

            {{-- Layanan --}}
            <div>
                <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs mr-2 text-blue-300"></i>
                    Layanan
                </h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('belanja.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-coins w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>APBDes</a></li>
                    <li><a href="{{ route('berita.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-newspaper w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>Berita</a></li>
                    <li><a href="{{ route('ppid.index') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-folder-open w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>PPID</a></li>
                    <li><a href="/admin" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center group">
                            <i class="fas fa-user-shield w-4 mr-2 group-hover:translate-x-1 transition-transform duration-200"></i>Login Admin</a></li>
                </ul>
            </div>
        </div>

        {{-- Kontak Info --}}
        <div class="mt-auto pt-16 border-t border-blue-600/30">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!--Map-->
                <a href="https://maps.app.goo.gl/1Qu78cr4bZr6RKpz5" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="flex items-center space-x-3 group hover:bg-white/5 p-2 -ml-2 rounded-xl transition-all duration-300">
                    <div class="bg-blue-600/50 group-hover:bg-blue-500 p-3 rounded-full transition-colors duration-300">
                        <i class="fas fa-map-marker-alt text-blue-200 group-hover:text-white"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-sm group-hover:text-blue-100">Alamat</p>
                        <p class="text-white font-medium text-sm leading-snug group-hover:text-blue-50">
                            Ngengor, Kec. Pilangkenceng,<br>
                            Kab. Madiun, Jawa Timur
                        </p>
                    </div>
                </a>
                <!--Telpon-->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600/50 p-3 rounded-full">
                        <i class="fas fa-phone text-blue-200"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-sm">Telepon</p>
                        <p class="text-white font-medium">+62 xxx xxxx xxxx</p>
                    </div>
                </div>
                <!--Email-->
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600/50 p-3 rounded-full">
                        <i class="fas fa-envelope text-blue-200"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-sm">Email</p>
                        <p class="text-white font-medium">info@desabanyukambang.id</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-12 pt-8 border-t border-blue-600/30 text-center">
            <div class="flex flex-col md:flex-row justify-center items-center space-y-4 md:space-y-0">
                <p class="text-blue-200 text-sm text-center">
                    &copy; {{ date('Y') }} <strong class="text-white">Desa Ngengor</strong>. Hak cipta dilindungi undang-undang.
                </p>
            </div>
        </div>
    </div>
</footer>
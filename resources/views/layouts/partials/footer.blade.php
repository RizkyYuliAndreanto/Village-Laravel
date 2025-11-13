<footer class="bg-blue-100 dark:bg-blue-950 text-gray-800 dark:text-gray-200 border-t border-blue-200 dark:border-blue-800 shadow-inner">
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">

            {{-- Logo & Deskripsi --}}
            <div class="md:col-span-1 lg:col-span-2 flex items-start gap-4">
                <img class="h-30 w-auto rounded-md shadow-sm"
                    src="{{ asset('images/logo-placeholder.jpg') }}"
                    alt="Logo {{ config('app.name', 'VillageLaravel') }}">
                <p class="text-gray-700 dark:text-gray-300 text-md max-w-md leading-relaxed">
                    Sistem Informasi Manajemen Desa <strong>(VillageLaravel)</strong> hadir untuk membantu digitalisasi
                    dan mempermudah pengelolaan data administrasi di tingkat desa.
                </p>
            </div>

            {{-- Tautan Cepat --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    Tautan Cepat
                </h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('home') }}" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a></li>
                    <li><a href="#" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Tentang Kami</a></li>
                    <li><a href="#" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Layanan</a></li>
                    <li><a href="#" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Kontak</a></li>
                </ul>
            </div>

            {{-- Lainnya --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                    Lainnya
                </h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('login') }}" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Login Aparat</a></li>
                    <li><a href="#" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-base text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Login/Register --}}
            <div class="hidden sm:flex sm:flex-col sm:gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition p-5">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition p-5"> Register</a>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Copyright --}}
        <div class="mt-12 border-t border-blue-200 dark:border-blue-800 pt-6 text-center">
            <p class="text-gray-700 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} <strong>{{ config('app.name', 'VillageLaravel') }}</strong>. Semua hak dilindungi.
            </p>
        </div>
    </div>
</footer>

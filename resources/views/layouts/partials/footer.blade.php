<footer class="bg-gray-800 text-gray-300 dark:bg-gray-900 shadow-inner mt-16">
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">

            <div class="md:col-span-1 lg:col-span-2 space-y-4 flex items-start gap-4">
                <img class="h-10vh w-auto"
                    src="{{ asset('images/logo-placeholder.jpg') }}"
                    alt="Logo {{ config('app.name', 'Laravel') }}">

                <p class="text-gray-400 text-md max-w-md">
                    Sistem Informasi Manajemen Desa (VillageLaravel) hadir untuk membantu digitalisasi dan mempermudah pengelolaan data administrasi di tingkat desa.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-200 uppercase tracking-wider">Tautan Cepat</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-base text-gray-400 hover:text-white transition">Home</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-400 hover:text-white transition">Tentang Kami</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-400 hover:text-white transition">Layanan</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-400 hover:text-white transition">Kontak</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-200 uppercase tracking-wider">Lainnya</h3>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="{{ route('login') }}" class="text-base text-gray-400 hover:text-white transition">Login Aparat</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-400 hover:text-white transition">Kebijakan Privasi</a>
                    </li>
                    <li>
                        <a href="#" class="text-base text-gray-400 hover:text-white transition">Syarat & Ketentuan</a>
                    </li>
                </ul>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-400 underline">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-400 underline">Log in</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-400 underline">Register</a>
                @endif
                @endauth
            </div>
        </div>

        <div class="mt-12 border-t border-gray-700 pt-8 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'VillageLaravel') }}. All rights reserved.
            </p>
        </div>
    </div>
</footer>
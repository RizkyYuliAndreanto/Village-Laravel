<nav class="bg-blue-50 dark:bg-blue-950 text-gray-800 dark:text-gray-200 shadow-md w-full py-6">
    <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between">

        <div class="flex flex-col text-left mb-6 lg:mb-0">
            <span class="text-3xl lg:text-4xl font-extrabold text-gray-800 dark:text-gray-100 leading-tight">
                INFOGRAFIS
            </span>
            <span class="text-3xl lg:text-4xl font-extrabold text-gray-800 dark:text-gray-100 leading-tight">
                DESA NGENGOR
            </span>
        </div>

        <div class="flex flex-wrap justify-center items-center space-x-10 border-b border-gray-300 pb-3">

            {{-- =======================
                PENDUDUK / DEMOGRAFI
            ======================== --}}
            <a href="{{ route('infografis.index') }}"
               class="flex flex-col items-center font-semibold relative group
               {{ request()->routeIs('infografis.*') ? 'text-gray-900 dark:text-white' 
                                                     : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
               
                {{-- ICON USERS --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
                </svg>

                <span>Penduduk</span>
                <span class="absolute bottom-[-6px] w-full h-0.5 transition 
                    {{ request()->routeIs('infografis.*') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
            </a>


            {{-- =======================
                UMKM
            ======================== --}}
            <a href="{{ route('umkm.index') }}"
                class="flex flex-col items-center font-semibold relative group
                {{ request()->routeIs('umkm.*') ? 'text-gray-900 dark:text-white' 
                                                : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">

                {{-- ICON STORE/BUSINESS --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9l1-3h16l1 3M4 9h16v10a2 2 0 01-2 2H6a2 2 0 01-2-2V9z" />
                </svg>

                <span>UMKM</span>
                <span class="absolute bottom-[-6px] w-full h-0.5 transition 
                    {{ request()->routeIs('umkm.*') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
            </a>


            {{-- =======================
                APBDES
            ======================== --}}
            <a href="{{ route('frontend.apbdes.index') }}"
                class="flex flex-col items-center font-semibold relative group
                {{ request()->routeIs('frontend.apbdes.*') ? 'text-gray-900 dark:text-white' 
                                                          : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">

                {{-- ICON BAR CHART --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 19h16M8 17V9m4 8V5m4 12v-6" />
                </svg>

                <span>APBDes</span>
                <span class="absolute bottom-[-6px] w-full h-0.5 transition 
                    {{ request()->routeIs('frontend.apbdes.*') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
            </a>


            {{-- =======================
                BERITA
            ======================== --}}
            <a href="{{ route('berita.index') }}"
                class="flex flex-col items-center font-semibold relative group
                {{ request()->routeIs('berita.*') ? 'text-gray-900 dark:text-white' 
                                                  : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">

                {{-- ICON NEWSPAPER --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5h18v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 8h6M7 12h10M7 16h10" />
                </svg>

                <span>Berita</span>
                <span class="absolute bottom-[-6px] w-full h-0.5 transition 
                    {{ request()->routeIs('berita.*') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
            </a>


            {{-- =======================
                PPID
            ======================== --}}
            <a href="{{ route('ppid.index') }}"
                class="flex flex-col items-center font-semibold relative group
                {{ request()->routeIs('ppid.*') ? 'text-gray-900 dark:text-white' 
                                                : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">

                {{-- ICON DOCUMENT --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 9h6M9 13h6" />
                </svg>

                <span>PPID</span>
                <span class="absolute bottom-[-6px] w-full h-0.5 transition 
                    {{ request()->routeIs('ppid.*') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
            </a>

        </div>
    </div>
</nav>

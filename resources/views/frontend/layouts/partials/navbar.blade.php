<nav x-data="{ isOpen: false }" class="bg-blue-100 dark:bg-blue-950 text-gray-800 dark:text-gray-200 shadow-md fixed w-full z-50 transition-colors duration-300">
  <div class="container mx-auto px-6">
    <div class="flex justify-between items-center h-16">
      
      <div class="flex items-center space-x-4">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
          <img
            class="h-10 w-10 md:h-12 md:w-12 rounded-full shadow-md transition-transform duration-200 group-hover:scale-105"
            src="{{ asset('images/logo-placeholder.jpg') }}"
            alt="Logo Desa">

          <div class="flex flex-col leading-tight">
            <span class="text-lg md:text-xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-blue-600 transition">
              Desa Ngengor
            </span>
            <span class="text-xs md:text-sm text-gray-600 dark:text-gray-400">
              Kabupaten Madiun
            </span>
          </div>
        </a>
      </div>

      <div class="flex items-center">
        
        <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
          <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
              Home
          </x-nav-link>
          <x-nav-link :href="route('Profil-desa.index')" :active="request()->routeIs('Profil-desa.index')">
              Profil Desa
          </x-nav-link>
          <x-nav-link :href="route('demografi.index')" :active="request()->routeIs('demografi.index')">
              Infografis
          </x-nav-link>
          <x-nav-link href="#">
              APBDes
          </x-nav-link>
          <x-nav-link :href="route('umkm.index')" :active="request()->routeIs('umkm.*')">
              UMKM
          </x-nav-link>
          <x-nav-link :href="route('berita.index')" :active="request()->routeIs('berita.*')">
              Berita
          </x-nav-link>
          <x-nav-link :href="route('ppid.index')" :active="request()->routeIs('ppid.*')">
              PPID
          </x-nav-link>
        </div>

        <div class="ml-4 hidden md:block">
            @auth
                <a href="{{ url('/admin') }}" class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition font-semibold">
                    Dashboard
                </a>
            @else
                <a href="{{ url('/admin') }}" class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition font-semibold">
                    Login Admin
                </a>
            @endauth
        </div>
        <div class="flex items-center md:hidden ml-4">
          <button @click="isOpen = !isOpen" type="button" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 focus:outline-none p-2">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path x-show="!isOpen" fill-rule="evenodd" d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"/>
              <path x-show="isOpen" fill-rule="evenodd" d="M18.36 6.64L16.95 5.23 12 10.18 7.05 5.23 5.64 6.64 10.59 11.59 5.64 16.54 7.05 17.95 12 13l4.95 4.95 1.41-1.41L13.41 11.59l4.95-4.95z"/>
            </svg>
          </button>
        </div>

      </div>

    </div>
  </div>

  <div x-show="isOpen" 
       x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0 -translate-y-2"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-2"
       class="md:hidden bg-blue-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
    
    <div class="flex flex-col px-4 pt-2 pb-4 space-y-1">
      <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
        Home
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('Profil-desa.index')" :active="request()->routeIs('Profil-desa.index')">
        Profil Desa
      </x-responsive-nav-link>
      <x-responsive-nav-link href="#">
        Infografis
      </x-responsive-nav-link>
      <x-responsive-nav-link href="#">
        APBDes
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('umkm.index')" :active="request()->routeIs('umkm.*')">
        UMKM
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('berita.index')" :active="request()->routeIs('berita.*')">
        Berita
      </x-responsive-nav-link>
      <x-responsive-nav-link :href="route('ppid.index')" :active="request()->routeIs('ppid.*')">
        PPID
      </x-responsive-nav-link>

      <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
        @auth
            <a href="{{ url('/admin') }}" class="block px-3 py-2 text-base font-medium bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition text-center">
                Dashboard
            </a>
        @else
            <a href="{{ url('/admin') }}" class="block px-3 py-2 text-base font-medium bg-green-600 text-white rounded-md hover:bg-green-700 transition text-center">
                Login Admin
            </a>
        @endauth
      </div>
    </div>
  </div>
</nav>
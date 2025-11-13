<nav class="bg-blue-50 dark:bg-blue-950 text-gray-800 dark:text-gray-200 shadow-md w-full py-6">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between">

    <!-- Kiri: Judul -->
    <div class="flex flex-col text-left mb-6 lg:mb-0">
      <span class="text-3xl lg:text-4xl font-extrabold text-gray-800 dark:text-gray-100 leading-tight">
        INFOGRAFIS
      </span>
      <span class="text-3xl lg:text-4xl font-extrabold text-gray-800 dark:text-gray-100 leading-tight">
        DESA NGENGOR
      </span>
    </div>

    <!-- Kanan: Tab Menu -->
    <div class="flex flex-wrap justify-center items-center space-x-10 border-b border-gray-300 pb-3">

      <!-- Penduduk -->
      <a href="{{ route('Infografis.index') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('Infografis.index') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a4 4 0 100-8 4 4 0 000 8z" />
        </svg>
        <span>Penduduk</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('Infografis.index') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

      <!-- APBDes -->
      <a href="{{ route('Infografis.apbdes') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('Infografis.apbdes') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8c-1.1 0-2 .9-2 2v4c0 1.1.9 2 2 2s2-.9 2-2v-4c0-1.1-.9-2-2-2z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 20h14v-2H5v2zM12 4v2m0 4v8" />
        </svg>
        <span>APBDes</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('Infografis.apbdes') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

      <!-- Stunting -->
      <a href="{{ route('Infografis.stunting') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('Infografis.stunting') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
        </svg>
        <span>Stunting</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('Infografis.stunting') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

      <!-- Bansos -->
      <a href="{{ route('Infografis.bansos') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('Infografis.bansos') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6M3 20h18" />
        </svg>
        <span>Bansos</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('Infografis.bansos') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

      <!-- IDM -->
      <a href="{{ route('IDM') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('IDM') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8l6 4-6 4-6-4 6-4z" />
        </svg>
        <span>IDM</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('IDM') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

      <!-- SDGs -->
      <a href="{{ route('Infografis.sdg') }}"
        class="flex flex-col items-center font-semibold relative group 
               {{ request()->routeIs('Infografis.sdg') ? 'text-gray-100' : 'text-gray-500 hover:text-gray-800 dark:hover:text-gray-300' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-1" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 2a10 10 0 100 20 10 10 0 000-20zM2 12h20M12 2c2 2.5 4 6 4 10s-2 7.5-4 10M12 2c-2 2.5-4 6-4 10s2 7.5 4 10" />
        </svg>
        <span>SDGs</span>
        <span
          class="absolute bottom-[-6px] w-full h-0.5 transition {{ request()->routeIs('Infografis.sdg') ? 'bg-red-600' : 'bg-transparent group-hover:bg-red-500' }}"></span>
      </a>

    </div>
  </div>
</nav>

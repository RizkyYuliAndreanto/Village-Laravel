<nav class="bg-blue-100 dark:bg-blue-950 text-gray-800 dark:text-gray-200 shadow-md fixed w-full">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-4">
  <!-- Logo -->
  <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
    <img
      class="h-12 w-12 rounded-full shadow-md transition-transform duration-200 group-hover:scale-105"
      src="{{ asset('images/logo-placeholder.jpg') }}"
      alt="Logo {{ config('app.name', 'Laravel') }}"
    >

    <!-- Teks -->
    <div class="flex flex-col leading-tight">
      <span class="text-xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-blue-600 transition">
        Desa Ngengor
      </span>
      <span class="text-sm text-gray-600 dark:text-gray-400">
        Kabupaten Madiun
      </span>
    </div>
  </a>
</div>


            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Home</a>
                <a href="{{ route('profil_desa') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Profil Desa</a>
                <a href="{{ route('Infografis.index') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Infografis</a>
                <a href="{{ route('Listing') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Listing</a>
                <a href="{{ route('IDM') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">IDM</a>
                <a href="{{ route('Berita') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Berita</a>
                <a href="{{ route('Belanja') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">Belanja</a>
                <a href="{{ route('PPID') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 font-medium transition">PPID</a>
            </div>
        </div>
    </div>
</nav>

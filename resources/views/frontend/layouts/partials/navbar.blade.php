<nav class="fixed top-0 left-0 right-0 z-50 py-2 bg-black/40 backdrop-blur-lg border-b border-white/10">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-3">

      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-3 no-underline">
        <img
          class="h-12 w-12"
          src="{{ asset('images/Kabupaten_Madiun.png') }}"
          alt="Logo {{ config('app.name', 'Laravel') }}"
        />
        <div class="leading-tight text-white">
          <div class="font-bold text-lg">Desa Ngengor</div>
          <div class="text-sm opacity-80">Kabupaten Madiun</div>
        </div>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden lg:flex items-center space-x-4">

        <a href="{{ route('home') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('home') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          Home
        </a>

        <a href="{{ route('profil-desa.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('profil-desa.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          Profil Desa
        </a>

        <a href="{{ route('infografis.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('infografis.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          Infografis
        </a>

        <a href="{{ route('umkm.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('umkm.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          UMKM
        </a>

        <a href="{{ route('belanja.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('belanja.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          APBDES
        </a>

        <a href="{{ route('berita.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('berita.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          Berita
        </a>

        <a href="{{ route('ppid.index') }}"
           class="px-4 py-2 rounded-lg text-white transition
                  {{ request()->routeIs('ppid.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
          PPID
        </a>

      </div>

      <!-- Mobile Menu Toggle -->
      <button id="mobile-menu-toggle" class="lg:hidden p-2">
        <div class="w-6 h-[2px] bg-white mb-1"></div>
        <div class="w-6 h-[2px] bg-white mb-1"></div>
        <div class="w-6 h-[2px] bg-white"></div>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden mt-2 bg-black/50 backdrop-blur-lg rounded-lg p-4 space-y-2">

      <a href="{{ route('home') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('home') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        Home
      </a>

      <a href="{{ route('profil-desa.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('profil-desa.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        Profil Desa
      </a>

      <a href="{{ route('infografis.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('infografis.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        Infografis
      </a>

      <a href="{{ route('umkm.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('umkm.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        UMKM
      </a>

      <a href="{{ route('belanja.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('belanja.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        APBDES
      </a>

      <a href="{{ route('berita.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('berita.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        Berita
      </a>

      <a href="{{ route('ppid.index') }}"
         class="block px-4 py-2 rounded-lg text-white
                {{ request()->routeIs('ppid.*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/10' }}">
        PPID
      </a>

    </div>
  </div>
</nav>

<script>
document.getElementById('mobile-menu-toggle').addEventListener('click', () => {
  document.getElementById('mobile-menu').classList.toggle('hidden');
});
</script>

<nav class="fixed top-0 left-0 right-0 z-50 navbar-bg backdrop-blur-lg shadow-lg border-b border-white/20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-2">
      
      <!-- Logo Section -->
      <div class="flex items-center">
        <a href="{{ route('home') }}" class="flex items-center navbar-text no-underline hover:scale-105 transition-transform duration-300">
          <div class="relative mr-3">
            <img
              class="h-12 w-12 rounded-full border-2 border-white/50 shadow-lg hover:shadow-xl transition-shadow duration-300"
              src="{{ asset('images/Logo_kabupaten_madiun.gif') }}"
              alt="Logo {{ config('app.name', 'Laravel') }}"
            />
          </div>
          <div>
            <span class="text-lg font-bold navbar-text drop-shadow-sm">
              Desa Banyukambang
            </span>
            <br>
            <span class="text-sm navbar-text-secondary drop-shadow-sm">
              Kabupaten Madiun
            </span>
          </div>
        </a>
      </div>

      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-2">
        <a href="{{ route('home') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('home') ? 'navbar-active shadow-lg' : '' }}">
          <i class="fas fa-home mr-2"></i>Home
        </a>
        
        <a href="{{ route('profil-desa.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('profil-desa.*') ? 'navbar-active shadow-lg' : '' }}">
          <i class="fas fa-info-circle mr-2"></i>Profil Desa
        </a>
        
        <a href="{{ route('infografis.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('infografis.*') ? 'navbar-active shadow-lg' : '' }}">
          <i class="fas fa-chart-bar mr-2"></i>Infografis
        </a>
        
        <a href="{{ route('umkm.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('umkm.*') ? 'navbar-active shadow-lg' : '' }}">
          <i class="fas fa-store mr-2"></i>UMKM
        </a>
        
        <a href="{{ route('belanja.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('belanja.*') ? 'navbar-active shadow-lg' : '' }}">
          <i class="fas fa-coins mr-2"></i>APBDES
        </a>
        
        <a href="{{ route('berita.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5 {{ request()->routeIs('berita.*') ? 'bg-white/25 shadow-lg' : '' }}">
          <i class="fas fa-newspaper mr-2"></i>Berita
        </a>
        
        <a href="{{ route('ppid.index') }}" 
           class="flex items-center px-4 py-2 rounded-full navbar-text font-medium transition-all duration-300 navbar-hover hover:-translate-y-0.5  {{ request()->routeIs('ppid.*') ? 'bg-white/25 shadow-lg' : '' }}">
          <i class="fas fa-folder-open mr-2"></i>PPID
        </a>
      </div>

      <!-- Mobile menu button -->
      <button id="mobile-menu-toggle" class="lg:hidden p-2 rounded-lg bg-white/30 hover:bg-white/40 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-white/50" aria-label="Toggle mobile menu">
        <div class="w-6 h-0.5 bg-white rounded-full transition-all duration-300 hamburger-line-1"></div>
        <div class="w-6 h-0.5 bg-white rounded-full mt-1.5 transition-all duration-300 hamburger-line-2"></div>
        <div class="w-6 h-0.5 bg-white rounded-full mt-1.5 transition-all duration-300 hamburger-line-3"></div>
      </button>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="lg:hidden hidden">
      <div class="bg-cyan-400/95 backdrop-blur-lg rounded-lg mt-2 p-4 shadow-xl">
        <div class="space-y-2">
          <a href="{{ route('home') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('home') ? 'bg-white/40' : '' }}">
            <i class="fas fa-home mr-3 w-4"></i>Home
          </a>
          
          <a href="{{ route('profil-desa.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('profil-desa.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-info-circle mr-3 w-4"></i>Profil Desa
          </a>
          
          <a href="{{ route('infografis.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('infografis.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-chart-bar mr-3 w-4"></i>Infografis
          </a>
          
          <a href="{{ route('umkm.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('umkm.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-store mr-3 w-4"></i>UMKM
          </a>
          
          <a href="{{ route('belanja.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('belanja.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-coins mr-3 w-4"></i>APBDES
          </a>
          
          <a href="{{ route('berita.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('berita.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-newspaper mr-3 w-4"></i>Berita
          </a>
          
          <a href="{{ route('ppid.index') }}" 
             class="flex items-center px-4 py-3 rounded-lg text-white font-medium transition-all duration-300 hover:bg-white/30 hover:translate-x-2 {{ request()->routeIs('ppid.*') ? 'bg-white/40' : '' }}">
            <i class="fas fa-folder-open mr-3 w-4"></i>PPID
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const hamburgerLine1 = document.querySelector('.hamburger-line-1');
  const hamburgerLine2 = document.querySelector('.hamburger-line-2');
  const hamburgerLine3 = document.querySelector('.hamburger-line-3');

  if (!mobileMenuToggle || !mobileMenu) {
    console.error('Mobile menu elements not found');
    return;
  }

  mobileMenuToggle.addEventListener('click', function() {
    if (mobileMenu.classList.contains('hidden')) {
      // Show menu
      mobileMenu.classList.remove('hidden');
      
      // Transform to X
      if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
        hamburgerLine1.style.transform = 'rotate(45deg) translate(6px, 6px)';
        hamburgerLine2.style.opacity = '0';
        hamburgerLine3.style.transform = 'rotate(-45deg) translate(6px, -6px)';
      }
    } else {
      // Hide menu
      mobileMenu.classList.add('hidden');
      
      // Transform back to hamburger
      if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
        hamburgerLine1.style.transform = 'none';
        hamburgerLine2.style.opacity = '1';
        hamburgerLine3.style.transform = 'none';
      }
    }
  });

  // Close mobile menu when clicking outside
  document.addEventListener('click', function(event) {
    if (!mobileMenuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
      mobileMenu.classList.add('hidden');
      
      // Reset hamburger icon
      if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
        hamburgerLine1.style.transform = 'none';
        hamburgerLine2.style.opacity = '1';
        hamburgerLine3.style.transform = 'none';
      }
    }
  });

  // Close mobile menu when clicking on links
  mobileMenu.addEventListener('click', function(event) {
    if (event.target.tagName === 'A') {
      mobileMenu.classList.add('hidden');
      
      // Reset hamburger icon
      if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
        hamburgerLine1.style.transform = 'none';
        hamburgerLine2.style.opacity = '1';
        hamburgerLine3.style.transform = 'none';
      }
    }
  });

  // Handle window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) { // lg breakpoint
      mobileMenu.classList.add('hidden');
      
      // Reset hamburger icon
      if (hamburgerLine1 && hamburgerLine2 && hamburgerLine3) {
        hamburgerLine1.style.transform = 'none';
        hamburgerLine2.style.opacity = '1';
        hamburgerLine3.style.transform = 'none';
      }
    }
  });
});
</script>


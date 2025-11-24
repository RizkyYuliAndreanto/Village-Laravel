{{-- Section: Hero --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%201.jpg') }}'); opacity: 1;"
             data-bg="{{ asset('images/hero section 1.jpg') }}">
        </div>
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%202.jpg') }}'); opacity: 0;"
             data-bg="{{ asset('images/hero section 2.jpg') }}">
        </div>
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%203.jpg') }}'); opacity: 0;"
             data-bg="{{ asset('images/hero section 3.jpg') }}">
        </div>
        <div class="absolute inset-0 bg-black/40 z-10"></div>
    </div>

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse delay-700"></div>
        <div class="absolute -bottom-20 left-1/3 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <div class="relative z-10 container mx-auto px-6 text-center py-20 pt-24">
        <div class="inline-flex items-center bg-white/25 backdrop-blur-md rounded-full px-4 py-2 mb-8 border border-white/40 shadow-lg animate-fadeInDown">
            <i class="fas fa-map-marker-alt text-white mr-2 shadow-text"></i>
            <span class="text-white font-medium shadow-text">Kecamatan Pilangkenceng, Kabupaten Madiun</span>
        </div>
        
        <div class="mb-6">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight shadow-text-strong animate-fadeInUp">
                Selamat Datang di
            </h1>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight bg-gradient-to-r from-sky-400 via-cyan-300 to-white bg-clip-text text-transparent gradient-text-bright animate-fadeInUp delay-200">
                Desa Ngengor
            </h1>
        </div>

        <p class="text-xl md:text-2xl text-white mb-4 font-light max-w-3xl mx-auto leading-relaxed shadow-text animate-fadeInUp delay-300">
            Portal Informasi dan Layanan Digital untuk Masyarakat
        </p>
        <p class="text-white/90 mb-10 text-lg max-w-2xl mx-auto shadow-text animate-fadeInUp delay-400">
            Temukan informasi lengkap tentang profil desa, data demografis, UMKM lokal, dan berbagai layanan publik dalam satu platform terpadu.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fadeInUp delay-500">
            <a href="{{ route('infografis.index') }}" class="btn-primary group shadow-lg hover:shadow-cyan-500/50 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                Lihat Infografis
            </a>
            <a href="{{ route('profil-desa.index') }}" class="btn-secondary group shadow-lg hover:shadow-white/30 transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                Profil Desa
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 max-w-4xl mx-auto animate-fadeInUp delay-700">
            <div class="stat-card group">
                <div class="text-2xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">
                    {{ isset($totalPenduduk) ? number_format($totalPenduduk) : '5,420' }}+
                </div>
                <div class="text-white/80 text-sm shadow-text-light">Penduduk</div>
            </div>
            
            <div class="stat-card group">
                <div class="text-2xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">
                    {{ isset($potensiDesa) ? $potensiDesa->count() : '15' }}+
                </div>
                <div class="text-white/80 text-sm shadow-text-light">UMKM Aktif</div>
            </div>

            <div class="stat-card group">
                <div class="text-2xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">8</div>
                <div class="text-white/80 text-sm shadow-text-light">Dusun</div>
            </div>

            <div class="stat-card group">
                <div class="text-2xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">100%</div>
                <div class="text-white/80 text-sm shadow-text-light">Digital</div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white/60 text-xl shadow-text"></i>
    </div>

    <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <button class="slide-indicator w-3 h-3 rounded-full bg-white transition-all duration-300 active" onclick="manualSlide(0)"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" onclick="manualSlide(1)"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" onclick="manualSlide(2)"></button>
    </div>
</section>

<style>
    /* Utility Classes untuk Shadow & Text Effects */
    .shadow-text { text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6); }
    .shadow-text-strong { text-shadow: 3px 3px 6px rgba(0,0,0,0.9), 1px 1px 3px rgba(0,0,0,0.7); }
    .shadow-text-light { text-shadow: 1px 1px 2px rgba(0,0,0,0.7); }
    
    .gradient-text-bright {
        filter: drop-shadow(0 0 12px rgba(56, 189, 248, 0.6));
    }

    .stat-card {
        @apply bg-white/15 backdrop-blur-md rounded-lg p-4 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg cursor-default transform hover:-translate-y-1;
    }

    .slide-indicator.active {
        @apply bg-white scale-125 shadow-[0_0_10px_rgba(255,255,255,0.8)];
    }

    /* Simple Fade In Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-700 { animation-delay: 0.7s; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.slide-indicator');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            // Reset opacity
            slides.forEach(s => s.style.opacity = '0');
            indicators.forEach(i => i.classList.remove('active', 'bg-white', 'scale-125'));
            
            // Activate current
            slides[index].style.opacity = '1';
            indicators[index].classList.add('active', 'bg-white', 'scale-125');
            indicators[index].classList.remove('bg-white/50');
            
            // Reset others to dimmer state
            indicators.forEach((ind, i) => {
                if(i !== index) ind.classList.add('bg-white/50');
            });
            
            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        // Global function for onclick events
        window.manualSlide = function(index) {
            clearInterval(slideInterval);
            showSlide(index);
            startSlideshow(); // Restart timer
        }

        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Init
        if(slides.length > 0) {
            showSlide(0);
            startSlideshow();
        }
    });
</script>
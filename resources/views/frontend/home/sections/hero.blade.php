{{-- Section: Hero --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Slider --}}
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
        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/60 z-10"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 container mx-auto px-6 text-center py-20 pt-24">
        {{-- Lokasi Badge --}}
        <div class="inline-flex items-center bg-white/20 backdrop-blur-md rounded-full px-5 py-2 mb-8 border border-white/30 shadow-lg animate-fadeInDown hover:bg-white/30 transition-all">
            <i class="fas fa-map-marker-alt text-cyan-300 mr-2 shadow-text"></i>
            <span class="text-white font-medium shadow-text tracking-wide text-sm md:text-base">Kecamatan Pilangkenceng, Kabupaten Madiun</span>
        </div>
        
        {{-- Main Title --}}
        <div class="mb-6 space-y-2">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight shadow-text-strong animate-fadeInUp">
                Selamat Datang di
            </h1>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight bg-gradient-to-r from-cyan-400 via-white to-cyan-400 bg-clip-text text-transparent gradient-text-bright animate-fadeInUp delay-200">
                Desa Ngengor
            </h1>
        </div>

        {{-- Subtitle --}}
        <p class="text-xl md:text-2xl text-white mb-4 font-light max-w-3xl mx-auto leading-relaxed shadow-text animate-fadeInUp delay-300">
            Portal Informasi dan Layanan Digital untuk Masyarakat
        </p>
        <p class="text-gray-200 mb-10 text-base md:text-lg max-w-2xl mx-auto shadow-text animate-fadeInUp delay-400">
            Temukan informasi lengkap tentang profil desa, data demografis, UMKM lokal, dan berbagai layanan publik dalam satu platform terpadu.
        </p>

        {{-- Action Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fadeInUp delay-500 mb-16">
            <a href="{{ route('infografis.index') }}" class="btn-primary group shadow-lg shadow-cyan-500/30 hover:shadow-cyan-500/50 transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto">
                <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                Lihat Infografis
            </a>
            <a href="{{ route('profil-desa.index') }}" class="btn-secondary group shadow-lg hover:shadow-white/30 transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto">
                <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                Profil Desa
            </a>
        </div>

        {{-- Statistics Cards (Dynamic Data) --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-5xl mx-auto animate-fadeInUp delay-700">
            {{-- Card 1: Penduduk --}}
            <div class="stat-card group">
                <div class="text-3xl md:text-4xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">
                    {{ number_format($totalPenduduk ?? 0) }}
                </div>
                <div class="text-cyan-100 text-sm font-medium shadow-text-light uppercase tracking-wider">Penduduk</div>
            </div>
            
            {{-- Card 2: UMKM --}}
            <div class="stat-card group">
                <div class="text-3xl md:text-4xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">
                    {{ number_format($jumlahUmkm ?? 0) }}
                </div>
                <div class="text-cyan-100 text-sm font-medium shadow-text-light uppercase tracking-wider">UMKM Aktif</div>
            </div>

            {{-- Card 3: Dusun --}}
            <div class="stat-card group">
                <div class="text-3xl md:text-4xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">
                    {{ $jumlahDusun ?? 0 }}
                </div>
                <div class="text-cyan-100 text-sm font-medium shadow-text-light uppercase tracking-wider">Dusun</div>
            </div>

            {{-- Card 4: Status Digital --}}
            <div class="stat-card group">
                <div class="text-3xl md:text-4xl font-bold text-white mb-1 shadow-text group-hover:text-cyan-300 transition-colors">100%</div>
                <div class="text-cyan-100 text-sm font-medium shadow-text-light uppercase tracking-wider">Digital</div>
            </div>
        </div>
    </div>

    {{-- Scroll Down Indicator --}}
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce hidden md:block">
        <i class="fas fa-chevron-down text-white/60 text-xl shadow-text"></i>
    </div>
    
    {{-- Slide Indicators --}}
    <div class="absolute bottom-20 md:bottom-10 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
        <button class="slide-indicator w-3 h-3 rounded-full bg-white transition-all duration-300 active" onclick="manualSlide(0)" aria-label="Slide 1"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" onclick="manualSlide(1)" aria-label="Slide 2"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" onclick="manualSlide(2)" aria-label="Slide 3"></button>
    </div>
</section>

<style>
    /* Custom Styling */
    .shadow-text { text-shadow: 2px 2px 4px rgba(0,0,0,0.8); }
    .shadow-text-strong { text-shadow: 4px 4px 8px rgba(0,0,0,0.9); }
    .shadow-text-light { text-shadow: 1px 1px 2px rgba(0,0,0,0.8); }
    
    .gradient-text-bright {
        filter: drop-shadow(0 0 10px rgba(34, 211, 238, 0.5));
    }

    .stat-card {
        @apply bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300 cursor-default transform hover:-translate-y-1 hover:border-cyan-400/50;
    }

    .slide-indicator.active {
        @apply bg-cyan-400 scale-125 shadow-[0_0_10px_rgba(34,211,238,0.8)];
    }

    /* Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeInDown { animation: fadeInDown 0.8s ease-out forwards; opacity: 0; }

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
            slides.forEach(s => s.style.opacity = '0');
            indicators.forEach(i => {
                i.classList.remove('active');
                i.classList.add('bg-white/50');
            });
            
            slides[index].style.opacity = '1';
            indicators[index].classList.add('active');
            indicators[index].classList.remove('bg-white/50');
            
            currentSlide = index;
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % slides.length);
        }

        window.manualSlide = function(index) {
            clearInterval(slideInterval);
            showSlide(index);
            startSlideshow();
        }

        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        if(slides.length > 0) {
            showSlide(0);
            startSlideshow();
        }
    });
</script>
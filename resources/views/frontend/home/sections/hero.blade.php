{{-- Section: Hero --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Slideshow -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Photo 1: Kantor Desa Exterior -->
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%201.jpg') }}'); opacity: 1;"
             data-bg="{{ asset('images/hero section 1.jpg') }}">
        </div>
        <!-- Photo 2: Kantor Pelayanan Interior -->
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%202.jpg') }}'); opacity: 0;"
             data-bg="{{ asset('images/hero section 2.jpg') }}">
        </div>
        <!-- Photo 3: Kantor Desa Exterior 2 -->
        <div class="hero-slide absolute inset-0 bg-cover bg-center bg-no-repeat transition-opacity duration-1000" 
             style="background-image: url('{{ asset('images/hero%20section%203.jpg') }}'); opacity: 0;"
             data-bg="{{ asset('images/hero section 3.jpg') }}">
        </div>
        <!-- Dark overlay for text readability -->
        <div class="absolute inset-0 bg-black/40 z-10"></div>
    </div>

    <!-- Animated Background Elements (subtle) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-10 -left-10 w-72 h-72 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse delay-700"></div>
        <div class="absolute -bottom-20 left-1/3 w-80 h-80 bg-white/5 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-6 text-center py-20 pt-24">
        <!-- Badge -->
        <div class="inline-flex items-center bg-white/25 backdrop-blur-md rounded-full px-4 py-2 mb-8 border border-white/40 shadow-lg">
            <i class="fas fa-map-marker-alt text-white mr-2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);"></i>
            <span class="text-white font-medium" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Kecamatan Wonoasri, Kabupaten Madiun</span>
        </div>
        
        <!-- Judul -->
        <div class="mb-6">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.9), 1px 1px 3px rgba(0,0,0,0.7);">
                Selamat Datang di
            </h1>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-tight bg-gradient-to-r from-sky-400 via-cyan-300 to-white bg-clip-text text-transparent gradient-text-bright">
                Desa Banyukambang
            </h1>
        </div>

        <!-- Deskripsi -->
        <p class="text-xl md:text-2xl text-white mb-4 font-light max-w-3xl mx-auto leading-relaxed" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">
            Portal Informasi dan Layanan Digital untuk Masyarakat Desa
        </p>
        <p class="text-white/90 mb-10 text-lg max-w-2xl mx-auto" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">
            Temukan informasi lengkap tentang profil desa, data demografis, UMKM lokal, dan berbagai layanan publik dalam satu platform terpadu.
        </p>

        <!-- Tombol CTA -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('infografis.index') }}" class="btn-primary group" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
                Lihat Infografis
            </a>
            <a href="{{ route('profil-desa.index') }}" class="btn-secondary group" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
                Profil Desa
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 max-w-4xl mx-auto">
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="text-2xl font-bold text-white mb-1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">9,200+</div>
                <div class="text-white/80 text-sm" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Penduduk</div>
            </div>
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="text-2xl font-bold text-white mb-1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">15+</div>
                <div class="text-white/80 text-sm" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">UMKM Aktif</div>
            </div>
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="text-2xl font-bold text-white mb-1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">8</div>
                <div class="text-white/80 text-sm" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Dusun</div>
            </div>
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="text-2xl font-bold text-white mb-1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">100%</div>
                <div class="text-white/80 text-sm" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Digital</div>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <i class="fas fa-chevron-down text-white/60 text-xl" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);"></i>
    </div>

    <!-- Slideshow indicators -->
    <div class="absolute bottom-20 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300 active" data-slide="0"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" data-slide="1"></button>
        <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white/80 transition-all duration-300" data-slide="2"></button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Hero slideshow initializing...');
    
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.slide-indicator');
    let currentSlide = 0;
    let slideInterval;
    
    console.log('Found slides:', slides.length);
    console.log('Found indicators:', indicators.length);

    // Function to show specific slide
    function showSlide(index) {
        console.log('Showing slide:', index);
        
        // Hide all slides
        slides.forEach((slide, i) => {
            slide.style.opacity = '0';
        });
        
        // Remove active state from all indicators
        indicators.forEach(indicator => {
            indicator.classList.remove('active', 'bg-white');
            indicator.classList.add('bg-white/50');
        });
        
        // Show current slide
        slides[index].style.opacity = '1';
        
        // Activate current indicator
        indicators[index].classList.remove('bg-white/50');
        indicators[index].classList.add('active', 'bg-white');
        
        currentSlide = index;
    }

    // Function to go to next slide
    function nextSlide() {
        const next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    // Auto slideshow - change every 5 seconds
    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Stop slideshow
    function stopSlideshow() {
        clearInterval(slideInterval);
    }

    // Add click event to indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            showSlide(index);
            stopSlideshow();
            startSlideshow(); // Restart auto slideshow
        });
    });

    // Pause on hover
    const heroSection = document.querySelector('section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopSlideshow);
        heroSection.addEventListener('mouseleave', startSlideshow);
    }

    // Preload images
    const imageUrls = [
        '{{ asset('images/hero section 1.jpg') }}',
        '{{ asset('images/hero section 2.jpg') }}', 
        '{{ asset('images/hero section 3.jpg') }}'
    ];
    
    let imagesLoaded = 0;
    imageUrls.forEach(url => {
        const img = new Image();
        img.onload = () => {
            imagesLoaded++;
            console.log(`Image loaded: ${url} (${imagesLoaded}/${imageUrls.length})`);
            if (imagesLoaded === imageUrls.length) {
                console.log('All images loaded, starting slideshow');
                initSlideshow();
            }
        };
        img.onerror = () => {
            console.error(`Failed to load image: ${url}`);
            imagesLoaded++;
            if (imagesLoaded === imageUrls.length) {
                initSlideshow();
            }
        };
        img.src = url;
    });
    
    function initSlideshow() {
        if (slides.length > 0 && indicators.length > 0) {
            showSlide(0);
            setTimeout(() => {
                startSlideshow();
                console.log('Slideshow started');
            }, 500);
        } else {
            console.error('Slides or indicators not found');
        }
    }
});
</script>

<style>
.slide-indicator.active {
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    transform: scale(1.2);
}

.slide-indicator {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.hero-slide {
    background-attachment: scroll;
}

/* Additional text shadow utilities for hero section */
.hero-text-shadow {
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);
}

.hero-text-shadow-strong {
    text-shadow: 3px 3px 6px rgba(0,0,0,0.9), 1px 1px 3px rgba(0,0,0,0.7);
}

.hero-text-shadow-light {
    text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
}

/* Bright gradient text styling */
.gradient-text-bright {
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    /* Cyan/blue glow effect matching the gradient colors */
    filter: drop-shadow(0 0 12px rgba(56, 189, 248, 0.6)) drop-shadow(2px 2px 4px rgba(103, 232, 249, 0.4)) drop-shadow(1px 1px 2px rgba(14, 165, 233, 0.5));
    /* Backup text color if gradient fails */
    color: #38bdf8;
    /* Ensure text is readable on all backgrounds */
    position: relative;
}

/* Add a subtle cyan background behind gradient text for better contrast */
.gradient-text-bright::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(56, 189, 248, 0.08);
    border-radius: 12px;
    z-index: -1;
    filter: blur(25px);
}

/* Alternative bright gradient combinations */
.bg-gradient-bright {
    background: linear-gradient(135deg, #38bdf8, #bfdbfe, #ffffff, #f0f9ff);
}
</style>
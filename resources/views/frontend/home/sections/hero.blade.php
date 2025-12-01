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
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white leading-tight px-2" style="text-shadow: 3px 3px 6px rgba(0,0,0,0.9), 1px 1px 3px rgba(0,0,0,0.7);">
                Selamat Datang di
            </h1>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-extrabold leading-tight bg-gradient-to-r from-sky-400 via-cyan-300 to-white bg-clip-text text-transparent gradient-text-bright px-2">
                Desa Banyukambang
            </h1>
        </div>

        <!-- Deskripsi -->
        <p class="text-lg sm:text-xl md:text-2xl text-white mb-4 font-light max-w-3xl mx-auto leading-relaxed px-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">
            Portal Informasi dan Layanan Digital untuk Masyarakat Desa
        </p>
        <p class="text-white/90 mb-8 sm:mb-10 text-base sm:text-lg max-w-2xl mx-auto px-4" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 1px 1px 2px rgba(0,0,0,0.6);">
            Temukan informasi lengkap tentang profil desa, data demografis, UMKM lokal, dan berbagai layanan publik dalam satu platform terpadu.
        </p>

        <!-- Tombol CTA -->
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center px-4">
            <a href="{{ route('infografis.index') }}" 
               class="inline-block group text-center px-6 py-3 font-semibold rounded-lg transition-all duration-300 text-white" 
               style="background: linear-gradient(135deg, #14b8a6, #0891b2); text-shadow: 1px 1px 2px rgba(0,0,0,0.5); width: 100%; max-width: 200px;"
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 20px rgba(20, 184, 166, 0.3)'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
                Lihat Infografis
            </a>
            <a href="{{ route('profil-desa.index') }}" 
               class="inline-block group text-center px-6 py-3 font-semibold rounded-lg transition-all duration-300" 
               style="background: transparent; color: #0891b2; border: 2px solid #67e8f9; text-shadow: 1px 1px 2px rgba(0,0,0,0.5); width: 100%; max-width: 200px;"
               onmouseover="this.style.background='#14b8a6'; this.style.color='white'; this.style.borderColor='#14b8a6'"
               onmouseout="this.style.background='transparent'; this.style.color='#0891b2'; this.style.borderColor='#67e8f9'">
                <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);"></i>
                Profil Desa
            </a>
        </div>

        <!-- Village Highlights (Narrative Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mt-12 sm:mt-16 max-w-4xl mx-auto px-4">
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 sm:p-6 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-leaf text-green-300 text-xl mr-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);"></i>
                    <h3 class="text-white font-semibold text-sm sm:text-base" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Desa Agraris</h3>
                </div>
                <p class="text-white/90 text-xs sm:text-sm leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
                    Mayoritas penduduk bermata pencaharian sebagai petani dengan lahan pertanian yang subur dan produktif.
                </p>
            </div>
            
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 sm:p-6 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-store text-blue-300 text-xl mr-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);"></i>
                    <h3 class="text-white font-semibold text-sm sm:text-base" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">UMKM Berkembang</h3>
                </div>
                <p class="text-white/90 text-xs sm:text-sm leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
                    Usaha mikro dan kecil berkembang pesat, didukung oleh produk lokal berkualitas dan inovasi warga.
                </p>
            </div>
            
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 sm:p-6 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-hands-helping text-yellow-300 text-xl mr-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);"></i>
                    <h3 class="text-white font-semibold text-sm sm:text-base" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Gotong Royong</h3>
                </div>
                <p class="text-white/90 text-xs sm:text-sm leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
                    Tradisi gotong royong masih terjaga kuat dalam setiap kegiatan pembangunan dan kemasyarakatan.
                </p>
            </div>
            
            <div class="bg-white/15 backdrop-blur-md rounded-lg p-4 sm:p-6 border border-white/30 hover:bg-white/25 transition-all duration-300 shadow-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-graduation-cap text-purple-300 text-xl mr-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);"></i>
                    <h3 class="text-white font-semibold text-sm sm:text-base" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Pendidikan Maju</h3>
                </div>
                <p class="text-white/90 text-xs sm:text-sm leading-relaxed" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.6);">
                    Fasilitas pendidikan lengkap dengan tenaga pengajar berkualitas mendukung generasi muda yang cerdas.
                </p>
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
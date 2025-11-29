{{-- Section: Hero --}}
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    {{-- Background Slider --}}
    <div class="absolute inset-0 overflow-hidden">
        @foreach(['hero%20section%201.jpg', 'hero%20section%202.jpg', 'hero%20section%203.jpg'] as $index => $image)
            <div class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 style="
                    background-image: url('{{ asset('images/' . $image) }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    opacity: {{ $loop->first ? '1' : '0' }};
                 "
                 data-index="{{ $index }}">
            </div>
        @endforeach

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70 z-10 pointer-events-none"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-20 container mx-auto px-6 text-center pt-16 pb-40">
        
        {{-- Lokasi --}}
        <div class="inline-flex items-center bg-white/10 backdrop-blur-md rounded-full px-5 py-2 mb-8 border border-white/20 shadow-lg animate-fadeInDown hover:bg-white/20 transition-colors duration-300">
            <i class="fas fa-map-marker-alt text-cyan-300 mr-2 drop-shadow-md"></i>
            <span class="text-white font-medium drop-shadow-md tracking-wide text-sm md:text-base">
                Kecamatan Pilangkenceng, Kabupaten Madiun
            </span>
        </div>

        {{-- Title --}}
        <div class="mb-10 space-y-2">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-tight drop-shadow-xl animate-fadeInUp">
                Selamat Datang di
            </h1>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold leading-normal tracking-wide bg-gradient-to-r from-cyan-400 via-white to-cyan-400 bg-clip-text text-transparent drop-shadow-2xl animate-fadeInUp delay-200 pb-2">
                Desa Ngengor
            </h1>
        </div>

        {{-- Subtitle --}}
        <div class="space-y-4 mb-14">
            <p class="text-xl md:text-2xl text-white font-light max-w-3xl mx-auto leading-relaxed drop-shadow-md animate-fadeInUp delay-300">
                Portal Informasi dan Layanan Digital untuk Masyarakat
            </p>
            <p class="text-gray-200 text-base md:text-lg max-w-2xl mx-auto drop-shadow-md animate-fadeInUp delay-400 px-4">
                Temukan informasi lengkap tentang profil desa, data demografis, UMKM lokal, dan berbagai layanan publik dalam satu platform terpadu.
            </p>
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fadeInUp delay-500 mb-20">
            <a href="{{ route('infografis.index') }}" class="group relative overflow-hidden px-8 py-3 bg-cyan-600 text-white rounded-full font-semibold shadow-lg shadow-cyan-500/30 hover:bg-cyan-500 hover:shadow-cyan-500/50 transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto text-center">
                <span class="relative z-10 flex items-center justify-center">
                    <i class="fas fa-chart-line mr-2 group-hover:rotate-12 transition-transform duration-300"></i>
                    Lihat Infografis
                </span>
            </a>

            <a href="{{ route('profil-desa.index') }}" class="group relative overflow-hidden px-8 py-3 bg-cyan-600 text-white rounded-full font-semibold shadow-lg shadow-cyan-500/30 hover:bg-cyan-500 hover:shadow-cyan-500/50 transition-all duration-300 transform hover:-translate-y-1 w-full sm:w-auto text-center">
                <span class="relative z-10 flex items-center justify-center">
                    <i class="fas fa-info-circle mr-2 group-hover:scale-110 transition-transform duration-300"></i>
                    Profil Desa
                </span>
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-5xl mx-auto animate-fadeInUp delay-700 px-2">
            @foreach([
                ['label' => 'Penduduk', 'value' => number_format($totalPenduduk ?? 0), 'icon' => 'fa-users'],
                ['label' => 'UMKM Aktif', 'value' => number_format($jumlahUmkm ?? 0), 'icon' => 'fa-store'],
                ['label' => 'Dusun', 'value' => $jumlahDusun ?? 0, 'icon' => 'fa-map'],
                ['label' => 'Digital', 'value' => '100%', 'icon' => 'fa-wifi']
            ] as $stat)
                <div class="stat-card group bg-white/10 backdrop-blur-md rounded-xl p-4 border border-white/20 hover:bg-white/20 hover:border-cyan-400/50 transition-all duration-300 cursor-default transform hover:-translate-y-1">
                    <div class="text-3xl md:text-4xl font-bold text-white mb-1 drop-shadow-md group-hover:text-cyan-300 transition-colors">
                        {{ $stat['value'] }}
                    </div>
                    <div class="text-cyan-100 text-sm font-medium drop-shadow-sm uppercase tracking-wider flex items-center justify-center gap-2">
                        <span>{{ $stat['label'] }}</span>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- Scroll Icon --}}
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce hidden md:block z-20">
        <i class="fas fa-chevron-down text-white/70 text-2xl drop-shadow-lg"></i>
    </div>
</section>

@push('styles')
<style>
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out forwards; opacity: 0; }
    .animate-fadeInDown { animation: fadeInDown 0.8s ease-out forwards; opacity: 0; }

    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }
    .delay-700 { animation-delay: 0.7s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.hero-slide');
        if (!slides.length) return;

        let current = 0;
        const duration = 5000;

        function next() {
            slides[current].style.opacity = '0';
            current = (current + 1) % slides.length;
            slides[current].style.opacity = '1';
        }

        setInterval(next, duration);
    });
</script>
@endpush

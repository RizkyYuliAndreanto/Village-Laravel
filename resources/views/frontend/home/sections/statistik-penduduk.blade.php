{{-- Section: Statistik Penduduk --}}
<section class="min-h-screen flex items-center py-10 sm:py-16 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4 sm:px-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-teal-700 dark:text-cyan-300 mb-3 sm:mb-4">Statistik Penduduk</h2>
        <p class="text-teal-600 dark:text-cyan-200 max-w-3xl mb-2 text-sm sm:text-base">
            Sistem digital yang mempermudah pengelolaan data dan informasi kependudukan untuk pelayanan publik yang efektif dan efisien.
        </p>
        <p class="text-xs sm:text-sm text-teal-500 dark:text-cyan-300 mb-8 sm:mb-10">
            Data terbaru tahun 
            <span class="font-semibold text-teal-700 dark:text-cyan-400">
                {{ $tahunDataTerbaru ?? date('Y') }}
            </span>
        </p>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6">
            <x-stat-box 
                :value="$statistikPenduduk['totalPenduduk'] ?? 0" 
                label="Total Penduduk"
                icon="👥"
                color="blue" />
            <x-stat-box 
                :value="$statistikPenduduk['totalLaki'] ?? 0" 
                label="Laki-Laki"
                icon="👨"
                color="green" />
            <x-stat-box 
                :value="$statistikPenduduk['totalPerempuan'] ?? 0" 
                label="Perempuan"
                icon="👩"
                color="pink" />
            <x-stat-box 
                :value="$statistikPenduduk['pendudukSementara'] ?? 0" 
                label="Penduduk Sementara"
                icon="🏃"
                color="yellow" />
            <x-stat-box 
                :value="$statistikPenduduk['mutasiPenduduk'] ?? 0" 
                label="Mutasi Penduduk"
                icon="📊"
                color="purple" />
        </div>
        
        <div class="flex justify-center sm:justify-end mt-8 sm:mt-10 px-2">
            <a href="{{ route('infografis.index') }}" 
               class="inline-block px-6 sm:px-8 py-3 font-semibold rounded-lg shadow transition-all duration-300 text-white text-center"
               style="background: #0891b2; width: 100%; max-width: 200px;"
               onmouseover="this.style.background='#0e7490'" 
               onmouseout="this.style.background='#0891b2'">
                Lihat Data Lengkap →
            </a>
        </div>
    </div>
</section>
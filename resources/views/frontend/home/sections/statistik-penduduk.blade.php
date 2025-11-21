{{-- Section: Statistik Penduduk --}}
<section class="min-h-screen flex items-center py-10 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-teal-700 dark:text-cyan-300 mb-4">Statistik Penduduk</h2>
        <p class="text-teal-600 dark:text-cyan-200 max-w-3xl mb-2">
            Sistem digital yang mempermudah pengelolaan data dan informasi kependudukan untuk pelayanan publik yang efektif dan efisien.
        </p>
        <p class="text-sm text-teal-500 dark:text-cyan-300 mb-10">
            Data terbaru tahun 
            <span class="font-semibold text-teal-700 dark:text-cyan-400">
                {{ $tahunDataTerbaru ?? date('Y') }}
            </span>
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
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
        
        <div class="flex justify-end mt-10">
            <a href="{{ route('infografis.index') }}" 
               class="inline-block px-8 py-3 bg-cyan-500 text-white font-semibold rounded-lg shadow hover:bg-cyan-600 transition-all duration-300 hover:shadow-lg">
                Lihat Data Lengkap →
            </a>
        </div>
    </div>
</section>
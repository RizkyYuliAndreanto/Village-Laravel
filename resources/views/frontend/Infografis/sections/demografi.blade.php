{{-- File: resources/views/frontend/Infografis/sections/demografi.blade.php --}}
<section class="py-12 lg:py-20 infografis-section bg-white">
    <div class="container mx-auto px-4">
        
        <div class="text-center max-w-2xl mx-auto mb-8">
            <h3 class="text-2xl lg:text-4xl font-extrabold text-gray-800 mb-3">
                Statistik Demografi
            </h3>
            <p class="text-sm text-gray-500">
                Data Kependudukan Tahun <span class="font-bold text-primary-600">{{ $tahunAktif ?? date('Y') }}</span>
            </p>
        </div>

        {{-- Grid Responsif Aman --}}
        {{-- Mobile: 1 kolom (grid-cols-1) agar kotak besar dan jelas --}}
        {{-- Tablet Kecil: 2 kolom (sm:grid-cols-2) --}}
        {{-- Desktop: 5 kolom (lg:grid-cols-5) --}}
        <div id="demografi-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- Pastikan komponen x-stat-box tidak memiliki width fixed --}}
            <x-stat-box :value="$totalPenduduk ?? 0" label="Total Penduduk" id="stat-total-penduduk" class="w-full" />
            <x-stat-box :value="$totalLaki ?? 0" label="Laki-laki" id="stat-total-laki" class="w-full" />
            <x-stat-box :value="$totalPerempuan ?? 0" label="Perempuan" id="stat-total-perempuan" class="w-full" />
            <x-stat-box :value="$pendudukSementara ?? 0" label="Pddk. Sementara" id="stat-penduduk-sementara" class="w-full" />
            <x-stat-box :value="$mutasiPenduduk ?? 0" label="Mutasi" id="stat-mutasi-penduduk" class="w-full" />
        </div>
    </div>
</section>
{{-- Section: Statistik Demografi Penduduk --}}
<section class="min-h-screen flex items-center infografis-section py-20">
    <div class="container mx-auto px-6 flex flex-col items-center gap-10">
        <div class="text-center max-w-2xl">
            <h3 class="text-4xl font-extrabold mb-4 infografis-title">Statistik Demografi Penduduk</h3>
            <p class="infografis-subtitle">
                Berikut merupakan data terbaru demografi penduduk Desa Ngengor untuk tahun
                <span id="tahun-display-demografi" class="font-semibold text-primary-700">
                    {{ $tahunAktif ?? date('Y') }}
                </span>.
            </p>
        </div>

        {{-- Tahun Selector --}}
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'demografi',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="demografi-content" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-8">
            {{-- HAPUS number_format(), kirim raw value saja --}}
            <x-stat-box :value="$totalPenduduk ?? 0" label="Penduduk" id="stat-total-penduduk" />
            <x-stat-box :value="$totalLaki ?? 0" label="Laki-laki" id="stat-total-laki" />
            <x-stat-box :value="$totalPerempuan ?? 0" label="Perempuan" id="stat-total-perempuan" />
            <x-stat-box :value="$pendudukSementara ?? 0" label="Penduduk Sementara" id="stat-penduduk-sementara" />
            <x-stat-box :value="$mutasiPenduduk ?? 0" label="Mutasi Penduduk" id="stat-mutasi-penduduk" />
        </div>
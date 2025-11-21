{{-- Section: Berdasarkan Perkawinan --}}
<section class="py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold infografis-title mb-6">
            Berdasarkan Perkawinan 
            <span id="tahun-display-perkawinan" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'perkawinan',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="perkawinan-content" class="grid md:grid-cols-3 gap-6">
            @foreach([
                'Kawin' => $kawin ?? 0,
                'Cerai Mati' => $cerai_mati ?? 0,
                'Cerai Hidup' => $cerai_hidup ?? 0,
                'Kawin Tercatat' => $kawin_tercatat ?? 0,
                'Kawin Tidak Tercatat' => $kawin_tidak_tercatat ?? 0,
            ] as $label => $value)
            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold">{{ $label }}</div>
                <div class="text-3xl font-bold text-cyan-600">{{ $value }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
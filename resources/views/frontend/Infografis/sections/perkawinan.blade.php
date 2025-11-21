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
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'perkawinan',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="perkawinan-content" class="grid md:grid-cols-3 gap-6">
            @foreach([
                'Belum Kawin' => $belumKawin,
                'Kawin' => $perkawinan?->kawin,
                'Cerai Mati' => $perkawinan?->cerai_mati,
                'Cerai Hidup' => $perkawinan?->cerai_hidup,
                'Kawin Tercatat' => $perkawinan?->kawin_tercatat,
                'Kawin Tidak Tercatat' => $perkawinan?->kawin_tidak_tercatat,
            ] as $label => $value)
            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold">{{ $label }}</div>
                <div class="text-3xl font-bold text-cyan-600">{{ $value ?? 0 }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
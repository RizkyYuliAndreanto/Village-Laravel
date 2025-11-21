{{-- Section: Berdasarkan Agama --}}
<section class="py-20 infografis-section">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold infografis-title mb-6">
            Berdasarkan Agama 
            <span id="tahun-display-agama" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'agama',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="agama-content" class="grid md:grid-cols-3 gap-6">

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Islam</div>
                <div class="text-3xl font-bold text-primary-600" data-field="islam">{{ $islam ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Katolik</div>
                <div class="text-3xl font-bold text-primary-600">{{ $katolik ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Kristen</div>
                <div class="text-3xl font-bold text-primary-600">{{ $kristen ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Hindu</div>
                <div class="text-3xl font-bold text-primary-600">{{ $hindu ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Buddha</div>
                <div class="text-3xl font-bold text-primary-600">{{ $buddha ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Konghucu</div>
                <div class="text-3xl font-bold text-primary-600">{{ $konghucu ?? 0 }}</div>
            </div>

            <div class="infografis-card p-6 rounded-xl shadow text-center">
                <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                <div class="text-xl font-semibold infografis-title">Kepercayaan Lainnya</div>
                <div class="text-3xl font-bold text-primary-600">{{ $kepercayaan_lain ?? 0 }}</div>
            </div>

            <div>
                </div>

        </div>
    </div>
</section>
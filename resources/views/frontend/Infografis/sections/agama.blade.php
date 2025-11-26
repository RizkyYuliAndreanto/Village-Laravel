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
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'agama',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Chart --}}
            <div class="infografis-card p-5 rounded-xl shadow col-span-1 lg:col-span-1 flex items-center justify-center">
                <canvas id="chartAgama"></canvas>
            </div>

            {{-- Cards Grid --}}
            <div id="agama-content" class="col-span-1 lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Islam</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->islam ?? 0 }}</div>
                </div>
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Katolik</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->katolik ?? 0 }}</div>
                </div>
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Kristen</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->kristen ?? 0 }}</div>
                </div>
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Hindu</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->hindu ?? 0 }}</div>
                </div>
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Buddha</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->buddha ?? 0 }}</div>
                </div>
                <div class="infografis-card p-4 rounded-xl shadow text-center">
                    <div class="text-sm font-semibold text-gray-600">Konghucu</div>
                    <div class="text-2xl font-bold text-primary-600">{{ $agama->konghucu ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartAgama")) {
            const ctx = document.getElementById("chartAgama").getContext("2d");
            window.infografisCharts = window.infografisCharts || {};

            // Data awal dari Controller
            const agamaData = {
                'Islam': {{ $agama->islam ?? 0 }},
                'Katolik': {{ $agama->katolik ?? 0 }},
                'Kristen': {{ $agama->kristen ?? 0 }},
                'Hindu': {{ $agama->hindu ?? 0 }},
                'Buddha': {{ $agama->buddha ?? 0 }},
                'Konghucu': {{ $agama->konghucu ?? 0 }},
                'Lainnya': {{ $agama->kepercayaan_lain ?? 0 }}
            };

            // Filter data yang 0 agar chart bersih
            const labels = Object.keys(agamaData).filter(key => agamaData[key] > 0);
            const data = labels.map(key => agamaData[key]);

            window.infografisCharts['agama'] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#4CAF50', '#2196F3', '#FF9800', '#E91E63', '#9C27B0', '#607D8B', '#795548']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });
</script>
@endpush
{{-- Section: Berdasarkan Pendidikan --}}
<section class="py-20 infografis-section">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-extrabold mb-6 infografis-title">
            Berdasarkan Pendidikan 
            <span id="tahun-display-pendidikan" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'pendidikan',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="pendidikan-content" class="infografis-card p-5 rounded-xl shadow">
            <canvas id="chartPendidikan" height="130"></canvas>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Chart Pendidikan
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Loading Pendidikan Chart...');
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }
        
        const chartElement = document.getElementById("chartPendidikan");
        if (chartElement) {
            console.log('Pendidikan chart element found, creating chart...');
            const pendidikan = chartElement.getContext("2d");

            new Chart(pendidikan, {
            type: "bar",
            data: {
                labels: [
                    "Tidak/Belum Sekolah", "SD/Sederajat", "SMP/Sederajat",
                    "SMA/Sederajat", "Diploma I/II/III/IV", "Strata 1", "Strata 2", "Strata 3"
                ],
                datasets: [{
                    data: [
                        {{ $tidak_sekolah_pendidikan ?? 0 }},
                        {{ $sd ?? 0 }},
                        {{ $smp ?? 0 }},
                        {{ $sma ?? 0 }},
                        {{ $d1_d4 ?? 0 }},
                        {{ $s1 ?? 0 }},
                        {{ $s2 ?? 0 }},
                        {{ $s3 ?? 0 }}
                    ],
                    backgroundColor: "#2563eb",
                    borderColor: "#1d4ed8",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        }
    });
</script>
@endpush
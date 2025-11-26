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
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'pendidikan',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        {{-- Container Chart diperbesar dengan h-[500px] --}}
        <div id="pendidikan-content" class="infografis-card p-6 rounded-xl shadow w-full">
            <div class="h-[480px] w-[750px] relative">
                <canvas id="chartPendidikan"></canvas>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartPendidikan")) {
            const ctx = document.getElementById("chartPendidikan").getContext("2d");

            window.infografisCharts = window.infografisCharts || {};

            window.infografisCharts['pendidikan'] = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: [
                        "Tidak/Belum Sekolah", "SD/Sederajat", "SMP/Sederajat",
                        "SMA/Sederajat", "Diploma I/II/III/IV", "Strata 1", "Strata 2", "Strata 3"
                    ],
                    datasets: [{
                        label: "Jumlah Jiwa",
                        data: [
                            {{ $pendidikan->tidak_sekolah ?? 0 }},
                            {{ $pendidikan->sd ?? 0 }},
                            {{ $pendidikan->smp ?? 0 }},
                            {{ $pendidikan->sma ?? 0 }},
                            {{ $pendidikan->d1_d4 ?? 0 }},
                            {{ $pendidikan->s1 ?? 0 }},
                            {{ $pendidikan->s2 ?? 0 }},
                            {{ $pendidikan->s3 ?? 0 }}
                        ],
                        backgroundColor: "#2563eb",
                        borderColor: "#1d4ed8",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // PENTING: Agar chart mengikuti tinggi container (h-[500px])
                    indexAxis: 'y', // Horizontal bar
                    plugins: { 
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.x + ' Jiwa';
                                }
                            }
                        }
                    },
                    scales: { 
                        x: { 
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6' // Grid yang lebih halus
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 13 // Ukuran font label sumbu Y sedikit diperbesar
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
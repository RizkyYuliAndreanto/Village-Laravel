{{-- Section: Berdasarkan Pendidikan --}}
<section class="py-8 sm:py-12 lg:py-20 infografis-section">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-4 sm:mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mb-3 sm:mb-4 lg:mb-6 infografis-title">
                Berdasarkan Pendidikan 
                <span id="tahun-display-pendidikan" class="text-sm sm:text-base lg:text-lg text-primary-600 block sm:inline">
                    ({{ $tahunAktif ?? date('Y') }})
                </span>
            </h3>
        </div>

        

        <div id="pendidikan-content" class="infografis-card p-4 sm:p-6 lg:p-10 rounded-xl shadow">
            <div class="chart-container">
                <canvas id="chartPendidikan"></canvas>
            </div>
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 8 : 12
                            },
                            maxRotation: window.innerWidth < 640 ? 45 : 0
                        }
                    }
                }
            }
        });
        }
    });
</script>
@endpush
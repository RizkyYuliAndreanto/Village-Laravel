{{-- Section: Berdasarkan Wajib Pilih --}}
<section class="py-8 sm:py-12 lg:py-20 infografis-section">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-4 sm:mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mb-3 sm:mb-4 lg:mb-6 infografis-title">
                Berdasarkan Wajib Pilih 
                <span id="tahun-display-wajib-pilih" class="text-sm sm:text-base lg:text-lg text-primary-600 block sm:inline">
                    ({{ $tahunAktif ?? date('Y') }})
                </span>
            </h3>
        </div>

      
        <div id="wajib-pilih-content" class="infografis-card p-4 sm:p-6 lg:p-10 rounded-xl shadow">
            <div class="chart-container">
                <canvas id="chartWajibPilih"></canvas>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Chart Wajib Pilih
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Loading Wajib Pilih Chart...');
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }
        
        const chartElement = document.getElementById("chartWajibPilih");
        if (chartElement) {
            console.log('Wajib Pilih chart element found, creating chart...');
            const wajib = chartElement.getContext("2d");

            new Chart(wajib, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan', 'Total'],
                datasets: [{
                    data: [{{ $wajib_pilih_laki ?? 0 }}, {{ $wajib_pilih_perempuan ?? 0 }}, {{ $wajib_pilih_total ?? 0 }}],
                    backgroundColor: "#2563eb",
                    borderRadius: 6,
                    barThickness: 70
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
                            stepSize: 300,
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: window.innerWidth < 640 ? 10 : 12
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
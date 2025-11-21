{{-- Section: Berdasarkan Wajib Pilih --}}
<section class="py-20 infografis-section">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold infografis-title mb-6">
            Berdasarkan Wajib Pilih 
            <span id="tahun-display-wajib-pilih" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'wajib-pilih',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="wajib-pilih-content" class="infografis-card p-5 rounded-xl shadow">
            <canvas id="chartWajibPilih" height="130"></canvas>
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
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 300
                        }
                    }
                }
            }
        });
        }
    });
</script>
@endpush
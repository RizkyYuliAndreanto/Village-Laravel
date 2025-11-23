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
        @include('frontend.Infografis.partials.tahun-selector', [
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
    if (document.getElementById("chartWajibPilih")) {
        const wajib = document.getElementById("chartWajibPilih").getContext("2d");

        new Chart(wajib, {
            type: 'bar',
            data: {
                labels: @json($wajibPilihLabels),
                datasets: [{
                    data: @json($wajibPilihTotals),
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
</script>
@endpush
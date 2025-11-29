{{-- Section: Berdasarkan Wajib Pilih --}}
<section class="py-20 infografis-section">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold infografis-title mb-6">
            Berdasarkan Wajib Pilih 
            <span id="tahun-display-wajib-pilih" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>
        <div id="wajib-pilih-content" class="infografis-card p-6 rounded-xl shadow w-full">
            {{-- Container Chart --}}
            <div class="h-[400px] w-full relative flex items-center justify-center">
                <canvas id="chartWajibPilih"></canvas>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartWajibPilih")) {
            const ctx = document.getElementById("chartWajibPilih").getContext("2d");

            // Registrasi global untuk update AJAX
            window.infografisCharts = window.infografisCharts || {};

            // Data dari Controller (Blade)
            // Menggunakan json_encode untuk array PHP agar menjadi array JS yang valid
            const labels = @json($wajibPilihLabels ?? []);
            const data = @json($wajibPilihTotals ?? []);

            // Cek jika data kosong
            const hasData = data.length > 0 && data.some(val => val > 0);

            if (!hasData) {
                // Opsi: Tampilkan pesan jika data kosong
                // console.log('Data Wajib Pilih kosong untuk tahun ini');
            }

            window.infografisCharts['wajib-pilih'] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels.length ? labels : ['Data Kosong'],
                    datasets: [{
                        label: "Jumlah Jiwa",
                        data: data.length ? data : [0],
                        backgroundColor: ["#dc2626", "#9ca3af", "#3b82f6"], // Merah, Abu, Biru
                        borderRadius: 6,
                        barThickness: 60,
                        maxBarThickness: 80
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Agar mengikuti tinggi container
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Jiwa';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
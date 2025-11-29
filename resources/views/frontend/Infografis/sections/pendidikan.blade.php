{{-- File: resources/views/frontend/Infografis/sections/pendidikan.blade.php --}}
<section class="py-10 lg:py-20 infografis-section border-b border-gray-200">
    <div class="container mx-auto px-4"> {{-- Gunakan px-4 agar tidak terlalu mepet di HP --}}
        <div class="text-center lg:text-left mb-6">
            <h3 class="text-2xl lg:text-3xl font-extrabold mb-2 infografis-title text-gray-800">
                Berdasarkan Pendidikan 
            </h3>
            <p class="text-primary-600 font-medium">
                Data Tahun {{ $tahunAktif ?? date('Y') }}
            </p>
        </div>

        <div id="pendidikan-content" class="infografis-card bg-white p-4 lg:p-6 rounded-xl shadow-sm border border-gray-100 w-full">
            {{-- 
               FIX UTAMA: 
               1. Hapus w-[750px] yang bikin jebol.
               2. Ganti dengan w-full.
               3. Atur tinggi responsive (400px di HP, 500px di Desktop).
            --}}
            <div class="relative w-full h-[400px] lg:h-[500px]">
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
                        "SMA/Sederajat", "Diploma I-IV", "Strata 1", "Strata 2", "Strata 3"
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
                        backgroundColor: "#3b82f6", // Tailwind blue-500
                        borderRadius: 4,
                        barPercentage: 0.7,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // WAJIB FALSE
                    indexAxis: 'y', // Horizontal bar agar label panjang terbaca di HP
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
                            grid: { color: '#f3f4f6' },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            grid: { display: false },
                            ticks: {
                                autoSkip: false, // Pastikan semua label muncul
                                font: { size: 11 } // Ukuran font label Y disesuaikan untuk HP
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
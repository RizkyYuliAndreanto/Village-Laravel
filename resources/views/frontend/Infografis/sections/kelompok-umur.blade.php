{{-- Section: Berdasarkan Kelompok Umur --}}
<section class="min-h-screen flex flex-col justify-center py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6 flex flex-col gap-8">
        <div class="text-left">
            <h3 class="text-3xl font-extrabold mb-3 infografis-title">
                Berdasarkan Kelompok Umur
            </h3>
            <p class="infografis-subtitle max-w-2xl">
                Jumlah penduduk berdasarkan kelompok umur untuk tahun
                <span id="tahun-display-umur" class="font-semibold text-primary-700">
                    {{ $tahunAktif ?? date('Y') }}
                </span>.
            </p>
        </div>

        <div id="umur-content" class="w-full infografis-card p-6 rounded-2xl shadow-md">
            <div class="h-[500px]">
                <canvas id="chartPiramida"></canvas>
            </div>
        </div>
    </div>

    {{-- Kalkulasi Data Tertinggi (Insight) --}}
    @php
        // Konversi object data ke array untuk kalkulasi di view
        $umurArray = isset($umurData) ? (array) $umurData : [];
        $maxUmurVal = 0;
        $maxUmurKeyDisplay = '-';
        $percentage = 0;
        $totalSemuaUmur = array_sum($umurArray);

        if (!empty($umurArray) && $totalSemuaUmur > 0) {
            $maxUmurVal = max($umurArray);
            $maxUmurKey = array_search($maxUmurVal, $umurArray);
            // Format key (umur_25_29 -> 25-29)
            $maxUmurKeyDisplay = str_replace(['umur_', '_plus', '_'], ['', '+', '-'], $maxUmurKey);
            $percentage = round(($maxUmurVal / $totalSemuaUmur) * 100, 2);
        }
    @endphp

    <div class="container mx-auto px-6 mt-10 space-y-6">
        <div class="infografis-card border-t-4 border-primary-500 p-6 rounded-xl shadow-md">
            <p class="text-body text-center lg:text-left">
                Kelompok umur dengan jumlah penduduk terbanyak adalah usia
                <strong>{{ $maxUmurKeyDisplay }} tahun</strong> dengan total 
                <strong>{{ number_format($maxUmurVal) }} jiwa</strong> ({{ $percentage }}% dari total penduduk).
            </p>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartPiramida")) {
            const ctx = document.getElementById("chartPiramida").getContext("2d");

            // Inisialisasi global object charts jika belum ada
            window.infografisCharts = window.infografisCharts || {};

            // Data dari Controller (Blade -> JS)
            const rawData = {
                '0-4': {{ $umurData->umur_0_4 ?? 0 }},
                '5-9': {{ $umurData->umur_5_9 ?? 0 }},
                '10-14': {{ $umurData->umur_10_14 ?? 0 }},
                '15-19': {{ $umurData->umur_15_19 ?? 0 }},
                '20-24': {{ $umurData->umur_20_24 ?? 0 }},
                '25-29': {{ $umurData->umur_25_29 ?? 0 }},
                '30-34': {{ $umurData->umur_30_34 ?? 0 }},
                '35-39': {{ $umurData->umur_35_39 ?? 0 }},
                '40-44': {{ $umurData->umur_40_44 ?? 0 }},
                '45-49': {{ $umurData->umur_45_49 ?? 0 }},
                '50+': {{ $umurData->umur_50_plus ?? 0 }}
            };

            const labels = Object.keys(rawData);
            
            // Estimasi Laki-laki (Negatif) & Perempuan (Positif)
            const dataLaki = Object.values(rawData).map(val => -(val / 2)); 
            const dataPerempuan = Object.values(rawData).map(val => (val / 2));

            // Buat Chart Instance
            window.infografisCharts['umur'] = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Laki-laki (Est.)",
                        data: dataLaki,
                        backgroundColor: "rgba(56, 161, 105, 0.8)"
                    }, {
                        label: "Perempuan (Est.)",
                        data: dataPerempuan,
                        backgroundColor: "rgba(244, 114, 182, 0.8)"
                    }]
                },
                options: {
                    indexAxis: "y", // Horizontal Bar
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                // Hapus tanda minus di sumbu X
                                callback: value => Math.abs(value)
                            }
                        },
                        y: {
                            stacked: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                // Hapus tanda minus di tooltip
                                label: ctx => ctx.dataset.label + ": " + Math.abs(ctx.raw)
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
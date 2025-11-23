{{-- Section: Berdasarkan Kelompok Umur --}}
<section class="min-h-screen flex flex-col justify-center py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6 flex flex-col gap-8">
        <div class="text-left">
            <h3 class="text-3xl font-extrabold mb-3 infografis-title">
                Berdasarkan Kelompok Umur
            </h3>
            <p class="infografis-subtitle max-w-2xl">
                Jumlah penduduk laki-laki dan perempuan berdasarkan kelompok umur untuk tahun
                <span id="tahun-display-umur" class="font-semibold text-primary-700">
                    {{ $tahunAktif ?? date('Y') }}
                </span>.
            </p>
        </div>

        {{-- Tahun Selector --}}
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'umur',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="umur-content" class="w-full infografis-card p-6 rounded-2xl shadow-md">
            <div class="h-[500px]">
                <canvas id="chartPiramida"></canvas>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 mt-10 space-y-6">
        <div class="infografis-card border-t-4 border-primary-400 p-6 rounded-xl shadow-md">
            <p class="text-body">
                Untuk jenis kelamin <strong>laki-laki</strong>, kelompok umur
                <strong>25–29</strong> adalah yang tertinggi (99 orang / 10.65%).
            </p>
        </div>

        <div class="infografis-card border-t-4 border-primary-600 p-6 rounded-xl shadow-md">
            <p class="text-body">
                Untuk jenis kelamin <strong>perempuan</strong>, kelompok umur
                <strong>25–29</strong> adalah yang tertinggi (112 orang / 11.67%).
            </p>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Piramida Penduduk Chart
    if (document.getElementById("chartPiramida")) {
        const piramida = document.getElementById("chartPiramida").getContext("2d");

        new Chart(piramida, {
            type: "bar",
            data: {
                labels: [
                    '0-4', '5-9', '10-14', '15-19', '20-24',
                    '25-29', '30-34', '35-39', '40-44', '45-49', '50+'
                ],
                datasets: [{
                    label: "Laki-laki",
                    data: [
                        -{{ $umurData->umur_0_4 ?? 0 }},
                        -{{ $umurData->umur_5_9 ?? 0 }},
                        -{{ $umurData->umur_10_14 ?? 0 }},
                        -{{ $umurData->umur_15_19 ?? 0 }},
                        -{{ $umurData->umur_20_24 ?? 0 }},
                        -{{ $umurData->umur_25_29 ?? 0 }},
                        -{{ $umurData->umur_30_34 ?? 0 }},
                        -{{ $umurData->umur_35_39 ?? 0 }},
                        -{{ $umurData->umur_40_44 ?? 0 }},
                        -{{ $umurData->umur_45_49 ?? 0 }},
                        -{{ $umurData->umur_50_plus ?? 0 }}
                    ],
                    backgroundColor: "rgba(56, 161, 105, 0.8)"
                }, {
                    label: "Perempuan",
                    data: [
                        {{ $umurData->umur_0_4 ?? 0 }},
                        {{ $umurData->umur_5_9 ?? 0 }},
                        {{ $umurData->umur_10_14 ?? 0 }},
                        {{ $umurData->umur_15_19 ?? 0 }},
                        {{ $umurData->umur_20_24 ?? 0 }},
                        {{ $umurData->umur_25_29 ?? 0 }},
                        {{ $umurData->umur_30_34 ?? 0 }},
                        {{ $umurData->umur_35_39 ?? 0 }},
                        {{ $umurData->umur_40_44 ?? 0 }},
                        {{ $umurData->umur_45_49 ?? 0 }},
                        {{ $umurData->umur_50_plus ?? 0 }}
                    ],
                    backgroundColor: "rgba(244, 114, 182, 0.8)"
                }]
            },
            options: {
                indexAxis: "y",
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
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
                            label: ctx => ctx.dataset.label + ": " + Math.abs(ctx.raw)
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
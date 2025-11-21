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

        <div id="pendidikan-content" class="infografis-card p-5 rounded-xl shadow">
            <canvas id="chartPendidikan" height="130"></canvas>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Chart Pendidikan
    if (document.getElementById("chartPendidikan")) {
        const pendidikan = document.getElementById("chartPendidikan").getContext("2d");

        new Chart(pendidikan, {
            type: "bar",
            data: {
                labels: [
                    "Tidak/Belum Sekolah", "SD/Sederajat", "SMP/Sederajat",
                    "SMA/Sederajat", "Diploma I/II/III/IV", "Strata 1", "Strata 2", "Strata 3"
                ],
                datasets: [{
                    data: [
                        {{ $data->tidak_sekolah ?? 0 }},
                        {{ $data->sd ?? 0 }},
                        {{ $data->smp ?? 0 }},
                        {{ $data->sma ?? 0 }},
                        {{ $data->d1_d4 ?? 0 }},
                        {{ $data->s1 ?? 0 }},
                        {{ $data->s2 ?? 0 }},
                        {{ $data->s3 ?? 0 }}
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
</script>
@endpush
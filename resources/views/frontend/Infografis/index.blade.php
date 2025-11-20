@extends('frontend.layouts.main')

@section('content')

    <section class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 py-16">
        <div class="flex justify-end mb-6">
            @include('frontend.layouts.partials.submenu')
        </div>

        <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="max-w-xl text-center lg:text-left">
                <h3 class="text-3xl font-extrabold mb-4 text-gray-900 dark:text-white">DEMOGRAFI PENDUDUK</h3>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
                    Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
                </p>
            </div>

            <div class="flex-shrink-0">
                <img class="rounded-2xl shadow-lg max-w-sm w-full object-cover"
                    src="{{ asset('images/logo-placeholder.jpg') }}" alt="Logo Desa">
            </div>
        </div>
    </section>

    <section class="min-h-screen flex items-center bg-gray-100 dark:bg-gray-900 py-20">
        <div class="container mx-auto px-6 flex flex-col items-center gap-10">
            <div class="text-center max-w-2xl">
                <h3 class="text-4xl font-extrabold mb-4 text-gray-900 dark:text-white">Statistik Demografi Penduduk</h3>
                <p class="text-gray-700 dark:text-gray-300">
                    Berikut merupakan data terbaru demografi penduduk Desa Ngengor untuk tahun
                    <span class="font-semibold text-blue-600 dark:text-blue-400">
                        {{ $tahunDataTerbaru->tahun ?? '-' }}
                    </span>.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-8">
                <x-stat-box :value="$totalPenduduk" label="Penduduk" />
                <x-stat-box :value="$totalLaki" label="Laki-laki" />
                <x-stat-box :value="$totalPerempuan" label="Perempuan" />
                <x-stat-box :value="$pendudukSementara" label="Penduduk Sementara" />
                <x-stat-box :value="$mutasiPenduduk" label="Mutasi Penduduk" />
            </div>
        </div>
    </section>

    <section class="min-h-screen flex flex-col justify-center py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6 flex flex-col gap-8">
            <div class="text-left">
                <h3 class="text-3xl font-extrabold mb-3 text-gray-900 dark:text-white">
                    Berdasarkan Kelompok Umur
                </h3>
                <p class="text-gray-700 dark:text-gray-300 max-w-2xl">
                    Jumlah penduduk laki-laki dan perempuan berdasarkan kelompok umur.
                </p>
            </div>

            <div class="w-full bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
                <div class="h-[500px]">
                    <canvas id="chartPiramida"></canvas>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-6 mt-10 space-y-6">
            <div class="bg-white dark:bg-gray-800 border-t-4 border-green-400 p-6 rounded-xl shadow-md">
                <p class="text-gray-700 dark:text-gray-300">
                    Untuk jenis kelamin <strong>laki-laki</strong>, kelompok umur
                    <strong>25–29</strong> adalah yang tertinggi (99 orang / 10.65%).
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 border-t-4 border-pink-400 p-6 rounded-xl shadow-md">
                <p class="text-gray-700 dark:text-gray-300">
                    Untuk jenis kelamin <strong>perempuan</strong>, kelompok umur
                    <strong>25–29</strong> adalah yang tertinggi (112 orang / 11.67%).
                </p>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6">

            <h3 class="text-3xl font-extrabold mb-6 text-gray-900 dark:text-white">
                Berdasarkan Pendidikan
            </h3>

            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <canvas id="chartPendidikan" height="130"></canvas>
            </div>

        </div>
    </section>

    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6">

            <h3 class="text-3xl font-bold text-red-600 mb-6">Berdasarkan Pekerjaan</h3>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 col-span-1">
                    <table class="w-full text-gray-800 dark:text-gray-200">
                        <thead>
                            <tr class="bg-red-400 text-white">
                                <th class="p-3 text-left">Jenis Pekerjaan</th>
                                <th class="p-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="p-2">Petani/Pekebun</td><td class="p-2 text-right">{{ $pekerjaan->petani ?? 0 }}</td></tr>
                            <tr><td class="p-2">Belum/Tidak Bekerja</td><td class="p-2 text-right">{{ $pekerjaan->belum_bekerja ?? 0 }}</td></tr>
                            <tr><td class="p-2">Pelajar/Mahasiswa</td><td class="p-2 text-right">{{ $pekerjaan->pelajar_mahasiswa ?? 0 }}</td></tr>
                            <tr><td class="p-2">Mengurus Rumah Tangga</td><td class="p-2 text-right">{{ $pekerjaan->ibu_rumah_tangga ?? 0 }}</td></tr>
                            <tr><td class="p-2">Wiraswasta</td><td class="p-2 text-right">{{ $pekerjaan->wiraswasta ?? 0 }}</td></tr>
                            <tr><td class="p-2">Karyawan Swasta</td><td class="p-2 text-right">{{ $pekerjaan->pegawai_swasta ?? 0 }}</td></tr>
                            <tr><td class="p-2">Buruh Tani/Perkebunan</td><td class="p-2 text-right">{{ $pekerjaan->lainnya ?? 0 }}</td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach([
                        'Petani/Pekebun' => $pekerjaan->petani,
                        'Belum/Tidak Bekerja' => $pekerjaan->belum_bekerja,
                        'Pelajar/Mahasiswa' => $pekerjaan->pelajar_mahasiswa,
                        'Mengurus Rumah Tangga' => $pekerjaan->ibu_rumah_tangga,
                        'Wiraswasta' => $pekerjaan->wiraswasta,
                        'Karyawan Swasta' => $pekerjaan->pegawai_swasta,
                        'Buruh Tani/Perkebunan' => $pekerjaan->lainnya,
                    ] as $label => $value)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-5 text-center">
                        <h4 class="text-gray-700 dark:text-gray-200">{{ $label }}</h4>
                        <p class="text-3xl font-bold">{{ $value ?? 0 }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6">

            <h3 class="text-3xl font-bold text-red-600 mb-6">Berdasarkan Wajib Pilih</h3>

            <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow">
                <canvas id="chartWajibPilih" height="130"></canvas>
            </div>

        </div>
    </section>

    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-red-600 mb-6">
                Berdasarkan Perkawinan
            </h3>

            <div class="grid md:grid-cols-3 gap-6">

                @foreach([
                    'Belum Kawin' => $belumKawin,
                    'Kawin' => $perkawinan?->kawin,
                    'Cerai Mati' => $perkawinan?->cerai_mati,
                    'Cerai Hidup' => $perkawinan?->cerai_hidup,
                    'Kawin Tercatat' => $perkawinan?->kawin_tercatat,
                    'Kawin Tidak Tercatat' => $perkawinan?->kawin_tidak_tercatat,
                ] as $label => $value)
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">{{ $label }}</div>
                    <div class="text-3xl font-bold text-red-600">{{ $value ?? 0 }}</div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-6">
            <h3 class="text-3xl font-bold text-red-600 mb-6">
                Berdasarkan Agama
            </h3>

            <div class="grid md:grid-cols-3 gap-6">

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Islam</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->islam ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Katolik</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->katolik ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Kristen</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->kristen ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Hindu</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->hindu ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Buddha</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->buddha ?? 0 }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Konghucu</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->konghucu ?? 0 }}</div>
                </div>

                <div>
                    </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow text-center">
                    <img src="{{ asset('images/logo-placeholder.jpg') }}" class="w-24 mx-auto mb-3" alt="Icon">
                    <div class="text-xl font-semibold">Kepercayaan Lainnya</div>
                    <div class="text-3xl font-bold text-red-600">{{ $agama?->kepercayaan_lain ?? 0 }}</div>
                </div>

                <div>
                    </div>

            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            /* ================= PIRAMIDA PENDUDUK ================= */
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

            /* ================= PENDIDIKAN ================= */
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
                        backgroundColor: "#b80000",
                        borderColor: "#820000",
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

            /* ================= WAJIB PILIH ================= */
            const wajib = document.getElementById("chartWajibPilih").getContext("2d");

            new Chart(wajib, {
                type: 'bar',
                data: {
                    labels: @json($wajibPilihLabels),
                    datasets: [{
                        data: @json($wajibPilihTotals),
                        backgroundColor: "#8b0000",
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

        });
    </script>
@endpush
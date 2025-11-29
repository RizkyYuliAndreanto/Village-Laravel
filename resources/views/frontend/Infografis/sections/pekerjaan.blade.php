{{-- File: resources/views/frontend/Infografis/sections/pekerjaan.blade.php --}}
<section class="py-10 lg:py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4">
        <div class="text-center lg:text-left mb-6">
            <h3 class="text-2xl lg:text-3xl font-bold infografis-title text-gray-800 mb-2">
                Berdasarkan Pekerjaan 
            </h3>
            <span id="tahun-display-pekerjaan" class="text-primary-600 font-medium">
                Tahun {{ $tahunAktif ?? date('Y') }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Tabel Data dengan Scroll Horizontal (Agar tidak jebol) --}}
            <div class="infografis-card rounded-xl shadow-sm bg-white p-4 lg:p-6 col-span-1 overflow-hidden">
                <div class="overflow-x-auto"> {{-- Wrapper Scroll --}}
                    <table id="tabel-pekerjaan" class="w-full text-sm lg:text-base">
                        <thead>
                            <tr class="bg-cyan-600 text-white rounded-lg">
                                <th class="p-3 text-left rounded-tl-lg">Jenis Pekerjaan</th>
                                <th class="p-3 text-right rounded-tr-lg">Jml</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr><td class="p-3">Petani</td><td class="p-3 text-right font-bold">{{ $pekerjaan->petani ?? 0 }}</td></tr>
                            <tr><td class="p-3">Belum Bekerja</td><td class="p-3 text-right font-bold">{{ $pekerjaan->belum_bekerja ?? 0 }}</td></tr>
                            <tr><td class="p-3">Pelajar</td><td class="p-3 text-right font-bold">{{ $pekerjaan->pelajar_mahasiswa ?? 0 }}</td></tr>
                            <tr><td class="p-3">IRT</td><td class="p-3 text-right font-bold">{{ $pekerjaan->ibu_rumah_tangga ?? 0 }}</td></tr>
                            <tr><td class="p-3">Wiraswasta</td><td class="p-3 text-right font-bold">{{ $pekerjaan->wiraswasta ?? 0 }}</td></tr>
                            <tr><td class="p-3">Karyawan</td><td class="p-3 text-right font-bold">{{ $pekerjaan->pegawai_swasta ?? 0 }}</td></tr>
                            <tr><td class="p-3">Lainnya</td><td class="p-3 text-right font-bold">{{ $pekerjaan->lainnya ?? 0 }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Chart --}}
            <div class="col-span-1 lg:col-span-2 infografis-card p-4 lg:p-6 rounded-xl shadow-sm bg-white">
                <div class="relative w-full h-[350px] lg:h-[450px]">
                    <canvas id="chartPekerjaan"></canvas>
                </div>
            </div>

        </div>
    </div>
</section>
{{-- Script JS Pekerjaan tetap sama, hanya pastikan maintainAspectRatio: false di options --}}
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartPekerjaan")) {
            const ctx = document.getElementById("chartPekerjaan").getContext("2d");
            window.infografisCharts = window.infografisCharts || {};

            window.infografisCharts['pekerjaan'] = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Petani', 'Belum Bekerja', 'Pelajar', 'IRT', 'Wiraswasta', 'Karyawan', 'Lainnya'],
                    datasets: [{
                        label: 'Jumlah Jiwa',
                        data: [
                            {{ $pekerjaan->petani ?? 0 }},
                            {{ $pekerjaan->belum_bekerja ?? 0 }},
                            {{ $pekerjaan->pelajar_mahasiswa ?? 0 }},
                            {{ $pekerjaan->ibu_rumah_tangga ?? 0 }},
                            {{ $pekerjaan->wiraswasta ?? 0 }},
                            {{ $pekerjaan->pegawai_swasta ?? 0 }},
                            {{ $pekerjaan->lainnya ?? 0 }}
                        ],
                        backgroundColor: 'rgba(6, 182, 212, 0.8)', // Cyan-500
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false, // WAJIB
                    plugins: { legend: { display: false } },
                    scales: { 
                        x: { beginAtZero: true, grid: { display: false } },
                        y: { grid: { display: false } } 
                    }
                }
            });
        }
    });
</script>
@endpush
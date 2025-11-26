{{-- Section: Berdasarkan Pekerjaan --}}
<section class="py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-bold infografis-title mb-6">
            Berdasarkan Pekerjaan 
            <span id="tahun-display-pekerjaan" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.Infografis.partials.tahun-selector', [
            'sectionId' => 'pekerjaan',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Tabel Data --}}
    <div class="infografis-card rounded-2xl shadow-lg p-8 col-span-1 text-base">
        <table id="tabel-pekerjaan" class="w-full text-heading text-base">
            <thead>
                <tr class="bg-cyan-600 text-white">
                    <th class="p-3 text-left">Jenis Pekerjaan</th>
                    <th class="p-3 text-right">Jml</th>
                </tr>
            </thead>
            <tbody class="text-[17px]">
                <tr><td class="p-3">Petani</td><td class="p-3 text-right">{{ $pekerjaan->petani ?? 0 }}</td></tr>
                <tr><td class="p-3">Belum Bekerja</td><td class="p-3 text-right">{{ $pekerjaan->belum_bekerja ?? 0 }}</td></tr>
                <tr><td class="p-3">Pelajar</td><td class="p-3 text-right">{{ $pekerjaan->pelajar_mahasiswa ?? 0 }}</td></tr>
                <tr><td class="p-3">IRT</td><td class="p-3 text-right">{{ $pekerjaan->ibu_rumah_tangga ?? 0 }}</td></tr>
                <tr><td class="p-3">Wiraswasta</td><td class="p-3 text-right">{{ $pekerjaan->wiraswasta ?? 0 }}</td></tr>
                <tr><td class="p-3">Karyawan</td><td class="p-3 text-right">{{ $pekerjaan->pegawai_swasta ?? 0 }}</td></tr>
                <tr><td class="p-3">Lainnya</td><td class="p-3 text-right">{{ $pekerjaan->lainnya ?? 0 }}</td></tr>
            </tbody>
        </table>
    </div>

    {{-- Chart --}}
    <div class="col-span-1 lg:col-span-2 infografis-card p-8 rounded-2xl shadow-lg h-[450px]">
        <canvas id="chartPekerjaan"></canvas>
    </div>

</div>

    </div>
</section>

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
                        backgroundColor: 'rgba(75, 192, 192, 0.8)'
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { x: { beginAtZero: true } }
                }
            });
        }
    });
</script>
@endpush
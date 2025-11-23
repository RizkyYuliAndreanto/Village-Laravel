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

        <div id="pekerjaan-content" class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="infografis-card rounded-xl shadow p-5 col-span-1">
                <table id="tabel-pekerjaan" class="w-full text-heading">
                    <thead>
                        <tr class="bg-cyan-600 text-white">
                            <th class="p-3 text-left">Jenis Pekerjaan</th>
                            <th class="p-3 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="p-2">Petani/Pekebun</td><td class="p-2 text-right" data-field="petani">{{ $pekerjaan->petani ?? 0 }}</td></tr>
                        <tr><td class="p-2">Belum/Tidak Bekerja</td><td class="p-2 text-right" data-field="belum_bekerja">{{ $pekerjaan->belum_bekerja ?? 0 }}</td></tr>
                        <tr><td class="p-2">Pelajar/Mahasiswa</td><td class="p-2 text-right" data-field="pelajar_mahasiswa">{{ $pekerjaan->pelajar_mahasiswa ?? 0 }}</td></tr>
                        <tr><td class="p-2">Mengurus Rumah Tangga</td><td class="p-2 text-right" data-field="ibu_rumah_tangga">{{ $pekerjaan->ibu_rumah_tangga ?? 0 }}</td></tr>
                        <tr><td class="p-2">Wiraswasta</td><td class="p-2 text-right" data-field="wiraswasta">{{ $pekerjaan->wiraswasta ?? 0 }}</td></tr>
                        <tr><td class="p-2">Karyawan Swasta</td><td class="p-2 text-right" data-field="pegawai_swasta">{{ $pekerjaan->pegawai_swasta ?? 0 }}</td></tr>
                        <tr><td class="p-2">Buruh Tani/Perkebunan</td><td class="p-2 text-right" data-field="lainnya">{{ $pekerjaan->lainnya ?? 0 }}</td></tr>
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
                <div class="infografis-card shadow rounded-xl p-5 text-center">
                    <h4 class="text-body">{{ $label }}</h4>
                    <p class="text-3xl font-bold">{{ $value ?? 0 }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
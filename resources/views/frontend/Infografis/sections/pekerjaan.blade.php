{{-- Section: Berdasarkan Pekerjaan --}}
<section class="py-8 sm:py-12 lg:py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-4 sm:mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold infografis-title mb-3 sm:mb-4 lg:mb-6">
                Berdasarkan Pekerjaan 
                <span id="tahun-display-pekerjaan" class="text-sm sm:text-base lg:text-lg text-primary-600 block sm:inline">
                    ({{ $tahunAktif ?? date('Y') }})
                </span>
            </h3>
        </div>

        

        <div id="pekerjaan-content" class="grid grid-cols-1 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">

            <div class="infografis-card rounded-xl shadow p-3 sm:p-4 lg:p-5 col-span-1">
                <div class="overflow-x-auto">
                    <table id="tabel-pekerjaan" class="w-full text-heading responsive-table">
                        <thead>
                            <tr class="bg-cyan-600 text-white">
                                <th class="p-2 sm:p-3 text-left text-sm">Jenis Pekerjaan</th>
                                <th class="p-2 sm:p-3 text-right text-sm">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Petani/Pekebun</td><td class="p-1 sm:p-2 text-right" data-field="petani">{{ $petani ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Belum/Tidak Bekerja</td><td class="p-1 sm:p-2 text-right" data-field="belum_bekerja">{{ $belum_bekerja ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Pelajar/Mahasiswa</td><td class="p-1 sm:p-2 text-right" data-field="pelajar_mahasiswa">{{ $pelajar_mahasiswa ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Mengurus Rumah Tangga</td><td class="p-1 sm:p-2 text-right" data-field="ibu_rumah_tangga">{{ $ibu_rumah_tangga ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Wiraswasta</td><td class="p-1 sm:p-2 text-right" data-field="wiraswasta">{{ $wiraswasta ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Karyawan Swasta</td><td class="p-1 sm:p-2 text-right" data-field="pegawai_swasta">{{ $pegawai_swasta ?? 0 }}</td></tr>
                            <tr><td class="p-1 sm:p-2 text-xs sm:text-sm mobile-wrap">Buruh Tani/Perkebunan</td><td class="p-1 sm:p-2 text-right" data-field="lainnya">{{ $lainnya ?? 0 }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-span-1 lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach([
                    'Petani/Pekebun' => $petani ?? 0,
                    'Belum/Tidak Bekerja' => $belum_bekerja ?? 0,
                    'Pelajar/Mahasiswa' => $pelajar_mahasiswa ?? 0,
                    'Mengurus Rumah Tangga' => $ibu_rumah_tangga ?? 0,
                    'Wiraswasta' => $wiraswasta ?? 0,
                    'Karyawan Swasta' => $pegawai_swasta ?? 0,
                    'Buruh Tani/Perkebunan' => $lainnya ?? 0,
                ] as $label => $value)
                <div class="infografis-card shadow rounded-lg p-4 sm:p-6 lg:p-8">
                    <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                        <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm lg:text-lg">{{ substr($label, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-gray-800 truncate">{{ $value }}</div>
                            <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate mobile-wrap">{{ $label }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>
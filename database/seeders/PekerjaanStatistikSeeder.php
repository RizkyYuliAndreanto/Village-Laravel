<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;

class PekerjaanStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus sesuai dengan total penduduk dari DemografiPendudukSeeder
        $pekerjaanData = [
            2020 => [
                'tidak_sekolah' => 85,         // 1%
                'petani' => 3400,              // 40%
                'pelajar_mahasiswa' => 1700,   // 20%
                'pegawai_swasta' => 1190,      // 14%
                'wiraswasta' => 850,           // 10%
                'ibu_rumah_tangga' => 850,     // 10%
                'belum_bekerja' => 340,        // 4%
                'lainnya' => 85,               // 1%
                // Total: 8500
            ],
            2021 => [
                'tidak_sekolah' => 87,         // 1%
                'petani' => 3460,              // 40%
                'pelajar_mahasiswa' => 1730,   // 20%
                'pegawai_swasta' => 1211,      // 14%
                'wiraswasta' => 865,           // 10%
                'ibu_rumah_tangga' => 865,     // 10%
                'belum_bekerja' => 346,        // 4%
                'lainnya' => 86,               // 1%
                // Total: 8650
            ],
            2022 => [
                'tidak_sekolah' => 88,         // 1%
                'petani' => 3528,              // 40%
                'pelajar_mahasiswa' => 1764,   // 20%
                'pegawai_swasta' => 1235,      // 14%
                'wiraswasta' => 882,           // 10%
                'ibu_rumah_tangga' => 882,     // 10%
                'belum_bekerja' => 353,        // 4%
                'lainnya' => 88,               // 1%
                // Total: 8820
            ],
            2023 => [
                'tidak_sekolah' => 90,         // 1%
                'petani' => 3600,              // 40%
                'pelajar_mahasiswa' => 1800,   // 20%
                'pegawai_swasta' => 1260,      // 14%
                'wiraswasta' => 900,           // 10%
                'ibu_rumah_tangga' => 900,     // 10%
                'belum_bekerja' => 360,        // 4%
                'lainnya' => 90,               // 1%
                // Total: 9000
            ],
            2024 => [
                'tidak_sekolah' => 92,         // 1%
                'petani' => 3680,              // 40%
                'pelajar_mahasiswa' => 1840,   // 20%
                'pegawai_swasta' => 1288,      // 14%
                'wiraswasta' => 920,           // 10%
                'ibu_rumah_tangga' => 920,     // 10%
                'belum_bekerja' => 368,        // 4%
                'lainnya' => 92,               // 1%
                // Total: 9200
            ],
        ];

        foreach ($pekerjaanData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                PekerjaanStatistik::create($data);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;

class WajibPilihStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus konsisten dengan DemografiPendudukSeeder
        // Wajib pilih = penduduk usia 17+ tahun (sekitar 70% dari total penduduk)
        $wajibPilihData = [
            2020 => [
                'laki_laki' => 2940,          // 70% dari 4200 L
                'perempuan' => 3010,          // 70% dari 4300 P
                'total' => 5950,              // 70% dari 8500
            ],
            2021 => [
                'laki_laki' => 2996,          // 70% dari 4280 L
                'perempuan' => 3059,          // 70% dari 4370 P
                'total' => 6055,              // 70% dari 8650
            ],
            2022 => [
                'laki_laki' => 3052,          // 70% dari 4360 L
                'perempuan' => 3122,          // 70% dari 4460 P
                'total' => 6174,              // 70% dari 8820
            ],
            2023 => [
                'laki_laki' => 3115,          // 70% dari 4450 L
                'perempuan' => 3185,          // 70% dari 4550 P
                'total' => 6300,              // 70% dari 9000
            ],
            2024 => [
                'laki_laki' => 3185,          // 70% dari 4550 L
                'perempuan' => 3255,          // 70% dari 4650 P
                'total' => 6440,              // 70% dari 9200
            ],
        ];

        foreach ($wajibPilihData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                WajibPilihStatistik::create($data);
            }
        }
    }
}

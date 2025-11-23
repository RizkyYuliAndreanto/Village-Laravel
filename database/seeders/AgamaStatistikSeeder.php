<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgamaStatistik;
use App\Models\TahunData;

class AgamaStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus sesuai dengan total penduduk dari DemografiPendudukSeeder
        $totalPendudukPerTahun = [
            2020 => 8500,
            2021 => 8650,
            2022 => 8820,
            2023 => 9000,
            2024 => 9200,
        ];

        $agamaData = [
            2020 => [
                'islam' => 7650,      // 90%
                'katolik' => 340,     // 4%
                'kristen' => 340,     // 4%
                'hindu' => 85,        // 1%
                'buddha' => 51,       // 0.6%
                'konghucu' => 17,     // 0.2%
                'kepercayaan_lain' => 17, // 0.2%
                // Total: 8500
            ],
            2021 => [
                'islam' => 7785,      // 90%
                'katolik' => 346,     // 4%
                'kristen' => 346,     // 4%
                'hindu' => 87,        // 1%
                'buddha' => 52,       // 0.6%
                'konghucu' => 17,     // 0.2%
                'kepercayaan_lain' => 17, // 0.2%
                // Total: 8650
            ],
            2022 => [
                'islam' => 7938,      // 90%
                'katolik' => 353,     // 4%
                'kristen' => 353,     // 4%
                'hindu' => 88,        // 1%
                'buddha' => 53,       // 0.6%
                'konghucu' => 18,     // 0.2%
                'kepercayaan_lain' => 17, // 0.2%
                // Total: 8820
            ],
            2023 => [
                'islam' => 8100,      // 90%
                'katolik' => 360,     // 4%
                'kristen' => 360,     // 4%
                'hindu' => 90,        // 1%
                'buddha' => 54,       // 0.6%
                'konghucu' => 18,     // 0.2%
                'kepercayaan_lain' => 18, // 0.2%
                // Total: 9000
            ],
            2024 => [
                'islam' => 8280,      // 90%
                'katolik' => 368,     // 4%
                'kristen' => 368,     // 4%
                'hindu' => 92,        // 1%
                'buddha' => 55,       // 0.6%
                'konghucu' => 19,     // 0.2%
                'kepercayaan_lain' => 18, // 0.2%
                // Total: 9200
            ],
        ];

        foreach ($agamaData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                AgamaStatistik::create($data);
            }
        }
    }
}

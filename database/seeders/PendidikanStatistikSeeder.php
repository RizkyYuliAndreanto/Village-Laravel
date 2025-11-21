<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;

class PendidikanStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus sesuai dengan total penduduk dari DemografiPendudukSeeder
        $pendidikanData = [
            2020 => [
                'tidak_sekolah' => 170,        // 2%
                'sd' => 2975,                  // 35%
                'smp' => 2380,                 // 28%
                'sma' => 2125,                 // 25%
                'd1_d4' => 595,                // 7%
                's1' => 230,                   // 2.7%
                's2' => 21,                    // 0.25%
                's3' => 4,                     // 0.05%
                // Total: 8500
            ],
            2021 => [
                'tidak_sekolah' => 173,        // 2%
                'sd' => 3028,                  // 35%
                'smp' => 2422,                 // 28%
                'sma' => 2163,                 // 25%
                'd1_d4' => 606,                // 7%
                's1' => 234,                   // 2.7%
                's2' => 21,                    // 0.25%
                's3' => 3,                     // 0.05%
                // Total: 8650
            ],
            2022 => [
                'tidak_sekolah' => 176,        // 2%
                'sd' => 3087,                  // 35%
                'smp' => 2470,                 // 28%
                'sma' => 2205,                 // 25%
                'd1_d4' => 617,                // 7%
                's1' => 238,                   // 2.7%
                's2' => 22,                    // 0.25%
                's3' => 5,                     // 0.05%
                // Total: 8820
            ],
            2023 => [
                'tidak_sekolah' => 180,        // 2%
                'sd' => 3150,                  // 35%
                'smp' => 2520,                 // 28%
                'sma' => 2250,                 // 25%
                'd1_d4' => 630,                // 7%
                's1' => 243,                   // 2.7%
                's2' => 23,                    // 0.25%
                's3' => 4,                     // 0.05%
                // Total: 9000
            ],
            2024 => [
                'tidak_sekolah' => 184,        // 2%
                'sd' => 3220,                  // 35%
                'smp' => 2576,                 // 28%
                'sma' => 2300,                 // 25%
                'd1_d4' => 644,                // 7%
                's1' => 248,                   // 2.7%
                's2' => 23,                    // 0.25%
                's3' => 5,                     // 0.05%
                // Total: 9200
            ],
        ];

        foreach ($pendidikanData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                PendidikanStatistik::create($data);
            }
        }
    }
}

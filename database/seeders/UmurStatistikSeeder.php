<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UmurStatistik;
use App\Models\TahunData;

class UmurStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus sesuai dengan total penduduk dari DemografiPendudukSeeder
        $umurData = [
            2020 => [
                'umur_0_4' => 765,             // 9%
                'umur_5_9' => 850,             // 10%
                'umur_10_14' => 850,           // 10%
                'umur_15_19' => 850,           // 10%
                'umur_20_24' => 850,           // 10%
                'umur_25_29' => 935,           // 11%
                'umur_30_34' => 935,           // 11%
                'umur_35_39' => 850,           // 10%
                'umur_40_44' => 765,           // 9%
                'umur_45_49' => 680,           // 8%
                'umur_50_plus' => 680,         // 8%
                // Total: 8500 (9+10+10+10+10+11+11+10+9+8+8 = 100%)
            ],
            2021 => [
                'umur_0_4' => 779,             // 9%
                'umur_5_9' => 865,             // 10%
                'umur_10_14' => 865,           // 10%
                'umur_15_19' => 865,           // 10%
                'umur_20_24' => 865,           // 10%
                'umur_50_plus' => 951,         // 11%
                'umur_30_34' => 951,           // 11%
                'umur_35_39' => 865,           // 10%
                'umur_40_44' => 779,           // 9%
                'umur_45_49' => 692,           // 8%
                'umur_25_29' => 692,           // 8%
                // Total: 8650
            ],
            2022 => [
                'umur_0_4' => 794,             // 9%
                'umur_5_9' => 882,             // 10%
                'umur_10_14' => 882,           // 10%
                'umur_15_19' => 882,           // 10%
                'umur_20_24' => 882,           // 10%
                'umur_25_29' => 970,           // 11%
                'umur_30_34' => 970,           // 11%
                'umur_35_39' => 882,           // 10%
                'umur_40_44' => 794,           // 9%
                'umur_45_49' => 706,           // 8%
                'umur_50_plus' => 706,         // 8%
                // Total: 8820
            ],
            2023 => [
                'umur_0_4' => 810,             // 9%
                'umur_5_9' => 900,             // 10%
                'umur_10_14' => 900,           // 10%
                'umur_15_19' => 900,           // 10%
                'umur_20_24' => 900,           // 10%
                'umur_25_29' => 990,           // 11%
                'umur_30_34' => 990,           // 11%
                'umur_35_39' => 900,           // 10%
                'umur_40_44' => 810,           // 9%
                'umur_45_49' => 720,           // 8%
                'umur_50_plus' => 720,         // 8%
                // Total: 9000
            ],
            2024 => [
                'umur_0_4' => 828,             // 9%
                'umur_5_9' => 920,             // 10%
                'umur_10_14' => 920,           // 10%
                'umur_15_19' => 920,           // 10%
                'umur_20_24' => 920,           // 10%
                'umur_25_29' => 1012,          // 11%
                'umur_30_34' => 1012,          // 11%
                'umur_35_39' => 920,           // 10%
                'umur_40_44' => 828,           // 9%
                'umur_45_49' => 736,           // 8%
                'umur_50_plus' => 736,         // 8%
                // Total: 9200
            ],
            2025 => [
                'umur_0_4' => 846,             // 9%
                'umur_5_9' => 940,             // 10%
                'umur_10_14' => 940,           // 10%
                'umur_15_19' => 940,           // 10%
                'umur_20_24' => 940,           // 10%
                'umur_25_29' => 1034,          // 11%
                'umur_30_34' => 1034,          // 11%
                'umur_35_39' => 940,           // 10%
                'umur_40_44' => 846,           // 9%
                'umur_45_49' => 752,           // 8%
                'umur_50_plus' => 752,         // 8%
                // Total: 9400
            ],
        ];

        foreach ($umurData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                UmurStatistik::updateOrCreate(
                    ['tahun_id' => $tahunIds[$tahun]],
                    $data
                );
            }
        }
    }
}

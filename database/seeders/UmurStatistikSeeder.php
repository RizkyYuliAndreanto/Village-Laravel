<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UmurStatistik;
use App\Models\TahunData;

class UmurStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            UmurStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'umur_0_4' => rand(200, 300),
                    'umur_5_9' => rand(200, 300),
                    'umur_10_14' => rand(250, 350),
                    'umur_15_19' => rand(250, 350),
                    'umur_20_24' => rand(200, 300),
                    'umur_25_29' => rand(200, 300),
                    'umur_30_34' => rand(200, 300),
                    'umur_35_39' => rand(200, 300),
                    'umur_40_44' => rand(200, 300),
                    'umur_45_49' => rand(150, 250),
                    'umur_50_plus' => rand(300, 500),
                ]
            );
        }
    }
}
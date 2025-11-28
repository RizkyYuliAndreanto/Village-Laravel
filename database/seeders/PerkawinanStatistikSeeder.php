<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerkawinanStatistik;
use App\Models\TahunData;

class PerkawinanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            PerkawinanStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'kawin' => rand(1500, 1800),
                    'cerai_hidup' => rand(50, 100),
                    'cerai_mati' => rand(100, 200),
                    'kawin_tercatat' => rand(1400, 1700),
                    'kawin_tidak_tercatat' => rand(10, 50),
                ]
            );
        }
    }
}
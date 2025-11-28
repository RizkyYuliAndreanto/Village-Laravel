<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;

class PendidikanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            PendidikanStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'tidak_sekolah' => rand(100, 200),
                    'sd' => rand(800, 1000),
                    'smp' => rand(600, 800),
                    'sma' => rand(500, 700),
                    'd1_d4' => rand(50, 150),
                    's1' => rand(200, 400),
                    's2' => rand(10, 50),
                    's3' => rand(1, 10),
                ]
            );
        }
    }
}
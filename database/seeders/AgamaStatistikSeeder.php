<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgamaStatistik;
use App\Models\TahunData;

class AgamaStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            AgamaStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'islam' => rand(2500, 2800),
                    'kristen' => rand(100, 200),
                    'katolik' => rand(50, 100),
                    'hindu' => rand(10, 50),
                    'buddha' => rand(5, 20),
                    'konghucu' => rand(1, 5),
                    'kepercayaan_lain' => rand(0, 5),
                ]
            );
        }
    }
}
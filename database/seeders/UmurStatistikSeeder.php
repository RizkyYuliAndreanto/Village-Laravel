<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UmurStatistik;
use App\Models\TahunData;

class UmurStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UmurStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        if ($tahun2024) {
            UmurStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'umur_0_4' => 150,
                'umur_5_9' => 160,
                'umur_10_14' => 170,
                'umur_15_19' => 165,
                'umur_20_24' => 155,
                'umur_25_29' => 145,
                'umur_30_34' => 135,
                'umur_35_39' => 125,
                'umur_40_44' => 115,
                'umur_45_49' => 105,
                'umur_50_plus' => 75,
            ]);
        }
        
        if ($tahun2023) {
            UmurStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'umur_0_4' => 145,
                'umur_5_9' => 155,
                'umur_10_14' => 165,
                'umur_15_19' => 160,
                'umur_20_24' => 150,
                'umur_25_29' => 140,
                'umur_30_34' => 130,
                'umur_35_39' => 120,
                'umur_40_44' => 110,
                'umur_45_49' => 100,
                'umur_50_plus' => 75,
            ]);
        }
    }
}
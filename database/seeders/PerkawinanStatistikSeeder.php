<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerkawinanStatistik;
use App\Models\TahunData;

class PerkawinanStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PerkawinanStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        if ($tahun2024) {
            PerkawinanStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'kawin' => 1000,
                'cerai_hidup' => 50,
                'cerai_mati' => 30,
                'kawin_tercatat' => 950,
                'kawin_tidak_tercatat' => 50,
            ]);
        }
        
        if ($tahun2023) {
            PerkawinanStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'kawin' => 980,
                'cerai_hidup' => 45,
                'cerai_mati' => 28,
                'kawin_tercatat' => 930,
                'kawin_tidak_tercatat' => 50,
            ]);
        }
    }
}
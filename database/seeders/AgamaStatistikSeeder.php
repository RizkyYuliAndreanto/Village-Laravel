<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgamaStatistik;
use App\Models\TahunData;

class AgamaStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AgamaStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // Data untuk 2024
        if ($tahun2024) {
            AgamaStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'islam' => 1480,
                'katolik' => 5,
                'kristen' => 10,
                'hindu' => 2,
                'buddha' => 1,
                'konghucu' => 0,
                'kepercayaan_lain' => 2,
            ]);
        }
        
        // Data untuk 2023
        if ($tahun2023) {
            AgamaStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'islam' => 1430,
                'katolik' => 5,
                'kristen' => 10,
                'hindu' => 2,
                'buddha' => 1,
                'konghucu' => 0,
                'kepercayaan_lain' => 2,
            ]);
        }
    }
}
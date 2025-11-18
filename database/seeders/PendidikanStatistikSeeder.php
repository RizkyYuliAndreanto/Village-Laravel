<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;

class PendidikanStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PendidikanStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        if ($tahun2024) {
            PendidikanStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'tidak_sekolah' => 100,
                'sd' => 500,
                'smp' => 300,
                'sma' => 400,
                'd1_d4' => 50,
                's1' => 130,
                's2' => 15,
                's3' => 5,
            ]);
        }

        if ($tahun2023) {
            PendidikanStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'tidak_sekolah' => 110,
                'sd' => 490,
                'smp' => 290,
                'sma' => 380,
                'd1_d4' => 45,
                's1' => 120,
                's2' => 10,
                's3' => 5,
            ]);
        }
    }
}
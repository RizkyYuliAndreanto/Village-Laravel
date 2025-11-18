<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;

class WajibPilihStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WajibPilihStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        if ($tahun2024) {
            WajibPilihStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'laki_laki' => 550,
                'perempuan' => 560,
                'total' => 1110, // 550 + 560
            ]);
        }
        
        if ($tahun2023) {
            WajibPilihStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'laki_laki' => 530,
                'perempuan' => 540,
                'total' => 1070, // 530 + 540
            ]);
        }
    }
}
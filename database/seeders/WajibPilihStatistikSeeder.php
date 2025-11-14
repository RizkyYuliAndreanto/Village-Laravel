<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WajibPilihStatistik;

class WajibPilihStatistikSeeder extends Seeder
{
    public function run(): void
    {
        WajibPilihStatistik::create([
            'tahun_id'   => 1, // 2023
            'laki_laki'  => 760,
            'perempuan'  => 768,
            'total'      => 1528,
        ]);

        WajibPilihStatistik::create([
            'tahun_id'   => 2, // 2024
            'laki_laki'  => 779,
            'perempuan'  => 786,
            'total'      => 1565,
        ]);

        WajibPilihStatistik::create([
            'tahun_id'   => 3, // 2025
            'laki_laki'  => 798,
            'perempuan'  => 801,
            'total'      => 1599,
        ]);
    }
}

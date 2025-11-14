<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PerkawinanStatistik;

class PerkawinanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        PerkawinanStatistik::create([
            'tahun_id'             => 1, // 2023
            'kawin'                => 874,
            'cerai_hidup'          => 0,
            'cerai_mati'           => 36,
            'kawin_tercatat'       => 0,
            'kawin_tidak_tercatat' => 0,
        ]);

        PerkawinanStatistik::create([
            'tahun_id'             => 2, // 2024
            'kawin'                => 880,
            'cerai_hidup'          => 1,
            'cerai_mati'           => 39,
            'kawin_tercatat'       => 0,
            'kawin_tidak_tercatat' => 0,
        ]);

        PerkawinanStatistik::create([
            'tahun_id'             => 3, // 2025
            'kawin'                => 890,
            'cerai_hidup'          => 1,
            'cerai_mati'           => 41,
            'kawin_tercatat'       => 0,
            'kawin_tidak_tercatat' => 0,
        ]);
    }
}

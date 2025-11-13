<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmurSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua id tahun dari tabel tahun_data
        $tahunList = DB::table('tahun_data')->pluck('id_tahun');

        foreach ($tahunList as $tahunId) {
            DB::table('umur_statistik')->insert([
                'tahun_id' => $tahunId,

                // Data realistis: usia muda lebih banyak, usia tua makin sedikit
                'umur_0_4'   => rand(80, 150),
                'umur_5_9'   => rand(90, 160),
                'umur_10_14' => rand(100, 170),
                'umur_15_19' => rand(110, 180),
                'umur_20_24' => rand(100, 160),
                'umur_25_29' => rand(90, 150),
                'umur_30_34' => rand(80, 130),
                'umur_35_39' => rand(70, 120),
                'umur_40_44' => rand(60, 100),
                'umur_45_49' => rand(40, 80),
                'umur_50_plus' => rand(30, 60),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

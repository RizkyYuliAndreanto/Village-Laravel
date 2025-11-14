<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendidikanStatistik;

class PendidikanStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PendidikanStatistik::create([
            'tahun_id'        => 1,   // sesuaikan dengan id_tahun yg ada
            'tidak_sekolah'   => 393,
            'sd'              => 520,
            'smp'             => 128,
            'sma'             => 84,
            'd1_d4'           => 4,
            's1'              => 1,
            's2'              => 2,
            's3'              => 0,
        ]);
    }
}

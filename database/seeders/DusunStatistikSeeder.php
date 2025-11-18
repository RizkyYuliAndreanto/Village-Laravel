<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DusunStatistik;
use App\Models\TahunData;

class DusunStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DusunStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // --- Data Dusun untuk 2024 ---
        if ($tahun2024) {
            DusunStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'nama_dusun' => 'Krajan',
                'jumlah_penduduk' => 500,
                'jumlah_kk' => 150,
            ]);
            DusunStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'nama_dusun' => 'Wates',
                'jumlah_penduduk' => 450,
                'jumlah_kk' => 130,
            ]);
            DusunStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'nama_dusun' => 'Sawahan',
                'jumlah_penduduk' => 550,
                'jumlah_kk' => 160,
            ]);
        }
        
        // --- Data Dusun untuk 2023 ---
        if ($tahun2023) {
            DusunStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'nama_dusun' => 'Krajan',
                'jumlah_penduduk' => 480,
                'jumlah_kk' => 145,
            ]);
            DusunStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'nama_dusun' => 'Wates',
                'jumlah_penduduk' => 440,
                'jumlah_kk' => 125,
            ]);
            DusunStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'nama_dusun' => 'Sawahan',
                'jumlah_penduduk' => 530,
                'jumlah_kk' => 155,
            ]);
        }
    }
}
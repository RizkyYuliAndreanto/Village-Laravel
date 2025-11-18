<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;

class PekerjaanStatistikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PekerjaanStatistik::query()->delete();

        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // Data untuk 2024
        if ($tahun2024) {
            PekerjaanStatistik::create([
                'tahun_id' => $tahun2024->id_tahun,
                'tidak_sekolah' => 50,
                'petani' => 600,
                'pelajar_mahasiswa' => 250,
                'pegawai_swasta' => 150,
                'wiraswasta' => 200,
                'ibu_rumah_tangga' => 150,
                'belum_bekerja' => 80,
                'lainnya' => 20,
            ]);
        }
        
        // Data untuk 2023
        if ($tahun2023) {
            PekerjaanStatistik::create([
                'tahun_id' => $tahun2023->id_tahun,
                'tidak_sekolah' => 55,
                'petani' => 580,
                'pelajar_mahasiswa' => 240,
                'pegawai_swasta' => 140,
                'wiraswasta' => 190,
                'ibu_rumah_tangga' => 145,
                'belum_bekerja' => 80,
                'lainnya' => 20,
            ]);
        }
    }
}
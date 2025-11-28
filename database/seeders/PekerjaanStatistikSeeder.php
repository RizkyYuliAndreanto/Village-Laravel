<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;

class PekerjaanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            PekerjaanStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'tidak_sekolah' => rand(100, 200),
                    'petani' => rand(800, 1000),
                    'pelajar_mahasiswa' => rand(500, 700),
                    'pegawai_swasta' => rand(300, 500),
                    'wiraswasta' => rand(200, 400),
                    'ibu_rumah_tangga' => rand(400, 600),
                    'belum_bekerja' => rand(100, 200),
                    'lainnya' => rand(50, 150),
                ]
            );
        }
    }
}
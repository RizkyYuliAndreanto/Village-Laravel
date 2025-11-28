<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DusunStatistik;
use App\Models\TahunData;

class DusunStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();
        $namaDusun = ['Dusun Krajan', 'Dusun Timur', 'Dusun Barat', 'Dusun Selatan'];

        foreach ($years as $yearData) {
            foreach ($namaDusun as $dusun) {
                DusunStatistik::updateOrCreate(
                    [
                        'tahun_id' => $yearData->id_tahun,
                        'nama_dusun' => $dusun
                    ],
                    [
                        'jumlah_penduduk' => rand(500, 900),
                        'jumlah_kk' => rand(150, 300),
                        'keterangan' => 'Data statistik wilayah ' . $dusun
                    ]
                );
            }
        }
    }
}
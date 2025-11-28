<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;

class DemografiPendudukSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            // Simulasi kenaikan penduduk setiap tahun
            $basePop = 3000 + (($yearData->tahun - 2020) * 50); 
            
            $laki = rand(floor($basePop / 2) - 50, floor($basePop / 2) + 50);
            $perempuan = $basePop - $laki;

            DemografiPenduduk::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'total_penduduk' => $basePop,
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    'penduduk_sementara' => rand(10, 50),
                    'mutasi_penduduk' => rand(5, 25),
                ]
            );
        }
    }
}
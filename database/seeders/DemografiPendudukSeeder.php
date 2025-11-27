<?php

namespace Database\Seeders;

use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class DemografiPendudukSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua tahun (2020-2025)
        $years = TahunData::orderBy('tahun', 'asc')->get();

        // Base data tahun 2020
        $basePenduduk = 3500;
        $baseKK = 1200;

        foreach ($years as $index => $tahunData) {
            // Simulasi pertumbuhan penduduk ~2% per tahun
            $multiplier = 1 + ($index * 0.02); 
            
            $totalPenduduk = floor($basePenduduk * $multiplier);
            $totalKK = floor($baseKK * $multiplier);
            
            // Rasio Laki-laki ~51%, Perempuan ~49%
            $laki = floor($totalPenduduk * 0.51);
            $perempuan = $totalPenduduk - $laki;

            DemografiPenduduk::updateOrCreate(
                ['tahun_id' => $tahunData->id_tahun],
                [
                    'total_penduduk' => $totalPenduduk,
                    'jumlah_kk' => $totalKK,
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    // Data mutasi fluktuatif
                    'kelahiran' => rand(40, 60),
                    'kematian' => rand(20, 40),
                    'pindah_masuk' => rand(10, 30),
                    'pindah_keluar' => rand(15, 35),
                ]
            );
        }
    }
}
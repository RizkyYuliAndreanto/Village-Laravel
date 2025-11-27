<?php

namespace Database\Seeders;

use App\Models\DusunStatistik;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class DusunStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::orderBy('tahun', 'asc')->get();
        
        // Daftar Dusun
        $dusuns = [
            ['nama' => 'Dusun Krajan', 'porsi' => 0.4], // 40% penduduk
            ['nama' => 'Dusun Melati', 'porsi' => 0.35], // 35% penduduk
            ['nama' => 'Dusun Mawar', 'porsi' => 0.25], // 25% penduduk
        ];

        // Base total penduduk (harus mirip dengan Demografi)
        $baseTotal = 3500;

        foreach ($years as $index => $tahunData) {
            $multiplier = 1 + ($index * 0.02);
            $totalTahunIni = $baseTotal * $multiplier;

            foreach ($dusuns as $dusun) {
                // Hitung penduduk per dusun
                $jumlahPenduduk = floor($totalTahunIni * $dusun['porsi']);
                $jumlahLaki = floor($jumlahPenduduk * 0.51);
                $jumlahPerempuan = $jumlahPenduduk - $jumlahLaki;
                $jumlahKK = floor($jumlahPenduduk / 3.5); // Asumsi 1 KK rata-rata 3-4 orang

                DusunStatistik::updateOrCreate(
                    [
                        'tahun_id' => $tahunData->id_tahun,
                        'nama_dusun' => $dusun['nama'],
                    ],
                    [
                        'ketua_dusun' => 'Bapak ' . fake()->name('male'), // Opsional pakai faker
                        'jumlah_kk' => $jumlahKK,
                        'jumlah_laki' => $jumlahLaki,
                        'jumlah_perempuan' => $jumlahPerempuan,
                        'total_penduduk' => $jumlahPenduduk,
                    ]
                );
            }
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;

class DetailApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $laporans = LaporanApbdes::all();

        foreach ($laporans as $laporan) {
            // Data Pendapatan
            DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'tipe' => 'pendapatan',
                'uraian' => 'Pendapatan Asli Desa (PAD)',
                'anggaran' => 150000000,
                'realisasi' => 145000000,
            ]);
            
            DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'tipe' => 'pendapatan',
                'uraian' => 'Dana Desa',
                'anggaran' => 800000000,
                'realisasi' => 800000000,
            ]);

            // Data Belanja
            DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'tipe' => 'belanja',
                'uraian' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'anggaran' => 350000000,
                'realisasi' => 340000000,
            ]);
            
            DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'tipe' => 'belanja',
                'uraian' => 'Bidang Pelaksanaan Pembangunan Desa',
                'anggaran' => 450000000,
                'realisasi' => 400000000,
            ]);

             // Pembiayaan
             DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'tipe' => 'pembiayaan',
                'uraian' => 'Sisa Lebih Perhitungan Anggaran (SiLPA)',
                'anggaran' => 50000000,
                'realisasi' => 50000000,
            ]);
        }
    }
}
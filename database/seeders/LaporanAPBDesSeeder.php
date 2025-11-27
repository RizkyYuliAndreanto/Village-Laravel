<?php

namespace Database\Seeders;

use App\Models\LaporanApbdes;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class LaporanAPBDesSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua tahun dari 2020-2025
        $allYears = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($allYears as $tahunData) {
            LaporanApbdes::updateOrCreate(
                [
                    'tahun_id' => $tahunData->id_tahun,
                    'nama_laporan' => 'APBDes Murni T.A. ' . $tahunData->tahun,
                ],
                [
                    'bulan_rilis' => 1, // Januari
                    'status' => 'diterbitkan', // Wajib published
                    'deskripsi' => "Laporan Realisasi Anggaran Pendapatan dan Belanja Desa Tahun {$tahunData->tahun}",
                ]
            );
        }
    }
}
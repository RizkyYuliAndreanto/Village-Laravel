<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LaporanApbdes;
use App\Models\TahunData;

class LaporanApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            // Laporan Murni (Awal Tahun)
            LaporanApbdes::updateOrCreate(
                [
                    'tahun_id' => $yearData->id_tahun,
                    'nama_laporan' => "APBDes Murni Tahun " . $yearData->tahun
                ],
                [
                    'bulan_rilis' => 1,
                    'deskripsi' => "Laporan Anggaran Pendapatan dan Belanja Desa Awal Tahun " . $yearData->tahun,
                    'status' => 'diterbitkan'
                ]
            );

            // Laporan Perubahan (Hanya untuk tahun yang sudah berlalu atau berjalan)
            if ($yearData->tahun <= 2024) {
                LaporanApbdes::updateOrCreate(
                    [
                        'tahun_id' => $yearData->id_tahun,
                        'nama_laporan' => "APBDes Perubahan Tahun " . $yearData->tahun
                    ],
                    [
                        'bulan_rilis' => 10,
                        'deskripsi' => "Laporan Perubahan Anggaran Tahun " . $yearData->tahun,
                        'status' => 'diterbitkan'
                    ]
                );
            }
        }
    }
}
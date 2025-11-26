<?php

namespace Database\Seeders;

use App\Models\LaporanApbdes;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class LaporanApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $tahunSekarang = date('Y');

        // 1. Pastikan data Tahun ada
        $tahun = TahunData::firstOrCreate(
            ['tahun' => $tahunSekarang],
            ['keterangan' => 'Tahun Anggaran ' . $tahunSekarang]
        );

        // 2. Buat/Update Laporan APBDes
        // Kita gunakan updateOrCreate agar jika data sudah ada (misal statusnya draft),
        // akan di-update menjadi 'diterbitkan'
        $laporan = LaporanApbdes::updateOrCreate(
            [
                'tahun_id' => $tahun->id_tahun, 
                'nama_laporan' => 'APBDes Tahun Anggaran ' . $tahunSekarang,
            ],
            [
                'bulan_rilis' => 1, 
                'status' => 'diterbitkan', // PENTING: Harus diterbitkan agar muncul di Home
                'deskripsi' => 'Anggaran Pendapatan dan Belanja Desa Murni', 
            ]
        );
        
        $this->command->info('Laporan APBDes berhasil dibuat/diupdate dengan status: ' . $laporan->status);
    }
}
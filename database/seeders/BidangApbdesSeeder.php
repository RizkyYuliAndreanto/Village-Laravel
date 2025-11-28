<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BidangApbdes;

class BidangApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Pendapatan
            ['kode_bidang' => 'PD01', 'nama_bidang' => 'Pendapatan Asli Desa', 'kategori' => 'pendapatan', 'urutan' => 1],
            ['kode_bidang' => 'PD02', 'nama_bidang' => 'Dana Desa', 'kategori' => 'pendapatan', 'urutan' => 2],
            ['kode_bidang' => 'PD03', 'nama_bidang' => 'Bagi Hasil Pajak & Retribusi', 'kategori' => 'pendapatan', 'urutan' => 3],
            
            // Belanja
            ['kode_bidang' => 'BL01', 'nama_bidang' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'kategori' => 'belanja', 'urutan' => 1],
            ['kode_bidang' => 'BL02', 'nama_bidang' => 'Bidang Pelaksanaan Pembangunan Desa', 'kategori' => 'belanja', 'urutan' => 2],
            ['kode_bidang' => 'BL03', 'nama_bidang' => 'Bidang Pembinaan Kemasyarakatan', 'kategori' => 'belanja', 'urutan' => 3],
            ['kode_bidang' => 'BL04', 'nama_bidang' => 'Bidang Pemberdayaan Masyarakat', 'kategori' => 'belanja', 'urutan' => 4],
            ['kode_bidang' => 'BL05', 'nama_bidang' => 'Bidang Penanggulangan Bencana', 'kategori' => 'belanja', 'urutan' => 5],
        ];

        foreach ($data as $item) {
            BidangApbdes::updateOrCreate(
                ['kode_bidang' => $item['kode_bidang']],
                $item
            );
        }
    }
}
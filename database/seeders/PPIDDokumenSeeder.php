<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidDokumen;

class PpidDokumenSeeder extends Seeder
{
    public function run(): void
    {
        PpidDokumen::create([
            'judul_dokumen' => 'Peraturan Desa No 1 Tahun 2024',
            'file_url' => 'dokumen/perdes_01_2024.pdf',
            'kategori' => 'informasi berkala',
            'tahun' => 2024,
            'tanggal_upload' => now(),
            'uploader' => 'Admin Desa'
        ]);
        
        PpidDokumen::create([
            'judul_dokumen' => 'Laporan Pertanggungjawaban 2023',
            'file_url' => 'dokumen/lpj_2023.pdf',
            'kategori' => 'informasi setiap saat',
            'tahun' => 2023,
            'tanggal_upload' => now(),
            'uploader' => 'Sekdes'
        ]);
    }
}
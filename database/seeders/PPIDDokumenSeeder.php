<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpidDokumen;

class PpidDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PpidDokumen::query()->delete();

        PpidDokumen::create([
            'judul_dokumen' => 'Laporan APBDes 2023',
            'file_url' => 'dokumen/ppid/apbdes-2023.pdf',
            'kategori' => PpidDokumen::KATEGORI_BERKALA,
            'tahun' => 2023,
            'tanggal_upload' => '2024-01-10',
            'uploader' => 'Admin Desa',
        ]);

        PpidDokumen::create([
            'judul_dokumen' => 'Rencana Kerja Pemerintah Desa (RKPDes) 2024',
            'file_url' => 'dokumen/ppid/rkpdes-2024.pdf',
            'kategori' => PpidDokumen::KATEGORI_SETIAP_SAAT,
            'tahun' => 2024,
            'tanggal_upload' => '2024-01-15',
            'uploader' => 'Admin Desa',
        ]);

        PpidDokumen::create([
            'judul_dokumen' => 'Informasi Bencana Alam',
            'file_url' => 'dokumen/ppid/info-bencana.pdf',
            'kategori' => PpidDokumen::KATEGORI_SERTAMERTA,
            'tahun' => 2024,
            'tanggal_upload' => '2024-03-20',
            'uploader' => 'Admin Desa',
        ]);
    }
}
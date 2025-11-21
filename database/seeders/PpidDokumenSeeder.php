<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PpidDokumen;

class PpidDokumenSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokumenData = [
            // Informasi Berkala
            [
                'judul_dokumen' => 'Laporan Penyelenggaraan Pemerintahan Desa 2024',
                'file_url' => 'ppid/berkala/lppd-2024.pdf',
                'kategori' => PpidDokumen::KATEGORI_BERKALA,
                'tahun' => 2024,
                'tanggal_upload' => '2024-01-15',
                'uploader' => 'Sekretaris Desa',
            ],
            [
                'judul_dokumen' => 'Laporan Realisasi Pelaksanaan APBDes 2024',
                'file_url' => 'ppid/berkala/realisasi-apbdes-2024.pdf',
                'kategori' => PpidDokumen::KATEGORI_BERKALA,
                'tahun' => 2024,
                'tanggal_upload' => '2024-02-10',
                'uploader' => 'Kaur Keuangan',
            ],
            [
                'judul_dokumen' => 'Laporan Keterangan Pertanggungjawaban Kepala Desa 2023',
                'file_url' => 'ppid/berkala/lkpj-kades-2023.pdf',
                'kategori' => PpidDokumen::KATEGORI_BERKALA,
                'tahun' => 2023,
                'tanggal_upload' => '2024-01-05',
                'uploader' => 'Kepala Desa',
            ],

            // Informasi Sertamerta
            [
                'judul_dokumen' => 'Pengumuman Bantuan Langsung Tunai Desa',
                'file_url' => 'ppid/sertamerta/pengumuman-blt.pdf',
                'kategori' => PpidDokumen::KATEGORI_SERTAMERTA,
                'tahun' => 2024,
                'tanggal_upload' => '2024-03-20',
                'uploader' => 'Kasi Kesejahteraan',
            ],
            [
                'judul_dokumen' => 'Keputusan Kepala Desa tentang Tim Relawan COVID-19',
                'file_url' => 'ppid/sertamerta/sk-relawan-covid.pdf',
                'kategori' => PpidDokumen::KATEGORI_SERTAMERTA,
                'tahun' => 2024,
                'tanggal_upload' => '2024-02-15',
                'uploader' => 'Kepala Desa',
            ],

            // Informasi Setiap Saat
            [
                'judul_dokumen' => 'Peraturan Desa tentang APBDes 2024',
                'file_url' => 'ppid/setiap-saat/perdes-apbdes-2024.pdf',
                'kategori' => PpidDokumen::KATEGORI_SETIAP_SAAT,
                'tahun' => 2024,
                'tanggal_upload' => '2023-12-30',
                'uploader' => 'Sekretaris Desa',
            ],
            [
                'judul_dokumen' => 'Peraturan Desa tentang Organisasi dan Tata Kerja',
                'file_url' => 'ppid/setiap-saat/perdes-sotk.pdf',
                'kategori' => PpidDokumen::KATEGORI_SETIAP_SAAT,
                'tahun' => 2024,
                'tanggal_upload' => '2024-01-10',
                'uploader' => 'Sekretaris Desa',
            ],
            [
                'judul_dokumen' => 'Rencana Kerja Pemerintah Desa 2024',
                'file_url' => 'ppid/setiap-saat/rkpdes-2024.pdf',
                'kategori' => PpidDokumen::KATEGORI_SETIAP_SAAT,
                'tahun' => 2024,
                'tanggal_upload' => '2023-11-25',
                'uploader' => 'Kaur Pembangunan',
            ],
            [
                'judul_dokumen' => 'Rencana Pembangunan Jangka Menengah Desa 2020-2025',
                'file_url' => 'ppid/setiap-saat/rpjmdes-2020-2025.pdf',
                'kategori' => PpidDokumen::KATEGORI_SETIAP_SAAT,
                'tahun' => 2020,
                'tanggal_upload' => '2023-10-15',
                'uploader' => 'Kaur Pembangunan',
            ],

            // Informasi Dikecualikan
            [
                'judul_dokumen' => 'Daftar Informasi yang Dikecualikan',
                'file_url' => 'ppid/dikecualikan/daftar-info-dikecualikan.pdf',
                'kategori' => PpidDokumen::KATEGORI_DIKECUALIKAN,
                'tahun' => 2024,
                'tanggal_upload' => '2024-01-01',
                'uploader' => 'Pejabat PPID',
            ],
        ];

        foreach ($dokumenData as $data) {
            PpidDokumen::create($data);
        }
    }
}

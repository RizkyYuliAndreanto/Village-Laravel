<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidDokumen;
use Carbon\Carbon;

class PpidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokumenData = [
            // Informasi Berkala
            [
                'judul_dokumen' => 'Laporan Keuangan Desa Tahun 2024',
                'file_url' => 'storage/ppid/laporan-keuangan-2024.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(10),
                'uploader' => 'Bendahara Desa'
            ],
            [
                'judul_dokumen' => 'Rencana Kerja Pemerintah Desa (RKPDesa) 2024',
                'file_url' => 'storage/ppid/rkpdesa-2024.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(20),
                'uploader' => 'Sekretaris Desa'
            ],
            [
                'judul_dokumen' => 'Laporan Penyelenggaraan Pemerintahan Desa (LPPD) 2023',
                'file_url' => 'storage/ppid/lppd-2023.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2023,
                'tanggal_upload' => Carbon::now()->subDays(90),
                'uploader' => 'Kepala Desa'
            ],
            [
                'judul_dokumen' => 'Anggaran Pendapatan dan Belanja Desa (APBDesa) 2024',
                'file_url' => 'storage/ppid/apbdesa-2024.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(30),
                'uploader' => 'Bendahara Desa'
            ],

            // Informasi Sertamerta
            [
                'judul_dokumen' => 'Pengumuman Penting - Pemadaman Listrik Terjadwal',
                'file_url' => 'storage/ppid/pengumuman-listrik.pdf',
                'kategori' => 'informasi_sertamerta',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(2),
                'uploader' => 'Kepala Desa'
            ],
            [
                'judul_dokumen' => 'Peringatan Dini - Potensi Banjir Musim Hujan',
                'file_url' => 'storage/ppid/peringatan-banjir.pdf',
                'kategori' => 'informasi_sertamerta',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(5),
                'uploader' => 'Kepala Desa'
            ],
            [
                'judul_dokumen' => 'Pengumuman Darurat - Penutupan Jalan Utama',
                'file_url' => 'storage/ppid/penutupan-jalan.pdf',
                'kategori' => 'informasi_sertamerta',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(7),
                'uploader' => 'Kepala Desa'
            ],

            // Informasi Setiap Saat
            [
                'judul_dokumen' => 'Struktur Organisasi Pemerintah Desa',
                'file_url' => 'storage/ppid/struktur-organisasi.pdf',
                'kategori' => 'informasi_setiap_saat',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(60),
                'uploader' => 'Sekretaris Desa'
            ],
            [
                'judul_dokumen' => 'Profil Desa dan Potensi Wilayah',
                'file_url' => 'storage/ppid/profil-desa.pdf',
                'kategori' => 'informasi_setiap_saat',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(45),
                'uploader' => 'Kepala Desa'
            ],
            [
                'judul_dokumen' => 'Prosedur Pelayanan Administrasi Kependudukan',
                'file_url' => 'storage/ppid/prosedur-adminduk.pdf',
                'kategori' => 'informasi_setiap_saat',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(15),
                'uploader' => 'Kaur Pemerintahan'
            ],
            [
                'judul_dokumen' => 'Peraturan Desa tentang Retribusi Pelayanan',
                'file_url' => 'storage/ppid/perdes-retribusi.pdf',
                'kategori' => 'informasi_setiap_saat',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(25),
                'uploader' => 'Sekretaris Desa'
            ],

            // Informasi Dikecualikan
            [
                'judul_dokumen' => 'Dokumen Rahasia - Akses Terbatas',
                'file_url' => 'storage/ppid/dokumen-rahasia.pdf',
                'kategori' => 'informasi_dikecualikan',
                'tahun' => 2024,
                'tanggal_upload' => Carbon::now()->subDays(50),
                'uploader' => 'PPID Desa'
            ],

            // Data tahun sebelumnya
            [
                'judul_dokumen' => 'Laporan Keuangan Desa Tahun 2023',
                'file_url' => 'storage/ppid/laporan-keuangan-2023.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2023,
                'tanggal_upload' => Carbon::now()->subDays(365),
                'uploader' => 'Bendahara Desa'
            ],
            [
                'judul_dokumen' => 'APBDesa 2023 - Laporan Realisasi',
                'file_url' => 'storage/ppid/apbdesa-realisasi-2023.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2023,
                'tanggal_upload' => Carbon::now()->subDays(300),
                'uploader' => 'Bendahara Desa'
            ],
            [
                'judul_dokumen' => 'Profil Desa Tahun 2023',
                'file_url' => 'storage/ppid/profil-desa-2023.pdf',
                'kategori' => 'informasi_setiap_saat',
                'tahun' => 2023,
                'tanggal_upload' => Carbon::now()->subDays(400),
                'uploader' => 'Kepala Desa'
            ],

            // Data 2022
            [
                'judul_dokumen' => 'Laporan Keuangan Desa Tahun 2022',
                'file_url' => 'storage/ppid/laporan-keuangan-2022.pdf',
                'kategori' => 'informasi_berkala',
                'tahun' => 2022,
                'tanggal_upload' => Carbon::now()->subDays(730),
                'uploader' => 'Bendahara Desa'
            ]
        ];

        foreach ($dokumenData as $data) {
            PpidDokumen::create($data);
        }

        $this->command->info('PPID Dokumen sample data berhasil ditambahkan!');
    }
}
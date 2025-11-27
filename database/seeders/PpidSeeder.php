<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpidDokumen;
use Carbon\Carbon;

class PpidSeeder extends Seeder
{
    public function run(): void
    {
        $years = range(2020, 2025);

        foreach ($years as $year) {
            
            // --- 1. INFORMASI BERKALA (Wajib ada tiap tahun) ---
            
            // APBDes Murni
            PpidDokumen::updateOrCreate(
                [
                    'judul_dokumen' => "Dokumen APBDes Tahun Anggaran $year",
                    'tahun' => $year,
                ],
                [
                    'file_url' => "storage/ppid/apbdes-$year.pdf",
                    'kategori' => 'informasi berkala', // Sesuaikan dengan Model constant
                    'tanggal_upload' => Carbon::create($year, 1, 15),
                    'uploader' => 'Sekretaris Desa',
                ]
            );

            // Laporan Realisasi (Biasanya di akhir tahun / awal tahun depan)
            PpidDokumen::updateOrCreate(
                [
                    'judul_dokumen' => "Laporan Realisasi APBDes Tahun $year",
                    'tahun' => $year,
                ],
                [
                    'file_url' => "storage/ppid/realisasi-apbdes-$year.pdf",
                    'kategori' => 'informasi berkala',
                    'tanggal_upload' => Carbon::create($year, 12, 31),
                    'uploader' => 'Kaur Keuangan',
                ]
            );

            // LPPD
            PpidDokumen::updateOrCreate(
                [
                    'judul_dokumen' => "Laporan Penyelenggaraan Pemerintahan Desa (LPPD) Akhir Tahun $year",
                    'tahun' => $year,
                ],
                [
                    'file_url' => "storage/ppid/lppd-$year.pdf",
                    'kategori' => 'informasi berkala',
                    'tanggal_upload' => Carbon::create($year + 1, 3, 30), // Diupload tahun depannya
                    'uploader' => 'Kepala Desa',
                ]
            );


            // --- 2. INFORMASI SETIAP SAAT (Update jika perlu) ---
            
            // Profil Desa (Update berkala setiap 2 tahun sekali misal)
            if ($year % 2 == 0) {
                PpidDokumen::updateOrCreate(
                    [
                        'judul_dokumen' => "Profil Desa Update Tahun $year",
                        'tahun' => $year,
                    ],
                    [
                        'file_url' => "storage/ppid/profil-desa-$year.pdf",
                        'kategori' => 'informasi setiap saat',
                        'tanggal_upload' => Carbon::create($year, 6, 1),
                        'uploader' => 'Kasi Pemerintahan',
                    ]
                );
            }

            // Perdes (Acak)
            if (rand(0, 1)) {
                PpidDokumen::updateOrCreate(
                    [
                        'judul_dokumen' => "Peraturan Desa No. " . rand(1,5) . " Tahun $year tentang Pungutan Desa",
                        'tahun' => $year,
                    ],
                    [
                        'file_url' => "storage/ppid/perdes-pungutan-$year.pdf",
                        'kategori' => 'informasi setiap saat',
                        'tanggal_upload' => Carbon::create($year, rand(2, 10), rand(1, 28)),
                        'uploader' => 'Sekretaris Desa',
                    ]
                );
            }


            // --- 3. INFORMASI SERTAMERTA (Kondisional/Bencana) ---
            
            // Simulasi ada kejadian di tahun 2021 (Covid) dan 2024 (Banjir)
            if ($year == 2021) {
                PpidDokumen::updateOrCreate(
                    [
                        'judul_dokumen' => "Surat Edaran PPKM Darurat Covid-19 Desa",
                        'tahun' => $year,
                    ],
                    [
                        'file_url' => "storage/ppid/se-ppkm-$year.pdf",
                        'kategori' => 'informasi sertamerta',
                        'tanggal_upload' => Carbon::create($year, 7, 5),
                        'uploader' => 'Satgas Covid Desa',
                    ]
                );
            }

            if ($year == 2024) {
                PpidDokumen::updateOrCreate(
                    [
                        'judul_dokumen' => "Himbauan Waspada Banjir Kiriman",
                        'tahun' => $year,
                    ],
                    [
                        'file_url' => "storage/ppid/waspada-banjir-$year.pdf",
                        'kategori' => 'informasi sertamerta',
                        'tanggal_upload' => Carbon::create($year, 2, 10),
                        'uploader' => 'Kepala Desa',
                    ]
                );
            }
        }

        $this->command->info('PPID Dokumen berhasil di-seed untuk tahun 2020-2025!');
    }
}
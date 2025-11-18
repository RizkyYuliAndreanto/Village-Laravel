<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaporanApbdes;
use App\Models\TahunData;

class LaporanApbdesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil tahun data yang sudah dibuat oleh TahunDataSeeder
        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // --- Buat Laporan untuk 2024 ---
        if ($tahun2024) {
            $laporan2024 = LaporanApbdes::firstOrCreate(
                [
                    'tahun_id' => $tahun2024->id_tahun,
                    'nama_laporan' => 'APBDes 2024 (Realisasi)',
                ],
                [
                    'bulan_rilis' => 12, // Rilis Desember
                    'deskripsi' => 'Laporan realisasi Anggaran Pendapatan dan Belanja Desa tahun 2024.',
                    'status' => 'published',
                ]
            );

            // Hapus detail lama jika seeder di-run ulang untuk laporan ini
            $laporan2024->detailApbdes()->delete();

            // Buat detail baru untuk laporan 2024
            $laporan2024->detailApbdes()->createMany([
                // --- PENDAPATAN ---
                [
                    'tipe' => 'pendapatan', // Sesuai model DetailApbdes
                    'uraian' => 'Dana Desa (DD)',
                    'anggaran' => 1200000000,
                    'realisasi' => 1200000000,
                ],
                [
                    'tipe' => 'pendapatan',
                    'uraian' => 'Alokasi Dana Desa (ADD)',
                    'anggaran' => 800000000,
                    'realisasi' => 800000000,
                ],
                [
                    'tipe' => 'pendapatan',
                    'uraian' => 'Bagi Hasil Pajak & Retribusi (BHPR)',
                    'anggaran' => 150000000,
                    'realisasi' => 145000000,
                ],
                // --- BELANJA ---
                [
                    'tipe' => 'belanja', // Sesuai logika di HomeController
                    'uraian' => 'Belanja Pegawai (Penghasilan Tetap)',
                    'anggaran' => 500000000,
                    'realisasi' => 495000000,
                ],
                [
                    'tipe' => 'belanja',
                    'uraian' => 'Belanja Barang dan Jasa',
                    'anggaran' => 300000000,
                    'realisasi' => 280000000,
                ],
                [
                    'tipe' => 'belanja',
                    'uraian' => 'Belanja Modal (Infrastruktur)',
                    'anggaran' => 1000000000,
                    'realisasi' => 950000000,
                ],
                [
                    'tipe' =>'belanja',
                    'uraian' => 'Belanja Tak Terduga',
                    'anggaran' => 50000000,
                    'realisasi' => 20000000,
                ],
            ]);
        }
        
        // --- Buat Laporan untuk 2023 (Contoh data historis) ---
        if ($tahun2023) {
            $laporan2023 = LaporanApbdes::firstOrCreate(
                [
                    'tahun_id' => $tahun2023->id_tahun,
                    'nama_laporan' => 'APBDes 2023 (Final)',
                ],
                [
                    'bulan_rilis' => 12,
                    'deskripsi' => 'Laporan final Anggaran Pendapatan dan Belanja Desa tahun 2023.',
                    'status' => 'published',
                ]
            );
            
            // Hapus detail lama jika seeder di-run ulang
            $laporan2023->detailApbdes()->delete();
            
            $laporan2023->detailApbdes()->createMany([
                [
                    'tipe' => 'pendapatan',
                    'uraian' => 'Dana Desa (DD)',
                    'anggaran' => 1100000000,
                    'realisasi' => 1100000000,
                ],
                [
                    'tipe' => 'belanja',
                    'uraian' => 'Belanja Modal (Infrastruktur)',
                    'anggaran' => 900000000,
                    'realisasi' => 890000000,
                ],
            ]);
        }
    }
}
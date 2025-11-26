<?php

namespace Database\Seeders;

use App\Models\BidangApbdes;
use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;
use App\Models\SubBidangApbdes;
use Illuminate\Database\Seeder;

class DetailApbdesSeeder extends Seeder
{
    public function run(): void
    {
        // Cari Laporan Tahun Ini yang baru saja kita seed
        $tahunSekarang = date('Y');
        $laporan = LaporanApbdes::whereHas('tahunData', function($q) use ($tahunSekarang) {
            $q->where('tahun', $tahunSekarang);
        })->first();

        if (!$laporan) {
            // Fallback jika tidak ketemu, ambil yang terakhir
            $laporan = LaporanApbdes::latest()->first();
        }

        if (!$laporan) {
            $this->command->error('Harap jalankan LaporanAPBDesSeeder terlebih dahulu.');
            return;
        }

        // --- INPUT PENDAPATAN ---
        $bidangPendapatan = BidangApbdes::where('kategori', 'pendapatan')->first();
        if ($bidangPendapatan) {
            $subDD = SubBidangApbdes::where('nama_sub_bidang', 'like', '%Transfer%')->first();
            
            // Menggunakan updateOrCreate berdasarkan laporan_id dan uraian
            DetailApbdes::updateOrCreate(
                [
                    'laporan_apbdes_id' => $laporan->id,
                    'uraian' => 'Dana Desa (DD)',
                ],
                [
                    'bidang_apbdes_id' => $bidangPendapatan->id,
                    'sub_bidang_apbdes_id' => $subDD?->id,
                    'tipe' => 'pendapatan',
                    'anggaran' => 850000000,
                    'realisasi' => 850000000,
                    'bulan_realisasi' => 12,
                ]
            );

            DetailApbdes::updateOrCreate(
                [
                    'laporan_apbdes_id' => $laporan->id,
                    'uraian' => 'Alokasi Dana Desa (ADD)',
                ],
                [
                    'bidang_apbdes_id' => $bidangPendapatan->id,
                    'sub_bidang_apbdes_id' => $subDD?->id,
                    'tipe' => 'pendapatan',
                    'anggaran' => 450000000,
                    'realisasi' => 450000000,
                    'bulan_realisasi' => 12,
                ]
            );
        }

        // --- INPUT BELANJA ---
        $bidangPem = BidangApbdes::where('nama_bidang', 'like', '%Pemerintahan%')->first();
        if ($bidangPem) {
            DetailApbdes::updateOrCreate(
                [
                    'laporan_apbdes_id' => $laporan->id,
                    'uraian' => 'Penghasilan Tetap Kepala Desa & Perangkat',
                ],
                [
                    'bidang_apbdes_id' => $bidangPem->id,
                    'tipe' => 'belanja',
                    'anggaran' => 350000000,
                    'realisasi' => 320000000,
                    'bulan_realisasi' => 11,
                ]
            );
        }
        
        // Tambahkan data belanja pembangunan agar grafik terlihat bagus
        $bidangBang = BidangApbdes::where('nama_bidang', 'like', '%Pembangunan%')->first();
        if ($bidangBang) {
            DetailApbdes::updateOrCreate(
                [
                    'laporan_apbdes_id' => $laporan->id,
                    'uraian' => 'Pembangunan Jalan Desa',
                ],
                [
                    'bidang_apbdes_id' => $bidangBang->id,
                    'tipe' => 'belanja',
                    'anggaran' => 200000000,
                    'realisasi' => 150000000,
                    'bulan_realisasi' => 10,
                ]
            );
        }
    }
}
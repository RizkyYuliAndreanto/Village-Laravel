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
        // Ambil semua laporan yang sudah dibuat
        $laporans = LaporanApbdes::with('tahunData')->get();

        if ($laporans->isEmpty()) {
            $this->command->error('Harap jalankan LaporanAPBDesSeeder terlebih dahulu.');
            return;
        }

        // Referensi Bidang & Sub Bidang
        $bidangPendapatan = BidangApbdes::where('kategori', 'pendapatan')->first();
        $bidangPem = BidangApbdes::where('nama_bidang', 'like', '%Pemerintahan%')->first();
        $bidangBang = BidangApbdes::where('nama_bidang', 'like', '%Pembangunan%')->first();
        $subDD = SubBidangApbdes::where('nama_sub_bidang', 'like', '%Transfer%')->first();

        foreach ($laporans as $laporan) {
            $tahun = $laporan->tahunData->tahun;
            
            // LOGIKA PERTUMBUHAN DATA
            // Kita buat faktor pengali berdasarkan selisih tahun dari 2020
            // Contoh: 2020 (base), 2021 (naik 5%), 2022 (naik 10%), dst.
            $baseYear = 2020;
            $diff = $tahun - $baseYear;
            $multiplier = 1 + ($diff * 0.05); // Kenaikan 5% per tahun

            // --- 1. PENDAPATAN ---
            
            // Dana Desa (Base: 800jt)
            $anggaranDD = 800000000 * $multiplier;
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Dana Desa (DD)'],
                [
                    'bidang_apbdes_id' => $bidangPendapatan?->id,
                    'sub_bidang_apbdes_id' => $subDD?->id,
                    'tipe' => 'pendapatan',
                    'anggaran' => $anggaranDD,
                    'realisasi' => $anggaranDD, // Biasanya DD cair 100%
                    'persentase_realisasi' => 100,
                    'bulan_realisasi' => 12,
                ]
            );

            // Alokasi Dana Desa (Base: 400jt)
            $anggaranADD = 400000000 * $multiplier;
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Alokasi Dana Desa (ADD)'],
                [
                    'bidang_apbdes_id' => $bidangPendapatan?->id,
                    'sub_bidang_apbdes_id' => $subDD?->id,
                    'tipe' => 'pendapatan',
                    'anggaran' => $anggaranADD,
                    'realisasi' => $anggaranADD,
                    'persentase_realisasi' => 100,
                    'bulan_realisasi' => 12,
                ]
            );

            // Pendapatan Asli Desa (Base: 50jt - Fluktuatif)
            $anggaranPAD = 50000000 * $multiplier;
            // Realisasi PAD kadang naik turun, kita acak sedikit (90% - 110%)
            $realisasiPAD = $anggaranPAD * (rand(90, 110) / 100); 
            
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Pendapatan Asli Desa (PAD)'],
                [
                    'bidang_apbdes_id' => $bidangPendapatan?->id,
                    'tipe' => 'pendapatan',
                    'anggaran' => $anggaranPAD,
                    'realisasi' => $realisasiPAD,
                    'persentase_realisasi' => ($realisasiPAD / $anggaranPAD) * 100,
                    'bulan_realisasi' => 12,
                ]
            );


            // --- 2. BELANJA ---

            // Penghasilan Tetap (Siltap) - Base: 350jt
            $anggaranSiltap = 350000000 * $multiplier;
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Siltap Kepala Desa & Perangkat'],
                [
                    'bidang_apbdes_id' => $bidangPem?->id,
                    'tipe' => 'belanja',
                    'anggaran' => $anggaranSiltap,
                    'realisasi' => $anggaranSiltap * 0.98, // Terserap 98%
                    'persentase_realisasi' => 98,
                    'bulan_realisasi' => 12,
                ]
            );

            // Operasional Kantor - Base: 100jt
            $anggaranOps = 100000000 * $multiplier;
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Operasional Perkantoran'],
                [
                    'bidang_apbdes_id' => $bidangPem?->id,
                    'tipe' => 'belanja',
                    'anggaran' => $anggaranOps,
                    'realisasi' => $anggaranOps * 0.95,
                    'persentase_realisasi' => 95,
                    'bulan_realisasi' => 12,
                ]
            );

            // Pembangunan Jalan (Proyek Fisik) - Base: 300jt
            // Nominalnya kita buat agak bervariasi tiap tahun
            $anggaranFisik = (300000000 * $multiplier) + (rand(-20000000, 50000000));
            DetailApbdes::updateOrCreate(
                ['laporan_apbdes_id' => $laporan->id, 'uraian' => 'Pembangunan Infrastruktur Jalan Desa'],
                [
                    'bidang_apbdes_id' => $bidangBang?->id,
                    'tipe' => 'belanja',
                    'anggaran' => $anggaranFisik,
                    'realisasi' => $anggaranFisik, // Anggap terserap semua
                    'persentase_realisasi' => 100,
                    'bulan_realisasi' => 11,
                ]
            );
        }
    }
}
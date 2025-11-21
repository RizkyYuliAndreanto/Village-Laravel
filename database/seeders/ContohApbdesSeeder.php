<?php

namespace Database\Seeders;

use App\Models\LaporanApbdes;
use App\Models\DetailApbdes;
use App\Models\BidangApbdes;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class ContohApbdesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Pastikan ada data tahun
        $tahun2025 = TahunData::firstOrCreate(['tahun' => 2025], [
            'id_tahun' => 2025,
            'is_active' => true,
        ]);

        // Buat laporan APBDes 2025
        $laporan = LaporanApbdes::create([
            'tahun_id' => $tahun2025->id_tahun,
            'nama_laporan' => 'APBDes Desa Banyukambang 2025',
            'bulan_rilis' => 3, // Maret
            'deskripsi' => 'Anggaran Pendapatan dan Belanja Desa Banyukambang Tahun 2025',
            'status' => 'diterbitkan',
        ]);

        // Ambil bidang yang sudah ada
        $bidangPendapatan = BidangApbdes::where('kategori', 'pendapatan')->first();
        $bidangBelanja = BidangApbdes::where('kategori', 'belanja')->get();

        // Data Pendapatan (contoh sesuai banner)
        $dataPendapatan = [
            ['uraian' => 'Pendapatan Asli Desa (PAD)', 'anggaran' => 50000000, 'realisasi' => 45000000],
            ['uraian' => 'Transfer Dana Desa', 'anggaran' => 800000000, 'realisasi' => 750000000],
            ['uraian' => 'Dana Desa dari Pusat', 'anggaran' => 500000000, 'realisasi' => 500000000],
            ['uraian' => 'Alokasi Dana Desa (ADD)', 'anggaran' => 300000000, 'realisasi' => 280000000],
            ['uraian' => 'Bantuan Keuangan Provinsi', 'anggaran' => 150000000, 'realisasi' => 120000000],
        ];

        foreach ($dataPendapatan as $item) {
            DetailApbdes::create([
                'laporan_apbdes_id' => $laporan->id,
                'bidang_apbdes_id' => $bidangPendapatan->id,
                'tipe' => 'pendapatan',
                'uraian' => $item['uraian'],
                'anggaran' => $item['anggaran'],
                'realisasi' => $item['realisasi'],
                'bulan_realisasi' => 3,
                'keterangan' => 'Data realisasi bulan Maret 2025',
            ]);
        }

        // Data Belanja per Bidang (contoh sesuai banner)
        $dataBelanja = [
            [
                'bidang' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'items' => [
                    ['uraian' => 'Belanja Pegawai', 'anggaran' => 200000000, 'realisasi' => 180000000],
                    ['uraian' => 'Belanja Barang dan Jasa', 'anggaran' => 150000000, 'realisasi' => 140000000],
                    ['uraian' => 'Belanja Modal', 'anggaran' => 100000000, 'realisasi' => 95000000],
                ]
            ],
            [
                'bidang' => 'Bidang Pelaksanaan Pembangunan Desa',
                'items' => [
                    ['uraian' => 'Pembangunan Jalan Desa', 'anggaran' => 300000000, 'realisasi' => 280000000],
                    ['uraian' => 'Pembangunan Saluran Air', 'anggaran' => 200000000, 'realisasi' => 185000000],
                    ['uraian' => 'Pembangunan Balai Desa', 'anggaran' => 150000000, 'realisasi' => 120000000],
                ]
            ],
            [
                'bidang' => 'Bidang Pembinaan Kemasyarakatan',
                'items' => [
                    ['uraian' => 'Kegiatan Keagamaan', 'anggaran' => 75000000, 'realisasi' => 70000000],
                    ['uraian' => 'Kegiatan Olahraga', 'anggaran' => 50000000, 'realisasi' => 45000000],
                    ['uraian' => 'Kegiatan Seni Budaya', 'anggaran' => 40000000, 'realisasi' => 35000000],
                ]
            ],
            [
                'bidang' => 'Bidang Pemberdayaan Masyarakat',
                'items' => [
                    ['uraian' => 'Pelatihan Keterampilan', 'anggaran' => 100000000, 'realisasi' => 90000000],
                    ['uraian' => 'Bantuan UMKM', 'anggaran' => 150000000, 'realisasi' => 140000000],
                    ['uraian' => 'Program PKK', 'anggaran' => 50000000, 'realisasi' => 45000000],
                ]
            ],
            [
                'bidang' => 'Bidang Penanggulangan Bencana, Darurat dan Mendesak',
                'items' => [
                    ['uraian' => 'Dana Tanggap Darurat', 'anggaran' => 50000000, 'realisasi' => 30000000],
                    ['uraian' => 'Peralatan Keselamatan', 'anggaran' => 30000000, 'realisasi' => 25000000],
                ]
            ],
        ];

        foreach ($dataBelanja as $bidangData) {
            $bidang = BidangApbdes::where('nama_bidang', $bidangData['bidang'])->first();

            if ($bidang) {
                foreach ($bidangData['items'] as $item) {
                    DetailApbdes::create([
                        'laporan_apbdes_id' => $laporan->id,
                        'bidang_apbdes_id' => $bidang->id,
                        'tipe' => 'belanja',
                        'uraian' => $item['uraian'],
                        'anggaran' => $item['anggaran'],
                        'realisasi' => $item['realisasi'],
                        'bulan_realisasi' => 3,
                        'keterangan' => 'Data realisasi bulan Maret 2025',
                    ]);
                }
            }
        }
    }
}

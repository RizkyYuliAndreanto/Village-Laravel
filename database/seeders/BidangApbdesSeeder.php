<?php

namespace Database\Seeders;

use App\Models\BidangApbdes;
use App\Models\SubBidangApbdes;
use Illuminate\Database\Seeder;

class BidangApbdesSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $pendapatan = BidangApbdes::where('kode_bidang', 'PDD01')->first();
        if (!$pendapatan) {
            $pendapatan = BidangApbdes::create([
                'kode_bidang' => 'PDD01',
                'nama_bidang' => 'Pendapatan Desa',
                'kategori' => 'pendapatan',
                'deskripsi' => 'Semua jenis pendapatan desa',
                'urutan' => 1,
                'is_active' => true,
            ]);
        }

        // Sub bidang pendapatan
        SubBidangApbdes::create([
            'bidang_apbdes_id' => $pendapatan->id,
            'kode_sub_bidang' => 'PDD01.001',
            'nama_sub_bidang' => 'Pendapatan Asli Desa (PAD)',
            'urutan' => 1,
        ]);

        SubBidangApbdes::create([
            'bidang_apbdes_id' => $pendapatan->id,
            'kode_sub_bidang' => 'PDD01.002',
            'nama_sub_bidang' => 'Transfer/Dana Desa',
            'urutan' => 2,
        ]);

        SubBidangApbdes::create([
            'bidang_apbdes_id' => $pendapatan->id,
            'kode_sub_bidang' => 'PDD01.003',
            'nama_sub_bidang' => 'Pendapatan Lain-lain',
            'urutan' => 3,
        ]);

        // Data Bidang Belanja sesuai banner
        $bidangBelanja = [
            [
                'kode' => 'BPD01',
                'nama' => 'Bidang Penyelenggaraan Pemerintahan Desa',
                'urutan' => 1,
            ],
            [
                'kode' => 'BPP01',
                'nama' => 'Bidang Pelaksanaan Pembangunan Desa',
                'urutan' => 2,
            ],
            [
                'kode' => 'BPK01',
                'nama' => 'Bidang Pembinaan Kemasyarakatan',
                'urutan' => 3,
            ],
            [
                'kode' => 'BPM01',
                'nama' => 'Bidang Pemberdayaan Masyarakat',
                'urutan' => 4,
            ],
            [
                'kode' => 'BPB01',
                'nama' => 'Bidang Penanggulangan Bencana, Darurat dan Mendesak',
                'urutan' => 5,
            ],
        ];

        foreach ($bidangBelanja as $bidang) {
            if (!BidangApbdes::where('kode_bidang', $bidang['kode'])->exists()) {
                BidangApbdes::create([
                    'kode_bidang' => $bidang['kode'],
                    'nama_bidang' => $bidang['nama'],
                    'kategori' => 'belanja',
                    'deskripsi' => "Belanja untuk {$bidang['nama']}",
                    'urutan' => $bidang['urutan'] + 1, // +1 karena pendapatan urutan 1
                    'is_active' => true,
                ]);
            }
        }

        // Bidang Pembiayaan (opsional)
        if (!BidangApbdes::where('kode_bidang', 'PMB01')->exists()) {
            BidangApbdes::create([
                'kode_bidang' => 'PMB01',
                'nama_bidang' => 'Pembiayaan Desa',
                'kategori' => 'pembiayaan',
                'deskripsi' => 'Penerimaan dan pengeluaran pembiayaan desa',
                'urutan' => 7,
                'is_active' => true,
            ]);
        }
    }
}

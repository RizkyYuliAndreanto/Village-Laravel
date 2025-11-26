<?php

namespace Database\Seeders;

use App\Models\BidangApbdes;
use App\Models\SubBidangApbdes;
use Illuminate\Database\Seeder;

class BidangApbdesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. PENDAPATAN
        $pd = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '1'], // Kunci pencarian unik
            [
                'nama_bidang' => 'Pendapatan Desa',
                'kategori' => 'pendapatan',
                'urutan' => 1,
                'is_active' => true,
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '1.1'],
            [
                'bidang_apbdes_id' => $pd->id,
                'nama_sub_bidang' => 'Pendapatan Asli Desa (PAD)'
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '1.2'],
            [
                'bidang_apbdes_id' => $pd->id,
                'nama_sub_bidang' => 'Transfer (Dana Desa, ADD, dll)'
            ]
        );

        // 2. BELANJA - Penyelenggaraan Pemerintahan
        $b1 = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '2.1'],
            [
                'nama_bidang' => 'Penyelenggaraan Pemerintahan Desa',
                'kategori' => 'belanja',
                'urutan' => 2,
                'is_active' => true,
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.1.1'],
            [
                'bidang_apbdes_id' => $b1->id,
                'nama_sub_bidang' => 'Siltap dan Tunjangan'
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.1.2'],
            [
                'bidang_apbdes_id' => $b1->id,
                'nama_sub_bidang' => 'Operasional Kantor Desa'
            ]
        );

        // 3. BELANJA - Pembangunan
        $b2 = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '2.2'],
            [
                'nama_bidang' => 'Pelaksanaan Pembangunan Desa',
                'kategori' => 'belanja',
                'urutan' => 3,
                'is_active' => true,
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.2.1'],
            [
                'bidang_apbdes_id' => $b2->id,
                'nama_sub_bidang' => 'Pendidikan'
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.2.2'],
            [
                'bidang_apbdes_id' => $b2->id,
                'nama_sub_bidang' => 'Kesehatan'
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.2.3'],
            [
                'bidang_apbdes_id' => $b2->id,
                'nama_sub_bidang' => 'Pekerjaan Umum & Penataan Ruang'
            ]
        );

        // 4. BELANJA - Pembinaan Kemasyarakatan
        $b3 = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '2.3'],
            [
                'nama_bidang' => 'Pembinaan Kemasyarakatan Desa',
                'kategori' => 'belanja',
                'urutan' => 4,
                'is_active' => true,
            ]
        );

        // 5. BELANJA - Pemberdayaan Masyarakat
        $b4 = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '2.4'],
            [
                'nama_bidang' => 'Pemberdayaan Masyarakat Desa',
                'kategori' => 'belanja',
                'urutan' => 5,
                'is_active' => true,
            ]
        );

        SubBidangApbdes::updateOrCreate(
            ['kode_sub_bidang' => '2.4.1'],
            [
                'bidang_apbdes_id' => $b4->id,
                'nama_sub_bidang' => 'Pertanian dan Peternakan'
            ]
        );

        // 6. BELANJA - Penanggulangan Bencana
        $b5 = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '2.5'],
            [
                'nama_bidang' => 'Penanggulangan Bencana & Mendesak',
                'kategori' => 'belanja',
                'urutan' => 6,
                'is_active' => true,
            ]
        );

        // 7. PEMBIAYAAN
        $pb = BidangApbdes::updateOrCreate(
            ['kode_bidang' => '3'],
            [
                'nama_bidang' => 'Pembiayaan Desa',
                'kategori' => 'pembiayaan',
                'urutan' => 7,
                'is_active' => true,
            ]
        );
    }
}
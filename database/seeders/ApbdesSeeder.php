<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApbdesTahun;

class ApbdesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'tahun' => 2022,
                'total_pendapatan' => 1200000000.00,
                'total_pengeluaran' => 1100000000.00,
                'saldo_akhir' => 100000000.00,
                'status' => ApbdesTahun::STATUS_SURPLUS,
            ],
            [
                'tahun' => 2023,
                'total_pendapatan' => 1350000000.00,
                'total_pengeluaran' => 1350000000.00,
                'saldo_akhir' => 0.00,
                'status' => ApbdesTahun::STATUS_SEIMBANG,
            ],
            [
                'tahun' => 2024,
                'total_pendapatan' => 1500000000.00,
                'total_pengeluaran' => 1600000000.00,
                'saldo_akhir' => -100000000.00,
                'status' => ApbdesTahun::STATUS_DEFISIT,
            ],
        ];

        foreach ($data as $item) {
            ApbdesTahun::create($item);
        }
    }
}

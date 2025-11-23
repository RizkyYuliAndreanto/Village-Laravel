<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunData;

class TahunDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunData = [
            [
                'tahun' => 2020,
                'keterangan' => 'Data statistik tahun 2020 - Era pandemi COVID-19',
            ],
            [
                'tahun' => 2021,
                'keterangan' => 'Data statistik tahun 2021 - Pemulihan ekonomi',
            ],
            [
                'tahun' => 2022,
                'keterangan' => 'Data statistik tahun 2022 - Normalisasi kehidupan',
            ],
            [
                'tahun' => 2023,
                'keterangan' => 'Data statistik tahun 2023 - Pertumbuhan berkelanjutan',
            ],
            [
                'tahun' => 2024,
                'keterangan' => 'Data statistik tahun 2024 - Era digitalisasi desa',
            ],
        ];

        foreach ($tahunData as $data) {
            TahunData::create($data);
        }
    }
}

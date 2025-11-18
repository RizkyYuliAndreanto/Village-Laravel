<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunData;

class TahunDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate untuk menghindari duplikat
        
        TahunData::firstOrCreate(
            ['tahun' => 2023], // Cari berdasarkan tahun
            ['keterangan' => 'Data tahun 2023'] // Buat dengan keterangan ini
        );

        TahunData::firstOrCreate(
            ['tahun' => 2024], // Cari berdasarkan tahun
            ['keterangan' => 'Data tahun 2024 (Aktif)'] // Buat dengan keterangan ini
        );

        TahunData::firstOrCreate(
            ['tahun' => 2025], // Cari berdasarkan tahun
            ['keterangan' => 'Data tahun 2025'] // Buat dengan keterangan ini
        );
    }
}
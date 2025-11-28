<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TahunData; // Pastikan model sudah ada

class TahunDataSeeder extends Seeder
{
    public function run(): void
    {
        $years = range(2020, 2025);

        foreach ($years as $year) {
            // Menggunakan firstOrCreate untuk menghindari duplikasi jika seeder dijalankan ulang
            TahunData::firstOrCreate(
                ['tahun' => $year],
                ['keterangan' => "Periode Data Tahun Anggaran $year"]
            );
        }
    }
}
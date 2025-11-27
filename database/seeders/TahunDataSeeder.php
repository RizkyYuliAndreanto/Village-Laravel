<?php

namespace Database\Seeders;

use App\Models\TahunData;
use Illuminate\Database\Seeder;

class TahunDataSeeder extends Seeder
{
    public function run(): void
    {
        $years = range(2020, 2025);

        foreach ($years as $year) {
            TahunData::updateOrCreate(
                ['tahun' => $year],
                ['keterangan' => "Data Tahun Anggaran $year"]
            );
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TahunData;
use App\Models\Pendapatan; // Model yang baru kita buat

class PendapatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        Pendapatan::query()->delete();

        // Ambil data tahun
        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // Data untuk 2024
        if ($tahun2024) {
            Pendapatan::create([
                'tahun_id' => $tahun2024->id_tahun,
                'total_pendapatan' => 2150000000.00, // (Contoh: 1.2M + 800M + 150M)
                'keterangan' => 'Total pendapatan gabungan tahun 2024.',
            ]);
        }
        
        // Data untuk 2023
        if ($tahun2023) {
            Pendapatan::create([
                'tahun_id' => $tahun2023->id_tahun,
                'total_pendapatan' => 1100000000.00,
                'keterangan' => 'Total pendapatan gabungan tahun 2023.',
            ]);
        }
    }
}
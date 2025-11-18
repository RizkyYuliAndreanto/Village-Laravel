<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;

class DemografiPendudukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        DemografiPenduduk::query()->delete();

        // Ambil data tahun yang sudah dibuat oleh TahunDataSeeder
        $tahun2024 = TahunData::where('tahun', 2024)->first();
        $tahun2023 = TahunData::where('tahun', 2023)->first();

        // Data untuk 2024
        if ($tahun2024) {
            DemografiPenduduk::create([
                'tahun_id' => $tahun2024->id_tahun,
                'total_penduduk' => 1500,
                'laki_laki' => 740,
                'perempuan' => 760, // 740 + 760 = 1500
                'penduduk_sementara' => 50,
                'mutasi_penduduk' => 12,
            ]);
        }
        
        // Data untuk 2023
        if ($tahun2023) {
            DemografiPenduduk::create([
                'tahun_id' => $tahun2023->id_tahun,
                'total_penduduk' => 1450,
                'laki_laki' => 710,
                'perempuan' => 740, // 710 + 740 = 1450
                'penduduk_sementara' => 45,
                'mutasi_penduduk' => 10,
            ]);
        }
    }
}
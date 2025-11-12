<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;

class StatistikDesaSeeder extends Seeder
{
    public function run(): void
    {
        // Misalnya, asumsikan tabel tahun_data sudah berisi data tahun
        // Jika belum, kita buat dummy-nya di sini:
        $tahun2022 = TahunData::firstOrCreate(['tahun' => 2022]);
        $tahun2023 = TahunData::firstOrCreate(['tahun' => 2023]);
        $tahun2024 = TahunData::firstOrCreate(['tahun' => 2024]);

        $data = [
            [
                'tahun_id' => $tahun2022->id_tahun,
                'total_penduduk' => 2540,
                'laki_laki' => 1300,
                'perempuan' => 1240,
                'penduduk_sementara' => 45,
                'mutasi_penduduk' => 12,
            ],
            [
                'tahun_id' => $tahun2023->id_tahun,
                'total_penduduk' => 2587,
                'laki_laki' => 1320,
                'perempuan' => 1267,
                'penduduk_sementara' => 42,
                'mutasi_penduduk' => 15,
            ],
            [
                'tahun_id' => $tahun2024->id_tahun,
                'total_penduduk' => 2615,
                'laki_laki' => 1334,
                'perempuan' => 1281,
                'penduduk_sementara' => 38,
                'mutasi_penduduk' => 10,
            ],
        ];

        foreach ($data as $item) {
            DemografiPenduduk::create($item);
        }
    }
}

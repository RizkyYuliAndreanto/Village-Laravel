<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;

class DemografiPendudukSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        $demografiData = [
            2020 => [
                'total_penduduk' => 8500,
                'laki_laki' => 4200,
                'perempuan' => 4300,
                'penduduk_sementara' => 150,
                'mutasi_penduduk' => 50,
            ],
            2021 => [
                'total_penduduk' => 8650,
                'laki_laki' => 4280,
                'perempuan' => 4370,
                'penduduk_sementara' => 165,
                'mutasi_penduduk' => 75,
            ],
            2022 => [
                'total_penduduk' => 8820,
                'laki_laki' => 4360,
                'perempuan' => 4460,
                'penduduk_sementara' => 180,
                'mutasi_penduduk' => 90,
            ],
            2023 => [
                'total_penduduk' => 9000,
                'laki_laki' => 4450,
                'perempuan' => 4550,
                'penduduk_sementara' => 200,
                'mutasi_penduduk' => 120,
            ],
            2024 => [
                'total_penduduk' => 9200,
                'laki_laki' => 4550,
                'perempuan' => 4650,
                'penduduk_sementara' => 220,
                'mutasi_penduduk' => 140,
            ],
        ];

        foreach ($demografiData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                DemografiPenduduk::create($data);
            }
        }
    }
}

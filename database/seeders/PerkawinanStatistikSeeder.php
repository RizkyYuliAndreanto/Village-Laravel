<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PerkawinanStatistik;
use App\Models\TahunData;

class PerkawinanStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        // Data harus sesuai dengan total penduduk dari DemografiPendudukSeeder
        // Hanya menggunakan kolom yang tersedia: kawin, cerai_hidup, cerai_mati, kawin_tercatat, kawin_tidak_tercatat
        // Total = kawin + cerai_hidup + cerai_mati + belum_kawin (tapi belum_kawin tidak ada kolom)
        $perkawinanData = [
            2020 => [
                'kawin' => 5525,               // 65% dari total penduduk
                'cerai_hidup' => 425,          // 5% dari total penduduk
                'cerai_mati' => 425,           // 5% dari total penduduk
                'kawin_tercatat' => 5270,      // 95.4% dari yang kawin
                'kawin_tidak_tercatat' => 255, // 4.6% dari yang kawin
                // Sisanya 25% (2125) adalah belum kawin tapi tidak ada kolom
            ],
            2021 => [
                'kawin' => 5623,               // 65%
                'cerai_hidup' => 433,          // 5%
                'cerai_mati' => 433,           // 5%
                'kawin_tercatat' => 5367,      // 95.4%
                'kawin_tidak_tercatat' => 256, // 4.6%
            ],
            2022 => [
                'kawin' => 5733,               // 65%
                'cerai_hidup' => 441,          // 5%
                'cerai_mati' => 441,           // 5%
                'kawin_tercatat' => 5469,      // 95.4%
                'kawin_tidak_tercatat' => 264, // 4.6%
            ],
            2023 => [
                'kawin' => 5850,               // 65%
                'cerai_hidup' => 450,          // 5%
                'cerai_mati' => 450,           // 5%
                'kawin_tercatat' => 5581,      // 95.4%
                'kawin_tidak_tercatat' => 269, // 4.6%
            ],
            2024 => [
                'kawin' => 5980,               // 65%
                'cerai_hidup' => 460,          // 5%
                'cerai_mati' => 460,           // 5%
                'kawin_tercatat' => 5705,      // 95.4%
                'kawin_tidak_tercatat' => 275, // 4.6%
            ],
        ];

        foreach ($perkawinanData as $tahun => $data) {
            if (isset($tahunIds[$tahun])) {
                $data['tahun_id'] = $tahunIds[$tahun];
                PerkawinanStatistik::create($data);
            }
        }
    }
}

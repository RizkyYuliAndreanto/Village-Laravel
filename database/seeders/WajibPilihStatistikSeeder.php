<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;

class WajibPilihStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::whereBetween('tahun', [2020, 2025])->get();

        foreach ($years as $yearData) {
            $laki = rand(1200, 1300);
            $perempuan = rand(1200, 1300);
            
            WajibPilihStatistik::updateOrCreate(
                ['tahun_id' => $yearData->id_tahun],
                [
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    'total' => $laki + $perempuan,
                ]
            );
        }
    }
}
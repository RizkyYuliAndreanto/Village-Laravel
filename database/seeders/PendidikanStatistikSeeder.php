<?php

namespace Database\Seeders;

use App\Models\PendidikanStatistik;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class PendidikanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::orderBy('tahun', 'asc')->get();

        $tingkatPendidikan = [
            'Tidak/Belum Sekolah' => 0.15,
            'SD/Sederajat' => 0.30,
            'SMP/Sederajat' => 0.25,
            'SMA/Sederajat' => 0.20,
            'Diploma/Sarjana' => 0.10,
        ];

        $basePopulasi = 3500;

        foreach ($years as $index => $tahunData) {
            $multiplier = 1 + ($index * 0.02);
            $populasi = $basePopulasi * $multiplier;

            foreach ($tingkatPendidikan as $tingkat => $persentase) {
                // Sedikit variasi: Makin tahun baru, yg sekolah makin banyak
                $variasi = ($index * 0.005); 
                if ($tingkat == 'Tidak/Belum Sekolah') $persentase -= $variasi;
                if ($tingkat == 'Diploma/Sarjana') $persentase += $variasi;

                PendidikanStatistik::updateOrCreate(
                    [
                        'tahun_id' => $tahunData->id_tahun,
                        'tingkat_pendidikan' => $tingkat,
                    ],
                    [
                        'jumlah' => floor($populasi * $persentase),
                    ]
                );
            }
        }
    }
}
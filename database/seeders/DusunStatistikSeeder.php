<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DusunStatistik;
use App\Models\TahunData;

class DusunStatistikSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        $dusunNames = [
            'Dusun Mawar',
            'Dusun Melati',
            'Dusun Kenanga',
            'Dusun Cempaka',
            'Dusun Anggrek',
        ];

        foreach ($tahunIds as $tahun => $tahunId) {
            foreach ($dusunNames as $index => $namaDusun) {
                // Variasi data berdasarkan tahun dan dusun
                $basePenduduk = 1500 + ($index * 200);
                $baseKK = 400 + ($index * 50);

                // Pertumbuhan tiap tahun
                $growthFactor = ($tahun - 2020) * 0.02 + 1;

                DusunStatistik::create([
                    'tahun_id' => $tahunId,
                    'nama_dusun' => $namaDusun,
                    'jumlah_penduduk' => (int) ($basePenduduk * $growthFactor),
                    'jumlah_kk' => (int) ($baseKK * $growthFactor),
                    'keterangan' => "Data dusun {$namaDusun} tahun {$tahun}",
                ]);
            }
        }
    }
}

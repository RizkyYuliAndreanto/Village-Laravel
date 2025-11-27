<?php

namespace Database\Seeders;

use App\Models\PekerjaanStatistik;
use App\Models\TahunData;
use Illuminate\Database\Seeder;

class PekerjaanStatistikSeeder extends Seeder
{
    public function run(): void
    {
        $years = TahunData::orderBy('tahun', 'asc')->get();

        $jenisPekerjaan = [
            'Petani/Pekebun' => 0.40,
            'Wiraswasta/Pedagang' => 0.20,
            'Karyawan Swasta' => 0.15,
            'PNS/TNI/Polri' => 0.05,
            'Buruh Harian' => 0.10,
            'Pelajar/Mahasiswa' => 0.05, // Sisanya lain-lain
        ];

        $basePopulasi = 3500; // Penduduk produktif

        foreach ($years as $index => $tahunData) {
            $multiplier = 1 + ($index * 0.02);
            $populasi = $basePopulasi * $multiplier;

            foreach ($jenisPekerjaan as $pekerjaan => $persentase) {
                PekerjaanStatistik::updateOrCreate(
                    [
                        'tahun_id' => $tahunData->id_tahun,
                        'nama_pekerjaan' => $pekerjaan,
                    ],
                    [
                        'jumlah' => floor($populasi * $persentase),
                    ]
                );
            }
            
            // Tambahkan "Lain-lain" untuk sisa
            PekerjaanStatistik::updateOrCreate(
                ['tahun_id' => $tahunData->id_tahun, 'nama_pekerjaan' => 'Lainnya/Belum Bekerja'],
                ['jumlah' => floor($populasi * 0.05)]
            );
        }
    }
}
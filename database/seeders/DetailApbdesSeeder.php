<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;

class DetailApbdesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laporanIds = LaporanApbdes::all();

        $detailTemplate = [
            'pendapatan' => [
                'Dana Desa dari Pusat' => ['anggaran' => 800000000, 'realisasi' => 800000000],
                'Alokasi Dana Desa' => ['anggaran' => 400000000, 'realisasi' => 390000000],
                'Pendapatan Asli Desa' => ['anggaran' => 100000000, 'realisasi' => 95000000],
                'Bantuan Keuangan Daerah' => ['anggaran' => 300000000, 'realisasi' => 300000000],
                'Hibah dan Sumbangan' => ['anggaran' => 50000000, 'realisasi' => 45000000],
            ],
            'belanja' => [
                'Belanja Pegawai' => ['anggaran' => 400000000, 'realisasi' => 380000000],
                'Belanja Barang dan Jasa' => ['anggaran' => 300000000, 'realisasi' => 290000000],
                'Belanja Modal' => ['anggaran' => 600000000, 'realisasi' => 580000000],
                'Belanja Tak Terduga' => ['anggaran' => 50000000, 'realisasi' => 25000000],
            ],
        ];

        foreach ($laporanIds as $laporan) {
            // Get the year from tahun_data relation
            $tahun = $laporan->tahunData->tahun ?? 2024;

            // Growth factor based on year
            $growthFactor = 1 + (($tahun - 2020) * 0.1);

            foreach ($detailTemplate as $tipe => $items) {
                foreach ($items as $uraian => $amounts) {
                    $anggaran = $amounts['anggaran'] * $growthFactor;
                    $realisasi = $amounts['realisasi'] * $growthFactor;

                    // Add some variation for different semesters
                    if (str_contains($laporan->nama_laporan, 'Semester I')) {
                        $realisasi = $realisasi * 0.45; // 45% realisasi di semester 1
                    } elseif (str_contains($laporan->nama_laporan, 'Semester II')) {
                        $realisasi = $realisasi * 0.95; // 95% realisasi di akhir tahun
                    }

                    DetailApbdes::create([
                        'laporan_apbdes_id' => $laporan->id,
                        'tipe' => $tipe,
                        'uraian' => $uraian,
                        'anggaran' => $anggaran,
                        'realisasi' => $realisasi,
                    ]);
                }
            }
        }
    }
}

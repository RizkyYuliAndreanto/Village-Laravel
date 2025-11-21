<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LaporanApbdes;
use App\Models\TahunData;

class LaporanApbdesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunIds = TahunData::pluck('id_tahun', 'tahun')->toArray();

        $laporanTypes = [
            'Laporan Semester I',
            'Laporan Semester II',
            'Laporan Tahunan',
        ];

        foreach ($tahunIds as $tahun => $tahunId) {
            foreach ($laporanTypes as $index => $namaLaporan) {
                $bulan = match ($namaLaporan) {
                    'Laporan Semester I' => 6, // Juni
                    'Laporan Semester II' => 12, // Desember
                    'Laporan Tahunan' => 1, // Januari tahun berikutnya
                    default => 12,
                };

                $status = match ($namaLaporan) {
                    'Laporan Semester I' => 'selesai',
                    'Laporan Semester II' => 'selesai',
                    'Laporan Tahunan' => $tahun < 2024 ? 'selesai' : 'draft',
                    default => 'selesai',
                };

                LaporanApbdes::create([
                    'tahun_id' => $tahunId,
                    'nama_laporan' => "{$namaLaporan} {$tahun}",
                    'bulan_rilis' => $bulan,
                    'deskripsi' => "Laporan keuangan APBDes {$namaLaporan} untuk tahun anggaran {$tahun}",
                    'status' => $status,
                ]);
            }
        }
    }
}

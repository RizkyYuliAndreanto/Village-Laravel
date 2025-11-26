<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PendidikanController - Handle data pendidikan
 * * Responsibilities:
 * - Data statistik tingkat pendidikan
 * - Chart horizontal pendidikan
 * - Analisis sebaran pendidikan
 */
class PendidikanController extends Controller
{
    /**
     * Get data pendidikan
     * * @param string|null $tahun
     * @return array
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // PERBAIKAN: Ambil satu baris data (first) karena struktur horizontal
        // Jangan gunakan orderBy('total_jiwa') karena kolom itu tidak ada di DB
        $data = PendidikanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // Transform database data (kolom) ke object
        return [
            'pendidikan' => (object)[
                'tidak_sekolah' => $data->tidak_sekolah ?? 0,
                'sd' => $data->sd ?? 0,
                'smp' => $data->smp ?? 0,
                'sma' => $data->sma ?? 0,
                'd1_d4' => $data->d1_d4 ?? 0,
                's1' => $data->s1 ?? 0,
                's2' => $data->s2 ?? 0,
                's3' => $data->s3 ?? 0,
            ]
        ];
    }

    /**
     * API endpoint untuk data pendidikan
     * Route: GET /api/infografis/pendidikan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getData($tahun));
    }

    /**
     * Get data untuk chart pendidikan
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $pendidikanData = $data['pendidikan'];

        return [
            'labels' => [
                "Tidak/Belum Sekolah",
                "SD/Sederajat",
                "SMP/Sederajat",
                "SMA/Sederajat",
                "Diploma I/II/III/IV",
                "Strata 1",
                "Strata 2",
                "Strata 3"
            ],
            'datasets' => [
                [
                    'data' => [
                        $pendidikanData->tidak_sekolah ?? 0,
                        $pendidikanData->sd ?? 0,
                        $pendidikanData->smp ?? 0,
                        $pendidikanData->sma ?? 0,
                        $pendidikanData->d1_d4 ?? 0,
                        $pendidikanData->s1 ?? 0,
                        $pendidikanData->s2 ?? 0,
                        $pendidikanData->s3 ?? 0
                    ],
                    'backgroundColor' => "#b80000",
                    'borderColor' => "#820000",
                    'borderWidth' => 1
                ]
            ]
        ];
    }

    /**
     * Get analisis pendidikan
     */
    public function getAnalisis($tahun = null)
    {
        $data = $this->getData($tahun);
        $pendidikanData = (array)$data['pendidikan']; // Cast ke array untuk perhitungan

        $total = array_sum($pendidikanData);
        
        if ($total == 0) {
            return [
                'total_penduduk' => 0,
                'pendidikan_dasar' => 0,
                'pendidikan_menengah' => 0,
                'pendidikan_tinggi' => 0,
                'persentase_pendidikan_tinggi' => 0,
                'tingkat_terbanyak' => '-',
                'jumlah_terbanyak' => 0
            ];
        }

        $pendidikanTinggi = ($pendidikanData['d1_d4'] ?? 0) +
            ($pendidikanData['s1'] ?? 0) +
            ($pendidikanData['s2'] ?? 0) +
            ($pendidikanData['s3'] ?? 0);

        // Cari tingkat terbanyak
        $tingkatTerbanyakKey = array_keys($pendidikanData, max($pendidikanData))[0] ?? 'sd';
        // Format label agar lebih rapi (misal: d1_d4 -> Diploma)
        $labelMapping = [
            'tidak_sekolah' => 'Tidak Sekolah', 'sd' => 'SD', 'smp' => 'SMP', 
            'sma' => 'SMA', 'd1_d4' => 'Diploma', 's1' => 'S1', 's2' => 'S2', 's3' => 'S3'
        ];

        return [
            'total_penduduk' => $total,
            'pendidikan_dasar' => ($pendidikanData['sd'] ?? 0) + ($pendidikanData['smp'] ?? 0),
            'pendidikan_menengah' => $pendidikanData['sma'] ?? 0,
            'pendidikan_tinggi' => $pendidikanTinggi,
            'persentase_pendidikan_tinggi' => round(($pendidikanTinggi / $total) * 100, 2),
            'tingkat_terbanyak' => $labelMapping[$tingkatTerbanyakKey] ?? ucfirst($tingkatTerbanyakKey),
            'jumlah_terbanyak' => max($pendidikanData)
        ];
    }

    /**
     * Get ranking pendidikan
     */
    public function getRanking($tahun = null)
    {
        $data = $this->getData($tahun);
        $pendidikanData = (array)$data['pendidikan'];

        // Sorting di level PHP (bukan Database) karena data sudah berbentuk array
        arsort($pendidikanData);

        $ranking = [];
        $no = 1;
        $labelMapping = [
            'tidak_sekolah' => 'Tidak/Belum Sekolah', 
            'sd' => 'SD/Sederajat', 
            'smp' => 'SMP/Sederajat', 
            'sma' => 'SMA/Sederajat', 
            'd1_d4' => 'Diploma I/II/III/IV', 
            's1' => 'Strata 1', 
            's2' => 'Strata 2', 
            's3' => 'Strata 3'
        ];

        foreach ($pendidikanData as $key => $jumlah) {
            $ranking[] = [
                'ranking' => $no++,
                'tingkat' => $labelMapping[$key] ?? ucfirst($key),
                'jumlah' => $jumlah,
                'persentase' => array_sum($pendidikanData) > 0 ?
                    round(($jumlah / array_sum($pendidikanData)) * 100, 2) : 0
            ];
        }

        return $ranking;
    }
}
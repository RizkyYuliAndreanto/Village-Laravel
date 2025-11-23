<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PendidikanStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PendidikanController - Handle data pendidikan
 * 
 * Responsibilities:
 * - Data statistik tingkat pendidikan
 * - Chart horizontal pendidikan
 * - Analisis sebaran pendidikan
 */
class PendidikanController extends Controller
{
    /**
     * Get data pendidikan
     * 
     * @param string|null $tahun
     * @return array
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // Coba ambil data dari database
        $statistikPendidikan = PendidikanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('total_jiwa', 'desc')->get();

        if ($statistikPendidikan->isEmpty()) {
            // Data dummy jika tidak ada data real
            return $this->getDummyData();
        }

        // Transform database data
        return $this->transformDatabaseData($statistikPendidikan);
    }

    /**
     * Data dummy untuk testing
     */
    private function getDummyData()
    {
        return [
            'data' => (object)[
                'tidak_sekolah' => 250,
                'sd' => 1850,
                'smp' => 1420,
                'sma' => 1680,
                'd1_d4' => 180,
                's1' => 220,
                's2' => 15,
                's3' => 3
            ]
        ];
    }

    /**
     * Transform database data ke format view
     */
    private function transformDatabaseData($statistikPendidikan)
    {
        $mapping = [
            'Tidak/Belum Sekolah' => 'tidak_sekolah',
            'SD/Sederajat' => 'sd',
            'SMP/Sederajat' => 'smp',
            'SMA/Sederajat' => 'sma',
            'Diploma I/II/III/IV' => 'd1_d4',
            'Strata 1' => 's1',
            'Strata 2' => 's2',
            'Strata 3' => 's3'
        ];

        $data = [];
        foreach ($statistikPendidikan as $stat) {
            $key = $mapping[$stat->tingkat_pendidikan] ?? strtolower(str_replace([' ', '/'], '_', $stat->tingkat_pendidikan));
            $data[$key] = $stat->total_jiwa;
        }

        return [
            'data' => (object)$data
        ];
    }

    /**
     * API endpoint untuk data pendidikan
     * Route: GET /api/infografis/pendidikan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * Get data untuk chart pendidikan
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $pendidikanData = $data['data'];

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
        $pendidikanData = (array)$data['data'];

        $total = array_sum($pendidikanData);
        $pendidikanTinggi = ($pendidikanData['d1_d4'] ?? 0) +
            ($pendidikanData['s1'] ?? 0) +
            ($pendidikanData['s2'] ?? 0) +
            ($pendidikanData['s3'] ?? 0);

        return [
            'total_penduduk' => $total,
            'pendidikan_dasar' => ($pendidikanData['sd'] ?? 0) + ($pendidikanData['smp'] ?? 0),
            'pendidikan_menengah' => $pendidikanData['sma'] ?? 0,
            'pendidikan_tinggi' => $pendidikanTinggi,
            'persentase_pendidikan_tinggi' => $total > 0 ? round(($pendidikanTinggi / $total) * 100, 2) : 0,
            'tingkat_terbanyak' => array_keys($pendidikanData, max($pendidikanData))[0] ?? 'sd',
            'jumlah_terbanyak' => max($pendidikanData)
        ];
    }

    /**
     * Get ranking pendidikan
     */
    public function getRanking($tahun = null)
    {
        $data = $this->getData($tahun);
        $pendidikanData = (array)$data['data'];

        arsort($pendidikanData);

        $ranking = [];
        $no = 1;
        foreach ($pendidikanData as $tingkat => $jumlah) {
            $ranking[] = [
                'ranking' => $no++,
                'tingkat' => $tingkat,
                'jumlah' => $jumlah,
                'persentase' => array_sum($pendidikanData) > 0 ?
                    round(($jumlah / array_sum($pendidikanData)) * 100, 2) : 0
            ];
        }

        return $ranking;
    }
}

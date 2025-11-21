<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\UmurStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * UmurController - Handle data kelompok umur
 * 
 * Responsibilities:
 * - Data piramida penduduk berdasarkan umur
 * - Statistik kelompok umur laki-laki dan perempuan
 * - Chart data untuk piramida umur
 */
class UmurController extends Controller
{
    /**
     * Get data kelompok umur untuk piramida penduduk
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
        $statistikUmur = UmurStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('kelompok_umur')->get();

        if ($statistikUmur->isEmpty()) {
            // Data dummy jika tidak ada data real
            return $this->getDummyData();
        }

        // Transform database data ke format yang dibutuhkan
        return $this->transformDatabaseData($statistikUmur);
    }

    /**
     * Data dummy untuk testing
     */
    private function getDummyData()
    {
        return [
            'umurData' => (object)[
                'umur_0_4' => 380,
                'umur_5_9' => 420,
                'umur_10_14' => 450,
                'umur_15_19' => 480,
                'umur_20_24' => 520,
                'umur_25_29' => 580,
                'umur_30_34' => 620,
                'umur_35_39' => 590,
                'umur_40_44' => 550,
                'umur_45_49' => 480,
                'umur_50_plus' => 540
            ]
        ];
    }

    /**
     * Transform database data ke format view
     */
    private function transformDatabaseData($statistikUmur)
    {
        $umurData = [];

        foreach ($statistikUmur as $stat) {
            $key = 'umur_' . str_replace(['-', '+'], ['_', '_plus'], $stat->kelompok_umur);
            $umurData[$key] = $stat->total_jiwa;
        }

        return [
            'umurData' => (object)$umurData
        ];
    }

    /**
     * API endpoint untuk data umur
     * Route: GET /api/infografis/umur
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * Get data chart untuk piramida penduduk
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $umurData = $data['umurData'];

        return [
            'labels' => [
                '0-4',
                '5-9',
                '10-14',
                '15-19',
                '20-24',
                '25-29',
                '30-34',
                '35-39',
                '40-44',
                '45-49',
                '50+'
            ],
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => [
                        - ($umurData->umur_0_4 ?? 0) / 2,
                        - ($umurData->umur_5_9 ?? 0) / 2,
                        - ($umurData->umur_10_14 ?? 0) / 2,
                        - ($umurData->umur_15_19 ?? 0) / 2,
                        - ($umurData->umur_20_24 ?? 0) / 2,
                        - ($umurData->umur_25_29 ?? 0) / 2,
                        - ($umurData->umur_30_34 ?? 0) / 2,
                        - ($umurData->umur_35_39 ?? 0) / 2,
                        - ($umurData->umur_40_44 ?? 0) / 2,
                        - ($umurData->umur_45_49 ?? 0) / 2,
                        - ($umurData->umur_50_plus ?? 0) / 2
                    ],
                    'backgroundColor' => 'rgba(56, 161, 105, 0.8)'
                ],
                [
                    'label' => 'Perempuan',
                    'data' => [
                        ($umurData->umur_0_4 ?? 0) / 2,
                        ($umurData->umur_5_9 ?? 0) / 2,
                        ($umurData->umur_10_14 ?? 0) / 2,
                        ($umurData->umur_15_19 ?? 0) / 2,
                        ($umurData->umur_20_24 ?? 0) / 2,
                        ($umurData->umur_25_29 ?? 0) / 2,
                        ($umurData->umur_30_34 ?? 0) / 2,
                        ($umurData->umur_35_39 ?? 0) / 2,
                        ($umurData->umur_40_44 ?? 0) / 2,
                        ($umurData->umur_45_49 ?? 0) / 2,
                        ($umurData->umur_50_plus ?? 0) / 2
                    ],
                    'backgroundColor' => 'rgba(244, 114, 182, 0.8)'
                ]
            ]
        ];
    }

    /**
     * Get insight dari data umur
     */
    public function getInsights($tahun = null)
    {
        $data = $this->getData($tahun);
        $umurData = $data['umurData'];

        // Cari kelompok umur terbanyak
        $dataArray = (array)$umurData;
        $terbanyak = array_keys($dataArray, max($dataArray));

        return [
            'kelompok_terbanyak' => $terbanyak[0] ?? 'umur_25_29',
            'jumlah_terbanyak' => max($dataArray),
            'total_anak' => ($umurData->umur_0_4 ?? 0) + ($umurData->umur_5_9 ?? 0) + ($umurData->umur_10_14 ?? 0),
            'total_produktif' => ($umurData->umur_15_19 ?? 0) + ($umurData->umur_20_24 ?? 0) +
                ($umurData->umur_25_29 ?? 0) + ($umurData->umur_30_34 ?? 0) +
                ($umurData->umur_35_39 ?? 0) + ($umurData->umur_40_44 ?? 0) +
                ($umurData->umur_45_49 ?? 0),
            'total_lansia' => ($umurData->umur_50_plus ?? 0)
        ];
    }
}

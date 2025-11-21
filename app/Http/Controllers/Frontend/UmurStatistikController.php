<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UmurStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * UmurStatistikController - Khusus untuk data statistik umur
 */
class UmurStatistikController extends Controller
{
    /**
     * Get tahun terbaru yang memiliki data statistik umur
     */
    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::whereHas('umurStatistik')
            ->orderBy('tahun', 'desc')
            ->first();

        if (!$tahunDataTerbaru) {
            $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();
        }

        if (!$tahunDataTerbaru) {
            $tahunDataTerbaru = (object)['tahun' => date('Y'), 'id_tahun' => 1];
        }

        return $tahunDataTerbaru;
    }

    /**
     * Halaman utama statistik umur
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', $this->getTahunTerbaru()->tahun);

        $statistikUmur = UmurStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->get();

        $totalJiwa = $this->calculateTotal($statistikUmur->first());

        $chartData = $this->getChartData($tahun);

        return view('frontend.statistik.umur', [
            'statistikUmur' => $statistikUmur,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahun
        ]);
    }

    /**
     * Get data untuk infografis
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahun = $this->getTahunTerbaru()->tahun;
        }

        $statistikUmur = UmurStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$statistikUmur) {
            return [
                'totalJiwa' => 0,
                'chartData' => $this->getDummyChartData(),
                'tahun' => $tahun,
                'isEmpty' => true
            ];
        }

        $totalJiwa = $this->calculateTotal($statistikUmur);
        $chartData = $this->transformDatabaseData($statistikUmur);

        return [
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahun,
            'isEmpty' => false
        ];
    }

    /**
     * Calculate total dari semua kolom umur
     */
    private function calculateTotal($statistikUmur)
    {
        if (!$statistikUmur) {
            return 0;
        }

        return $statistikUmur->umur_0_4 +
            $statistikUmur->umur_5_9 +
            $statistikUmur->umur_10_14 +
            $statistikUmur->umur_15_19 +
            $statistikUmur->umur_20_24 +
            $statistikUmur->umur_25_29 +
            $statistikUmur->umur_30_34 +
            $statistikUmur->umur_35_39 +
            $statistikUmur->umur_40_44 +
            $statistikUmur->umur_45_49 +
            $statistikUmur->umur_50_54 +
            $statistikUmur->umur_55_59 +
            $statistikUmur->umur_60_64 +
            $statistikUmur->umur_65_69 +
            $statistikUmur->umur_70_74 +
            $statistikUmur->umur_75_plus;
    }

    /**
     * Transform data dari database ke format chart
     */
    private function transformDatabaseData($statistikUmur)
    {
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
                '50-54',
                '55-59',
                '60-64',
                '65-69',
                '70-74',
                '75+'
            ],
            'datasets' => [[
                'label' => 'Jumlah Penduduk',
                'data' => [
                    $statistikUmur->umur_0_4,
                    $statistikUmur->umur_5_9,
                    $statistikUmur->umur_10_14,
                    $statistikUmur->umur_15_19,
                    $statistikUmur->umur_20_24,
                    $statistikUmur->umur_25_29,
                    $statistikUmur->umur_30_34,
                    $statistikUmur->umur_35_39,
                    $statistikUmur->umur_40_44,
                    $statistikUmur->umur_45_49,
                    $statistikUmur->umur_50_54,
                    $statistikUmur->umur_55_59,
                    $statistikUmur->umur_60_64,
                    $statistikUmur->umur_65_69,
                    $statistikUmur->umur_70_74,
                    $statistikUmur->umur_75_plus
                ],
                'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 2
            ]]
        ];
    }

    /**
     * Get chart data untuk tahun tertentu
     */
    private function getChartData($tahun)
    {
        $statistikUmur = UmurStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$statistikUmur) {
            return $this->getDummyChartData();
        }

        return $this->transformDatabaseData($statistikUmur);
    }

    /**
     * Data dummy jika tidak ada data
     */
    private function getDummyChartData()
    {
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
                '50-54',
                '55-59',
                '60-64',
                '65-69',
                '70-74',
                '75+'
            ],
            'datasets' => [[
                'label' => 'Jumlah Penduduk',
                'data' => [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 2
            ]]
        ];
    }

    /**
     * API endpoint untuk chart data
     */
    public function chartData(Request $request)
    {
        $tahun = $request->get('tahun', $this->getTahunTerbaru()->tahun);

        return response()->json([
            'chartData' => $this->getChartData($tahun),
            'tahun' => $tahun
        ]);
    }
}

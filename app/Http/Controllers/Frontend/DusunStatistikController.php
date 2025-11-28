<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DusunStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * DusunStatistikController - Khusus untuk data statistik dusun
 */
class DusunStatistikController extends Controller
{
    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::whereHas('dusunStatistik')
            ->orderBy('tahun', 'desc')
            ->first();

        if (!$tahunDataTerbaru) {
            $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();
        }

        return $tahunDataTerbaru ?: (object)['tahun' => date('Y'), 'id_tahun' => 1];
    }

    public function index(Request $request)
    {
        $tahun = $request->get('tahun', $this->getTahunTerbaru()->tahun);

        $dusunStatistik = DusunStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('jumlah_penduduk', 'desc')->get();

        $totalPenduduk = $dusunStatistik->sum('jumlah_penduduk');
        $totalKK = $dusunStatistik->sum('jumlah_kk');
        $chartData = $this->getChartData($tahun);

        return view('frontend.statistik.dusun', [
            'dusunStatistik' => $dusunStatistik,
            'totalPenduduk' => $totalPenduduk,
            'totalKK' => $totalKK,
            'chartData' => $chartData,
            'tahun' => $tahun
        ]);
    }

    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahun = $this->getTahunTerbaru()->tahun;
        }

        $dusunStatistik = DusunStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('jumlah_penduduk', 'desc')->get();

        if ($dusunStatistik->isEmpty()) {
            return [
                'dusunStatistik' => [],
                'dusunChart' => [],
                'totalPendudukDusun' => 0,
                'totalKKDusun' => 0,
                'dusunChartConfig' => [
                    'labels' => [],
                    'data' => [],
                    'percentages' => [],
                    'colors' => [],
                    'borderColors' => []
                ],
                'tahun' => $tahun,
                'isEmpty' => true
            ];
        }

        $totalPenduduk = $dusunStatistik->sum('jumlah_penduduk');
        $totalKK = $dusunStatistik->sum('jumlah_kk');

        // Format dusunChart sesuai yang diharapkan view
        $dusunChart = $dusunStatistik->map(function ($dusun) use ($totalPenduduk) {
            return [
                'label' => strtoupper($dusun->nama_dusun),
                'value' => $dusun->jumlah_penduduk,
                'percentage' => $totalPenduduk > 0 ? round(($dusun->jumlah_penduduk / $totalPenduduk) * 100, 2) : 0,
                'jumlah_kk' => $dusun->jumlah_kk
            ];
        });

        // Prepare data untuk chart
        $chartLabels = $dusunChart->pluck('label')->toArray();
        $chartData = $dusunChart->pluck('value')->toArray();
        $chartPercentages = $dusunChart->pluck('percentage')->toArray();

        // Color palette untuk chart
        $colors = [
            'rgba(59, 130, 246, 0.8)',   // Blue
            'rgba(34, 197, 94, 0.8)',    // Green  
            'rgba(251, 191, 36, 0.8)',   // Yellow
            'rgba(239, 68, 68, 0.8)',    // Red
            'rgba(168, 85, 247, 0.8)',   // Purple
        ];

        return [
            'dusunStatistik' => $dusunStatistik,
            'dusunChart' => $dusunChart,
            'totalPendudukDusun' => $totalPenduduk,
            'totalKKDusun' => $totalKK,
            'dusunChartConfig' => [
                'labels' => $chartLabels,
                'data' => $chartData,
                'percentages' => $chartPercentages,
                'colors' => array_slice($colors, 0, count($chartLabels)),
                'borderColors' => array_map(function ($color) {
                    return str_replace('0.8', '1', $color);
                }, array_slice($colors, 0, count($chartLabels)))
            ],
            'tahun' => $tahun,
            'isEmpty' => false
        ];
    }

    private function transformDatabaseData($dusunChart)
    {
        $colors = [
            'rgba(255, 99, 132, 0.8)',
            'rgba(54, 162, 235, 0.8)',
            'rgba(255, 205, 86, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 159, 64, 0.8)'
        ];

        return [
            'labels' => $dusunChart->pluck('label')->toArray(),
            'datasets' => [[
                'label' => 'Jumlah Penduduk',
                'data' => $dusunChart->pluck('value')->toArray(),
                'backgroundColor' => array_slice($colors, 0, $dusunChart->count()),
                'borderColor' => array_map(function ($color) {
                    return str_replace('0.8', '1', $color);
                }, array_slice($colors, 0, $dusunChart->count())),
                'borderWidth' => 2
            ]]
        ];
    }

    private function getChartData($tahun)
    {
        $dusunStatistik = DusunStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('jumlah_penduduk', 'desc')->get();

        if ($dusunStatistik->isEmpty()) {
            return $this->getDummyChartData();
        }

        $totalPenduduk = $dusunStatistik->sum('jumlah_penduduk');

        $dusunChart = $dusunStatistik->map(function ($dusun) use ($totalPenduduk) {
            return [
                'label' => $dusun->nama_dusun,
                'value' => $dusun->jumlah_penduduk,
                'percentage' => $totalPenduduk > 0 ? round(($dusun->jumlah_penduduk / $totalPenduduk) * 100, 1) : 0
            ];
        });

        return $this->transformDatabaseData($dusunChart);
    }

    private function getDummyChartData()
    {
        return [
            'labels' => [],
            'datasets' => [[
                'label' => 'Jumlah Penduduk',
                'data' => [],
                'backgroundColor' => [],
                'borderColor' => [],
                'borderWidth' => 2
            ]]
        ];
    }

    public function chartData(Request $request)
    {
        $tahun = $request->get('tahun', $this->getTahunTerbaru()->tahun);

        return response()->json([
            'chartData' => $this->getChartData($tahun),
            'tahun' => $tahun
        ]);
    }
}

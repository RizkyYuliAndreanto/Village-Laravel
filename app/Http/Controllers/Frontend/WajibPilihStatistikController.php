<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * WajibPilihStatistikController - Khusus untuk data wajib pilih
 */
class WajibPilihStatistikController extends Controller
{
    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::whereHas('wajibPilihStatistik')
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

        $statistikWajibPilih = WajibPilihStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        $chartData = $this->getChartData($tahun);

        return view('frontend.statistik.wajib-pilih', [
            'statistikWajibPilih' => $statistikWajibPilih,
            'chartData' => $chartData,
            'tahun' => $tahun
        ]);
    }

    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahun = $this->getTahunTerbaru()->tahun;
        }

        $statistikWajibPilih = WajibPilihStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$statistikWajibPilih) {
            $dummyChartData = $this->getDummyChartData();
            return [
                'totalWajibPilih' => 0,
                'lakiLaki' => 0,
                'perempuan' => 0,
                'chartData' => $dummyChartData,
                'wajibPilihLabels' => $dummyChartData['labels'],
                'wajibPilihTotals' => $dummyChartData['datasets'][0]['data'],
                'tahun' => $tahun,
                'isEmpty' => true
            ];
        }

        $chartData = $this->transformDatabaseData($statistikWajibPilih);

        return [
            'totalWajibPilih' => $statistikWajibPilih->total,
            'lakiLaki' => $statistikWajibPilih->laki_laki,
            'perempuan' => $statistikWajibPilih->perempuan,
            'chartData' => $chartData,
            'wajibPilihLabels' => $chartData['labels'],
            'wajibPilihTotals' => $chartData['datasets'][0]['data'],
            'tahun' => $tahun,
            'isEmpty' => false
        ];
    }

    private function transformDatabaseData($statistikWajibPilih)
    {
        return [
            'labels' => ['Laki-laki', 'Perempuan'],
            'datasets' => [[
                'label' => 'Wajib Pilih',
                'data' => [$statistikWajibPilih->laki_laki, $statistikWajibPilih->perempuan],
                'backgroundColor' => ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                'borderColor' => ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                'borderWidth' => 2
            ]]
        ];
    }

    private function getChartData($tahun)
    {
        $statistikWajibPilih = WajibPilihStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$statistikWajibPilih) {
            return $this->getDummyChartData();
        }

        return $this->transformDatabaseData($statistikWajibPilih);
    }

    private function getDummyChartData()
    {
        return [
            'labels' => ['Laki-laki', 'Perempuan'],
            'datasets' => [[
                'label' => 'Wajib Pilih',
                'data' => [0, 0],
                'backgroundColor' => ['rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)'],
                'borderColor' => ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use App\Models\UmurStatistik;
use App\Models\AgamaStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function index(Request $request)
    {
        $tahunTersedia = TahunData::orderBy('tahun', 'DESC')->get();
        $tahun = $request->get('tahun');

        $tahunDataTerbaru = TahunData::orderBy('tahun', 'DESC')->first();
        $tahunAktif = $tahun ?? ($tahunDataTerbaru->tahun ?? date('Y'));

        // DEMOGRAFI
        $demografi = DemografiPenduduk::where('tahun', $tahunAktif)->first();

        // DATA UMUR
        $umurRow = UmurStatistik::where('tahun', $tahunAktif)->first();
        $statistikUmur = UmurStatistik::where('tahun', $tahunAktif)
            ->orderBy('kelompok_umur')
            ->get();

        // DATA AGAMA
        $agama = AgamaStatistik::where('tahun', $tahunAktif)->first();
        $statistikAgama = AgamaStatistik::where('tahun', $tahunAktif)
            ->orderBy('total_jiwa', 'desc')
            ->get();

        // DATA PEKERJAAN
        $pekerjaan = PekerjaanStatistik::where('tahun', $tahunAktif)->first();
        $topPekerjaan = PekerjaanStatistik::where('tahun', $tahunAktif)
            ->orderBy('total_jiwa', 'desc')
            ->limit(5)
            ->get();

        // DATA PENDIDIKAN
        $pendidikan = PendidikanStatistik::where('tahun', $tahunAktif)->first();
        $topPendidikan = PendidikanStatistik::where('tahun', $tahunAktif)
            ->orderBy('total_jiwa', 'desc')
            ->limit(5)
            ->get();

        // CHART
        $chartDataUmur = $this->getChartDataUmur($statistikUmur);
        $chartDataAgama = $this->getChartDataAgama($statistikAgama);

        return view('frontend.Infografis.index', [
            'tahunTersedia' => $tahunTersedia,
            'tahunDataTerbaru' => $tahunDataTerbaru,
            'tahunAktif' => $tahunAktif,

            'demografi' => $demografi,
            'totalPenduduk' => optional($demografi)->total_jiwa ?? 0,
            'totalLaki' => optional($demografi)->laki_laki ?? 0,
            'totalPerempuan' => optional($demografi)->perempuan ?? 0,
            'pendudukSementara' => optional($demografi)->penduduk_sementara ?? 0,
            'mutasiPenduduk' => optional($demografi)->mutasi_penduduk ?? 0,

            // UMUR
            'statistikUmur' => $statistikUmur,
            'umurData' => $umurRow,

            // AGAMA
            'agama' => $agama,
            'statistikAgama' => $statistikAgama,

            // PEKERJAAN
            'pekerjaan' => $pekerjaan,
            'topPekerjaan' => $topPekerjaan,

            // PENDIDIKAN
            'pendidikan' => $pendidikan,
            'topPendidikan' => $topPendidikan,

            // CHART
            'chartDataUmur' => $chartDataUmur,
            'chartDataAgama' => $chartDataAgama,
        ]);
    }

    private function getChartDataUmur($data)
    {
        if ($data->isEmpty()) {
            return [
                'labels' => [],
                'datasets' => [
                    ['label' => 'Laki-laki', 'data' => []],
                    ['label' => 'Perempuan', 'data' => []],
                ]
            ];
        }

        return [
            'labels' => $data->pluck('kelompok_umur'),
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => $data->pluck('laki_laki'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)'
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $data->pluck('perempuan'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.8)'
                ]
            ]
        ];
    }

    private function getChartDataAgama($data)
    {
        if ($data->isEmpty()) {
            return [
                'labels' => [],
                'datasets' => [[
                    'data' => [],
                    'backgroundColor' => []
                ]]
            ];
        }

        return [
            'labels' => $data->pluck('agama'),
            'datasets' => [[
                'data' => $data->pluck('total_jiwa'),
                'backgroundColor' => [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                    '#9966FF', '#FF9F40', '#8BC34A'
                ]
            ]]
        ];
    }
}

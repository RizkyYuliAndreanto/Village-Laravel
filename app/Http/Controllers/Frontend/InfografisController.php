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

/**
 * InfografisController - Khusus untuk halaman infografis
 * 
 * Controller ini menangani halaman infografis yang menampilkan
 * ringkasan data demografi dalam bentuk visual yang menarik
 */
class InfografisController extends Controller
{
    /**
     * Halaman Infografis Utama
     * Route: GET /infografis
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        // Ambil tahun data terbaru jika tidak ada data untuk tahun yang diminta
        $tahunDataTerbaru = TahunData::latest('tahun')->first();
        if (!$tahunDataTerbaru) {
            $tahunDataTerbaru = (object)['tahun' => date('Y')];
        }

        // Data demografi utama
        $demografi = DemografiPenduduk::where('tahun', $tahun)->first();
        if (!$demografi) {
            $demografi = DemografiPenduduk::latest('tahun')->first();
            $tahun = $demografi->tahun ?? date('Y');
        }

        // Jika masih tidak ada data, buat data dummy untuk demo
        if (!$demografi) {
            $demografi = (object)[
                'total_jiwa' => 5420,
                'laki_laki' => 2710,
                'perempuan' => 2710,
                'kepala_keluarga' => 1355,
                'tahun' => $tahun
            ];
        }

        // Statistik tambahan untuk infografis
        $statistikUmur = UmurStatistik::where('tahun', $tahun)->orderBy('kelompok_umur')->get();
        $statistikAgama = AgamaStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();
        $topPekerjaan = PekerjaanStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->limit(5)->get();
        $topPendidikan = PendidikanStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->limit(5)->get();

        // Data untuk chart (jika diperlukan)
        $chartDataUmur = $this->getChartDataUmur($tahun);
        $chartDataAgama = $this->getChartDataAgama($tahun);

        return view('frontend.Infografis.index', [
            'tahunDataTerbaru' => $tahunDataTerbaru,
            'totalPenduduk' => $demografi->total_jiwa ?? 5420,
            'totalLaki' => $demografi->laki_laki ?? 2710,
            'totalPerempuan' => $demografi->perempuan ?? 2710,
            'pendudukSementara' => 150, // Data dummy untuk penduduk sementara
            'mutasiPenduduk' => 85, // Data dummy untuk mutasi penduduk
            'demografi' => $demografi,
            'statistikUmur' => $statistikUmur,
            'statistikAgama' => $statistikAgama,
            'topPekerjaan' => $topPekerjaan,
            'topPendidikan' => $topPendidikan,
            'chartDataUmur' => $chartDataUmur,
            'chartDataAgama' => $chartDataAgama,
            'tahun' => $tahun
        ]);
    }

    /**
     * Data chart untuk statistik umur
     * 
     * @param int $tahun
     * @return array
     */
    private function getChartDataUmur($tahun)
    {
        $data = UmurStatistik::where('tahun', $tahun)->orderBy('kelompok_umur')->get();

        if ($data->isEmpty()) {
            // Data dummy jika tidak ada data
            return [
                'labels' => ['0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60+'],
                'datasets' => [
                    [
                        'label' => 'Laki-laki',
                        'data' => [180, 220, 250, 280, 320, 380, 420, 390, 350, 280, 220, 180, 320],
                        'backgroundColor' => 'rgba(54, 162, 235, 0.8)'
                    ],
                    [
                        'label' => 'Perempuan',
                        'data' => [170, 210, 240, 270, 310, 370, 410, 380, 340, 270, 210, 170, 350],
                        'backgroundColor' => 'rgba(255, 99, 132, 0.8)'
                    ]
                ]
            ];
        }

        return [
            'labels' => $data->pluck('kelompok_umur')->toArray(),
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => $data->pluck('laki_laki')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)'
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $data->pluck('perempuan')->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.8)'
                ]
            ]
        ];
    }

    /**
     * Data chart untuk statistik agama
     * 
     * @param int $tahun
     * @return array
     */
    private function getChartDataAgama($tahun)
    {
        $data = AgamaStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();

        if ($data->isEmpty()) {
            // Data dummy jika tidak ada data
            return [
                'labels' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'],
                'datasets' => [[
                    'data' => [4850, 320, 180, 50, 20],
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF'
                    ]
                ]]
            ];
        }

        return [
            'labels' => $data->pluck('agama')->toArray(),
            'datasets' => [[
                'data' => $data->pluck('total_jiwa')->toArray(),
                'backgroundColor' => [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            ]]
        ];
    }
}

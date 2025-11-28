<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * Frontend DemografiController - Untuk menampilkan data kependudukan dan statistik desa
 * 
 * Controller ini menyediakan semua data statistik demografi:
 * - Data demografi umum
 * - Statistik berdasarkan umur, agama, pekerjaan, pendidikan
 * - Data per tahun dengan perbandingan
 * - Widget dan chart data untuk dashboard
 */
class DemografiController extends Controller
{
    /**
     * Dashboard demografi lengkap
     * Route: GET /demografi
     * 
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        // Data demografi utama
        $demografi = DemografiPenduduk::where('tahun', $tahun)->first();

        if (!$demografi) {
            $demografi = DemografiPenduduk::latest('tahun')->first();
            $tahun = $demografi->tahun ?? date('Y');
        }

        // Statistik detail per kategori
        $statistikUmur = UmurStatistik::where('tahun', $tahun)->orderBy('kelompok_umur')->get();
        $statistikAgama = AgamaStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();
        $statistikPekerjaan = PekerjaanStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();
        $statistikPendidikan = PendidikanStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();
        $statistikPerkawinan = PerkawinanStatistik::where('tahun', $tahun)->get();
        $statistikWajibPilih = WajibPilihStatistik::where('tahun', $tahun)->get();

        // Data tahun yang tersedia
        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();

        // Perbandingan dengan tahun sebelumnya
        $tahunSebelumnya = $tahun - 1;
        $demografiSebelumnya = DemografiPenduduk::where('tahun', $tahunSebelumnya)->first();

        return [
            'demografi' => $demografi,
            'demografiSebelumnya' => $demografiSebelumnya,
            'statistikUmur' => $statistikUmur,
            'statistikAgama' => $statistikAgama,
            'statistikPekerjaan' => $statistikPekerjaan,
            'statistikPendidikan' => $statistikPendidikan,
            'statistikPerkawinan' => $statistikPerkawinan,
            'statistikWajibPilih' => $statistikWajibPilih,
            'tahunTersedia' => $tahunTersedia,
            'tahunTerpilih' => $tahun
        ];
    }

    /**
     * Data demografi umum saja
     * Route: GET /demografi/umum
     * 
     * @param Request $request
     * @return array
     */
    public function umum(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $demografi = DemografiPenduduk::where('tahun', $tahun)->first();

        if (!$demografi) {
            $demografi = DemografiPenduduk::latest('tahun')->first();
        }

        return [
            'demografi' => $demografi,
            'tahun' => $tahun
        ];
    }

    /**
     * Statistik berdasarkan umur
     * Route: GET /demografi/umur
     * 
     * @param Request $request
     * @return array
     */
    public function umur(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $statistikUmur = UmurStatistik::where('tahun', $tahun)
            ->orderBy('kelompok_umur')
            ->get();

        // Total untuk persentase
        $totalJiwa = $statistikUmur->sum('total_jiwa');

        // Data chart
        $chartData = [
            'labels' => $statistikUmur->pluck('kelompok_umur')->toArray(),
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => $statistikUmur->pluck('laki_laki')->toArray(),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.8)'
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $statistikUmur->pluck('perempuan')->toArray(),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.8)'
                ]
            ]
        ];

        return [
            'statistikUmur' => $statistikUmur,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahun
        ];
    }

    /**
     * Statistik berdasarkan agama
     * Route: GET /demografi/agama
     * 
     * @param Request $request
     * @return array
     */
    public function agama(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $statistikAgama = AgamaStatistik::where('tahun', $tahun)
            ->orderBy('total_jiwa', 'desc')
            ->get();

        $totalJiwa = $statistikAgama->sum('total_jiwa');

        // Data untuk pie chart
        $chartData = [
            'labels' => $statistikAgama->pluck('agama')->toArray(),
            'datasets' => [[
                'data' => $statistikAgama->pluck('total_jiwa')->toArray(),
                'backgroundColor' => [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40',
                    '#FF6384',
                    '#C9CBCF'
                ]
            ]]
        ];

        return [
            'statistikAgama' => $statistikAgama,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahun
        ];
    }

    /**
     * Statistik berdasarkan pekerjaan
     * Route: GET /demografi/pekerjaan
     * 
     * @param Request $request
     * @return array
     */
    public function pekerjaan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $statistikPekerjaan = PekerjaanStatistik::where('tahun', $tahun)
            ->orderBy('total_jiwa', 'desc')
            ->get();

        $totalJiwa = $statistikPekerjaan->sum('total_jiwa');

        return [
            'statistikPekerjaan' => $statistikPekerjaan,
            'totalJiwa' => $totalJiwa,
            'tahun' => $tahun
        ];
    }

    /**
     * Statistik berdasarkan pendidikan
     * Route: GET /demografi/pendidikan
     * 
     * @param Request $request
     * @return array
     */
    public function pendidikan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        $statistikPendidikan = PendidikanStatistik::where('tahun', $tahun)
            ->orderBy('total_jiwa', 'desc')
            ->get();

        $totalJiwa = $statistikPendidikan->sum('total_jiwa');

        // Data untuk horizontal bar chart
        $chartData = [
            'labels' => $statistikPendidikan->pluck('tingkat_pendidikan')->toArray(),
            'datasets' => [[
                'label' => 'Jumlah Jiwa',
                'data' => $statistikPendidikan->pluck('total_jiwa')->toArray(),
                'backgroundColor' => 'rgba(75, 192, 192, 0.8)'
            ]]
        ];

        return [
            'statistikPendidikan' => $statistikPendidikan,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahun
        ];
    }

    /**
     * Perbandingan data antar tahun
     * Route: GET /demografi/perbandingan
     * 
     * @param Request $request
     * @return array
     */
    public function perbandingan(Request $request)
    {
        $tahun1 = $request->get('tahun1', date('Y') - 1);
        $tahun2 = $request->get('tahun2', date('Y'));

        $demografi1 = DemografiPenduduk::where('tahun', $tahun1)->first();
        $demografi2 = DemografiPenduduk::where('tahun', $tahun2)->first();

        $perbandingan = [];

        if ($demografi1 && $demografi2) {
            $perbandingan = [
                'total_jiwa' => [
                    'tahun1' => $demografi1->total_jiwa,
                    'tahun2' => $demografi2->total_jiwa,
                    'selisih' => $demografi2->total_jiwa - $demografi1->total_jiwa,
                    'persentase' => $demografi1->total_jiwa > 0 ?
                        round((($demografi2->total_jiwa - $demografi1->total_jiwa) / $demografi1->total_jiwa) * 100, 2) : 0
                ],
                'laki_laki' => [
                    'tahun1' => $demografi1->laki_laki,
                    'tahun2' => $demografi2->laki_laki,
                    'selisih' => $demografi2->laki_laki - $demografi1->laki_laki
                ],
                'perempuan' => [
                    'tahun1' => $demografi1->perempuan,
                    'tahun2' => $demografi2->perempuan,
                    'selisih' => $demografi2->perempuan - $demografi1->perempuan
                ]
            ];
        }

        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();

        return [
            'demografi1' => $demografi1,
            'demografi2' => $demografi2,
            'perbandingan' => $perbandingan,
            'tahun1' => $tahun1,
            'tahun2' => $tahun2,
            'tahunTersedia' => $tahunTersedia
        ];
    }

    /**
     * Widget demografi untuk homepage/dashboard
     * Route: GET /api/demografi/widget
     * 
     * @return array
     */
    public function widget()
    {
        $tahunTerbaru = TahunData::latest('tahun')->first();
        $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');

        $demografi = DemografiPenduduk::where('tahun', $tahun)->first();

        $ringkasan = [];
        if ($demografi) {
            $ringkasan = [
                'total_jiwa' => $demografi->total_jiwa,
                'laki_laki' => $demografi->laki_laki,
                'perempuan' => $demografi->perempuan,
                'kepala_keluarga' => $demografi->kepala_keluarga,
                'tahun' => $tahun
            ];
        }

        // Top 3 agama
        $topAgama = AgamaStatistik::where('tahun', $tahun)
            ->orderBy('total_jiwa', 'desc')
            ->limit(3)
            ->get(['agama', 'total_jiwa']);

        // Top 3 pekerjaan
        $topPekerjaan = PekerjaanStatistik::where('tahun', $tahun)
            ->orderBy('total_jiwa', 'desc')
            ->limit(3)
            ->get(['pekerjaan', 'total_jiwa']);

        return [
            'ringkasan' => $ringkasan,
            'topAgama' => $topAgama,
            'topPekerjaan' => $topPekerjaan,
            'tahun' => $tahun
        ];
    }

    /**
     * Halaman infografis untuk frontend  
     * Route: GET /infografis
     *
     * @return \Illuminate\View\View
     */
    public function infografis()
    {
        // Ambil tahun data terbaru
        $tahunDataTerbaru = $this->getTahunTerbaru();

        // Data untuk setiap section
        $demografiData = $this->getDemografiData($tahunDataTerbaru->tahun);
        $umurData = $this->getUmurData();
        $pendidikanData = $this->getPendidikanData();
        $pekerjaanData = $this->getPekerjaanData();
        $wajibPilihData = $this->getWajibPilihData();
        $perkawinanData = $this->getPerkawinanData();
        $agamaData = $this->getAgamaData();
        $dusunData = $this->getDusunData($tahunDataTerbaru->tahun);

        return view('frontend.Infografis.index', array_merge(
            $demografiData,
            $umurData,
            $pendidikanData,
            $pekerjaanData,
            $wajibPilihData,
            $perkawinanData,
            $agamaData,
            $dusunData,
            ['tahunDataTerbaru' => $tahunDataTerbaru]
        ));
    }

    /**
     * Get tahun data terbaru yang memiliki data statistik
     */
    private function getTahunTerbaru()
    {
        // Cari tahun terbaru yang memiliki data umur statistik
        $tahunDataTerbaru = TahunData::whereHas('umurStatistik')
            ->orderBy('tahun', 'desc')
            ->first();

        // Jika tidak ada, cari tahun terbaru yang ada
        if (!$tahunDataTerbaru) {
            $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();
        }

        if (!$tahunDataTerbaru) {
            return (object)['tahun' => date('Y')];
        }

        return $tahunDataTerbaru;
    }

    /**
     * Get data demografi untuk section statistik
     */
    private function getDemografiData($tahun)
    {
        $demografi = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$demografi) {
            $demografi = (object)[
                'total_penduduk' => 5420,
                'laki_laki' => 2710,
                'perempuan' => 2710,
                'penduduk_sementara' => 150,
                'mutasi_penduduk' => 85
            ];
        }

        return [
            'totalPenduduk' => $demografi->total_penduduk ?? 5420,
            'totalLaki' => $demografi->laki_laki ?? 2710,
            'totalPerempuan' => $demografi->perempuan ?? 2710,
            'pendudukSementara' => $demografi->penduduk_sementara ?? 150,
            'mutasiPenduduk' => $demografi->mutasi_penduduk ?? 85,
            'demografi' => $demografi,
            'tahun' => $tahun
        ];
    }

    /**
     * Get data umur untuk section piramida penduduk
     */
    private function getUmurData()
    {
        $umurController = new UmurController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $umurController->getData($tahun);
    }

    /**
     * Get data pendidikan untuk section pendidikan
     */
    private function getPendidikanData()
    {
        $pendidikanController = new PendidikanController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $pendidikanController->getData($tahun);
    }

    /**
     * Get data pekerjaan untuk section pekerjaan
     */
    private function getPekerjaanData()
    {
        $pekerjaanController = new PekerjaanController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $pekerjaanController->getData($tahun);
    }

    /**
     * Get data wajib pilih untuk section wajib pilih
     */
    private function getWajibPilihData()
    {
        $perkawinanController = new PerkawinanController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $perkawinanController->getWajibPilihData($tahun);
    }

    /**
     * Get data perkawinan untuk section perkawinan
     */
    private function getPerkawinanData()
    {
        $perkawinanController = new PerkawinanController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $perkawinanController->getData($tahun);
    }

    /**
     * Get data agama untuk section agama
     */
    private function getAgamaData()
    {
        $agamaController = new AgamaController();
        $tahun = $this->getTahunTerbaru()->tahun;
        return $agamaController->getData($tahun);
    }

    /**
     * Data untuk chart/grafik (JSON response)
    }



    /**
     * Data untuk chart/grafik (JSON response)
     * Route: GET /api/demografi/chart/{type}
     * 
     * @param string $type
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chart($type, Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $chartData = [];

        switch ($type) {
            case 'umur':
                $data = UmurStatistik::where('tahun', $tahun)->orderBy('kelompok_umur')->get();
                $chartData = [
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
                break;

            case 'agama':
                $data = AgamaStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->get();
                $chartData = [
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
                break;

            case 'pekerjaan':
                $data = PekerjaanStatistik::where('tahun', $tahun)->orderBy('total_jiwa', 'desc')->limit(10)->get();
                $chartData = [
                    'labels' => $data->pluck('pekerjaan')->toArray(),
                    'datasets' => [[
                        'label' => 'Jumlah Jiwa',
                        'data' => $data->pluck('total_jiwa')->toArray(),
                        'backgroundColor' => 'rgba(75, 192, 192, 0.8)'
                    ]]
                ];
                break;

            case 'trend':
                // Trend populasi 5 tahun terakhir
                $tahunAwal = $tahun - 4;
                $trendData = DemografiPenduduk::whereBetween('tahun', [$tahunAwal, $tahun])
                    ->orderBy('tahun')
                    ->get();

                $chartData = [
                    'labels' => $trendData->pluck('tahun')->toArray(),
                    'datasets' => [[
                        'label' => 'Total Jiwa',
                        'data' => $trendData->pluck('total_jiwa')->toArray(),
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'fill' => true
                    ]]
                ];
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'tahun' => $tahun,
            'type' => $type
        ]);
    }

    /**
     * API endpoint untuk data dusun
     */
    public function apiDusun(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $dusunData = $this->getDusunData($tahun);

        return response()->json([
            'success' => true,
            'dusunData' => $dusunData,
            'tahun' => $tahun
        ]);
    }

    /**
     * Get data dusun untuk section infografis
     */
    private function getDusunData($tahun)
    {
        // Ambil data dusun berdasarkan tahun
        $dusunStatistik = DusunStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('jumlah_penduduk', 'desc')->get();

        // Jika tidak ada data, buat data dummy
        if ($dusunStatistik->isEmpty()) {
            $dusunStatistik = collect([
                (object)['nama_dusun' => 'TAMANG', 'jumlah_penduduk' => 395, 'jumlah_kk' => 120],
                (object)['nama_dusun' => 'LUBANG LANDAK', 'jumlah_penduduk' => 548, 'jumlah_kk' => 165],
                (object)['nama_dusun' => 'SENGKABANG', 'jumlah_penduduk' => 477, 'jumlah_kk' => 142],
                (object)['nama_dusun' => 'BAA', 'jumlah_penduduk' => 283, 'jumlah_kk' => 85],
            ]);
        }

        $totalPenduduk = $dusunStatistik->sum('jumlah_penduduk');
        $totalKK = $dusunStatistik->sum('jumlah_kk');

        // Hitung persentase untuk pie chart
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
            ]
        ];
    }
}

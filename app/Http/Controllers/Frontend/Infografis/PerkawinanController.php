<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PerkawinanController - Handle data perkawinan dan wajib pilih
 * 
 * Responsibilities:
 * - Data statistik status perkawinan
 * - Data wajib pilih dalam pemilu
 * - Grid cards status perkawinan
 * - Chart wajib pilih
 */
class PerkawinanController extends Controller
{
    /**
     * Get data perkawinan
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
        $statistikPerkawinan = PerkawinanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->get();

        if ($statistikPerkawinan->isEmpty()) {
            // Data dummy jika tidak ada data real
            return $this->getDummyData();
        }

        // Transform database data
        return $this->transformDatabaseData($statistikPerkawinan);
    }

    /**
     * Data dummy untuk testing
     */
    private function getDummyData()
    {
        return [
            'perkawinan' => (object)[
                'kawin' => 2150,
                'cerai_mati' => 180,
                'cerai_hidup' => 95,
                'kawin_tercatat' => 2050,
                'kawin_tidak_tercatat' => 100
            ],
            'belumKawin' => 1295
        ];
    }

    /**
     * Transform database data ke format view
     */
    private function transformDatabaseData($statistikPerkawinan)
    {
        $data = $statistikPerkawinan->first();

        // Hitung belum kawin dari demografi total - total perkawinan
        $totalKawin = ($data->kawin ?? 0) + ($data->cerai_hidup ?? 0) + ($data->cerai_mati ?? 0);

        return [
            'perkawinan' => (object)[
                'kawin' => $data->kawin ?? 0,
                'cerai_mati' => $data->cerai_mati ?? 0,
                'cerai_hidup' => $data->cerai_hidup ?? 0,
                'kawin_tercatat' => $data->kawin_tercatat ?? 0,
                'kawin_tidak_tercatat' => $data->kawin_tidak_tercatat ?? 0
            ],
            'belumKawin' => 1295 // atau bisa dihitung dari demografi total - total yang sudah kawin
        ];
    }

    /**
     * Get data wajib pilih
     */
    public function getWajibPilihData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // Coba ambil data dari database  
        $statistikWajibPilih = WajibPilihStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$statistikWajibPilih) {
            // Data dummy jika tidak ada data real
            return [
                'wajibPilihLabels' => ['Wajib Pilih', 'Tidak Wajib Pilih'],
                'wajibPilihTotals' => [3520, 1900]
            ];
        }

        // Hitung jumlah yang tidak wajib pilih (asumsi total penduduk - wajib pilih)
        $totalPenduduk = 5420; // Bisa diambil dari demografi jika diperlukan
        $tidakWajibPilih = max(0, $totalPenduduk - $statistikWajibPilih->total);

        return [
            'wajibPilihLabels' => ['Wajib Pilih', 'Tidak Wajib Pilih'],
            'wajibPilihTotals' => [$statistikWajibPilih->total, $tidakWajibPilih]
        ];
    }

    /**
     * API endpoint untuk data perkawinan
     * Route: GET /api/infografis/perkawinan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * API endpoint untuk data wajib pilih
     * Route: GET /api/infografis/wajib-pilih
     */
    public function apiWajibPilih(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getWajibPilihData($tahun);

        return response()->json($data);
    }

    /**
     * Get data untuk grid cards perkawinan
     */
    public function getGridData($tahun = null)
    {
        $data = $this->getData($tahun);
        $perkawinanData = $data['perkawinan'];
        $belumKawin = $data['belumKawin'];

        return [
            ['status' => 'Belum Kawin', 'jumlah' => $belumKawin, 'icon' => 'single'],
            ['status' => 'Kawin', 'jumlah' => $perkawinanData->kawin ?? 0, 'icon' => 'married'],
            ['status' => 'Cerai Mati', 'jumlah' => $perkawinanData->cerai_mati ?? 0, 'icon' => 'widowed'],
            ['status' => 'Cerai Hidup', 'jumlah' => $perkawinanData->cerai_hidup ?? 0, 'icon' => 'divorced'],
            ['status' => 'Kawin Tercatat', 'jumlah' => $perkawinanData->kawin_tercatat ?? 0, 'icon' => 'registered'],
            ['status' => 'Kawin Tidak Tercatat', 'jumlah' => $perkawinanData->kawin_tidak_tercatat ?? 0, 'icon' => 'unregistered']
        ];
    }

    /**
     * Get analisis perkawinan
     */
    public function getAnalisis($tahun = null)
    {
        $data = $this->getData($tahun);
        $perkawinanData = (array)$data['perkawinan'];
        $belumKawin = $data['belumKawin'];

        $totalMenikah = ($perkawinanData['kawin'] ?? 0);
        $totalCerai = ($perkawinanData['cerai_mati'] ?? 0) + ($perkawinanData['cerai_hidup'] ?? 0);
        $totalPenduduk = array_sum($perkawinanData) + $belumKawin;

        return [
            'total_penduduk' => $totalPenduduk,
            'belum_kawin' => $belumKawin,
            'sudah_menikah' => $totalMenikah,
            'cerai' => $totalCerai,
            'persentase_menikah' => $totalPenduduk > 0 ? round(($totalMenikah / $totalPenduduk) * 100, 2) : 0,
            'persentase_belum_kawin' => $totalPenduduk > 0 ? round(($belumKawin / $totalPenduduk) * 100, 2) : 0,
            'tingkat_perceraian' => $totalMenikah > 0 ? round(($totalCerai / $totalMenikah) * 100, 2) : 0,
            'kawin_tercatat' => $perkawinanData['kawin_tercatat'] ?? 0,
            'kawin_tidak_tercatat' => $perkawinanData['kawin_tidak_tercatat'] ?? 0
        ];
    }

    /**
     * Get data untuk chart pie perkawinan
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $perkawinanData = (array)$data['perkawinan'];
        $belumKawin = $data['belumKawin'];

        return [
            'labels' => [
                'Belum Kawin',
                'Kawin',
                'Cerai Mati',
                'Cerai Hidup'
            ],
            'datasets' => [
                [
                    'data' => [
                        $belumKawin,
                        $perkawinanData['kawin'] ?? 0,
                        $perkawinanData['cerai_mati'] ?? 0,
                        $perkawinanData['cerai_hidup'] ?? 0
                    ],
                    'backgroundColor' => [
                        '#36A2EB', // Blue - Belum Kawin
                        '#4BC0C0', // Teal - Kawin
                        '#FFCE56', // Yellow - Cerai Mati  
                        '#FF6384'  // Red - Cerai Hidup
                    ]
                ]
            ]
        ];
    }

    /**
     * Get chart data untuk wajib pilih
     */
    public function getWajibPilihChartData($tahun = null)
    {
        $data = $this->getWajibPilihData($tahun);

        return [
            'type' => 'bar',
            'data' => [
                'labels' => $data['wajibPilihLabels'],
                'datasets' => [
                    [
                        'data' => $data['wajibPilihTotals'],
                        'backgroundColor' => "#8b0000",
                        'borderRadius' => 6,
                        'barThickness' => 70
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'display' => false
                    ]
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'stepSize' => 300
                        ]
                    ]
                ]
            ]
        ];
    }
}

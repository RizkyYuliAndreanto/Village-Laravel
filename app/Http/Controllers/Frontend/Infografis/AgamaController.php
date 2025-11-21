<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\AgamaStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * AgamaController - Handle data agama
 * 
 * Responsibilities:
 * - Data statistik agama dan kepercayaan
 * - Grid cards agama
 * - Analisis keberagaman agama
 */
class AgamaController extends Controller
{
    /**
     * Get data agama
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
        $statistikAgama = AgamaStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->get();

        if ($statistikAgama->isEmpty()) {
            // Data dummy jika tidak ada data real
            return $this->getDummyData();
        }

        // Transform database data
        return $this->transformDatabaseData($statistikAgama);
    }

    /**
     * Data dummy untuk testing
     */
    private function getDummyData()
    {
        return [
            'agama' => (object)[
                'islam' => 4850,
                'katolik' => 180,
                'kristen' => 320,
                'hindu' => 50,
                'buddha' => 15,
                'konghucu' => 5,
                'kepercayaan_lain' => 0
            ]
        ];
    }

    /**
     * Transform database data ke format view
     */
    private function transformDatabaseData($statistikAgama)
    {
        $data = $statistikAgama->first();

        $agamaData = [
            'islam' => $data->islam ?? 0,
            'katolik' => $data->katolik ?? 0,
            'kristen' => $data->kristen ?? 0,
            'hindu' => $data->hindu ?? 0,
            'buddha' => $data->buddha ?? 0,
            'konghucu' => $data->konghucu ?? 0,
            'kepercayaan_lain' => $data->kepercayaan_lain ?? 0
        ];

        // Sort by total (descending) 
        arsort($agamaData);

        return [
            'agama' => (object)$agamaData
        ];
    }

    /**
     * API endpoint untuk data agama
     * Route: GET /api/infografis/agama
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * Get data untuk grid cards agama
     */
    public function getGridData($tahun = null)
    {
        $data = $this->getData($tahun);
        $agamaData = $data['agama'];

        return [
            ['nama' => 'Islam', 'jumlah' => $agamaData->islam ?? 0, 'icon' => 'islam'],
            ['nama' => 'Katolik', 'jumlah' => $agamaData->katolik ?? 0, 'icon' => 'katolik'],
            ['nama' => 'Kristen', 'jumlah' => $agamaData->kristen ?? 0, 'icon' => 'kristen'],
            ['nama' => 'Hindu', 'jumlah' => $agamaData->hindu ?? 0, 'icon' => 'hindu'],
            ['nama' => 'Buddha', 'jumlah' => $agamaData->buddha ?? 0, 'icon' => 'buddha'],
            ['nama' => 'Konghucu', 'jumlah' => $agamaData->konghucu ?? 0, 'icon' => 'konghucu'],
            ['nama' => 'Kepercayaan Lainnya', 'jumlah' => $agamaData->kepercayaan_lain ?? 0, 'icon' => 'lainnya']
        ];
    }

    /**
     * Get analisis agama
     */
    public function getAnalisis($tahun = null)
    {
        $data = $this->getData($tahun);
        $agamaData = (array)$data['agama'];

        $total = array_sum($agamaData);
        $agama_mayoritas = array_keys($agamaData, max($agamaData))[0] ?? 'islam';
        $diversitas = count(array_filter($agamaData, function ($val) {
            return $val > 0;
        }));

        return [
            'total_penduduk' => $total,
            'agama_mayoritas' => $agama_mayoritas,
            'jumlah_mayoritas' => max($agamaData),
            'persentase_mayoritas' => $total > 0 ? round((max($agamaData) / $total) * 100, 2) : 0,
            'jumlah_agama' => $diversitas,
            'tingkat_diversitas' => $diversitas >= 5 ? 'Tinggi' : ($diversitas >= 3 ? 'Sedang' : 'Rendah'),
            'agama_minoritas' => $this->getMinoritas($agamaData)
        ];
    }

    /**
     * Get agama minoritas (yang ada tapi sedikit)
     */
    private function getMinoritas($agamaData)
    {
        $filtered = array_filter($agamaData, function ($val) {
            return $val > 0 && $val < 100;
        });
        return array_keys($filtered);
    }

    /**
     * Get ranking agama
     */
    public function getRanking($tahun = null)
    {
        $data = $this->getData($tahun);
        $agamaData = (array)$data['agama'];

        arsort($agamaData);

        $ranking = [];
        $no = 1;
        foreach ($agamaData as $agama => $jumlah) {
            if ($jumlah > 0) { // Hanya tampilkan yang ada pengikutnya
                $ranking[] = [
                    'ranking' => $no++,
                    'agama' => ucfirst($agama),
                    'jumlah' => $jumlah,
                    'persentase' => array_sum($agamaData) > 0 ?
                        round(($jumlah / array_sum($agamaData)) * 100, 2) : 0
                ];
            }
        }

        return $ranking;
    }

    /**
     * Get data untuk chart pie agama
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $agamaData = (array)$data['agama'];

        // Filter hanya yang memiliki data > 0
        $filteredData = array_filter($agamaData, function ($val) {
            return $val > 0;
        });

        return [
            'labels' => array_map('ucfirst', array_keys($filteredData)),
            'datasets' => [
                [
                    'data' => array_values($filteredData),
                    'backgroundColor' => [
                        '#4CAF50', // Islam - Green
                        '#2196F3', // Katolik - Blue  
                        '#FF9800', // Kristen - Orange
                        '#E91E63', // Hindu - Pink
                        '#9C27B0', // Buddha - Purple
                        '#607D8B', // Konghucu - Blue Grey
                        '#795548'  // Kepercayaan Lain - Brown
                    ]
                ]
            ]
        ];
    }
}

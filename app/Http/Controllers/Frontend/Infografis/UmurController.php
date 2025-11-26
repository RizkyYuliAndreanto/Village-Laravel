<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\UmurStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * UmurController - Handle data kelompok umur
 */
class UmurController extends Controller
{
    /**
     * Get data untuk view (Initial Load)
     * Mengembalikan object bersih agar aman di-cast ke array di Blade
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // Ambil data dari database (1 baris horizontal)
        $data = UmurStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // List kolom yang akan diambil
        $fields = [
            'umur_0_4', 'umur_5_9', 'umur_10_14', 'umur_15_19', 'umur_20_24',
            'umur_25_29', 'umur_30_34', 'umur_35_39', 'umur_40_44', 'umur_45_49', 
            'umur_50_plus'
        ];

        // Transformasi ke stdClass (Object Standar)
        $cleanData = [];
        foreach ($fields as $field) {
            $cleanData[$field] = $data->$field ?? 0;
        }

        return [
            'umurData' => (object) $cleanData
        ];
    }

    /**
     * Get data untuk Chart.js (API Call saat ganti tahun)
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $umurData = $data['umurData'];

        // Mapping nama kolom database ke Label Chart
        $categories = [
            '0-4'   => 'umur_0_4',
            '5-9'   => 'umur_5_9',
            '10-14' => 'umur_10_14',
            '15-19' => 'umur_15_19',
            '20-24' => 'umur_20_24',
            '25-29' => 'umur_25_29',
            '30-34' => 'umur_30_34',
            '35-39' => 'umur_35_39',
            '40-44' => 'umur_40_44',
            '45-49' => 'umur_45_49',
            '50+'   => 'umur_50_plus'
        ];

        $labels = array_keys($categories);
        $values = [];

        foreach ($categories as $col) {
            $values[] = $umurData->$col ?? 0;
        }

        // Estimasi Laki-laki (Negatif agar ke kiri) & Perempuan (Positif ke kanan)
        // Karena DB hanya menyimpan Total, kita bagi 2 (50:50)
        $dataLaki = array_map(fn($v) => -($v / 2), $values);
        $dataPerempuan = array_map(fn($v) => ($v / 2), $values);

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Laki-laki (Est.)',
                    'data' => $dataLaki,
                    'backgroundColor' => 'rgba(56, 161, 105, 0.8)'
                ],
                [
                    'label' => 'Perempuan (Est.)',
                    'data' => $dataPerempuan,
                    'backgroundColor' => 'rgba(244, 114, 182, 0.8)'
                ]
            ]
        ];
    }

    /**
     * Get insight text
     */
    public function getInsights($tahun = null)
    {
        $data = $this->getData($tahun);
        // Cast object ke array untuk perhitungan PHP
        $stats = (array) $data['umurData'];

        if (empty($stats) || array_sum($stats) == 0) {
            return [
                'kelompok_terbanyak' => '-', 
                'jumlah_terbanyak' => 0,
                'total_anak' => 0,
                'total_produktif' => 0,
                'total_lansia' => 0
            ];
        }

        // Cari nilai tertinggi
        $maxVal = max($stats);
        $maxKey = array_search($maxVal, $stats);
        
        // Format key (umur_25_29 -> 25-29)
        $labelTerbanyak = str_replace(['umur_', '_plus', '_'], ['', '+', '-'], $maxKey);

        return [
            'kelompok_terbanyak' => $labelTerbanyak,
            'jumlah_terbanyak' => $maxVal,
            'total_anak' => ($stats['umur_0_4']??0) + ($stats['umur_5_9']??0) + ($stats['umur_10_14']??0),
            'total_produktif' => ($stats['umur_15_19']??0) + ($stats['umur_20_24']??0) + ($stats['umur_25_29']??0) + ($stats['umur_30_34']??0) + ($stats['umur_35_39']??0) + ($stats['umur_40_44']??0) + ($stats['umur_45_49']??0),
            'total_lansia' => ($stats['umur_50_plus']??0)
        ];
    }
    
    // API endpoint standar
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getData($tahun));
    }
}
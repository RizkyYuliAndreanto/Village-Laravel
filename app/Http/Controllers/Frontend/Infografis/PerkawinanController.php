<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PerkawinanController - Handle data perkawinan dan wajib pilih
 */
class PerkawinanController extends Controller
{
    /**
     * Get data perkawinan (Status Perkawinan)
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // PERBAIKAN: Ambil satu baris data (first) karena struktur horizontal
        $data = PerkawinanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // Mapping manual kolom database ke object view
        // Kolom DB: kawin, cerai_hidup, cerai_mati, kawin_tercatat, kawin_tidak_tercatat
        // Perhatikan: Tidak ada kolom 'belum_kawin' di tabel perkawinan_statistik Anda
        // Jadi kita set default 0 atau perlu hitung dari total penduduk (jika ada datanya)
        
        $perkawinanObj = (object) [
            'kawin' => $data->kawin ?? 0,
            'cerai_mati' => $data->cerai_mati ?? 0,
            'cerai_hidup' => $data->cerai_hidup ?? 0,
            'kawin_tercatat' => $data->kawin_tercatat ?? 0,
            'kawin_tidak_tercatat' => $data->kawin_tidak_tercatat ?? 0,
        ];

        return [
            'perkawinan' => $perkawinanObj,
            'belumKawin' => 0 // Default 0 karena tidak ada kolomnya di tabel migrasi
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

        // PERBAIKAN: Ambil satu baris data (first)
        $data = WajibPilihStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // Siapkan data untuk chart (Laki-laki vs Perempuan)
        $labels = ['Laki-laki', 'Perempuan'];
        $totals = [
            $data->laki_laki ?? 0,
            $data->perempuan ?? 0
        ];

        // Total keseluruhan (untuk info tambahan jika perlu)
        $totalWajibPilih = $data->total ?? 0;

        return [
            'wajibPilihLabels' => $labels,
            'wajibPilihTotals' => $totals,
            'totalWajibPilih' => $totalWajibPilih
        ];
    }

    /**
     * API endpoint untuk data perkawinan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getData($tahun));
    }

    /**
     * API endpoint untuk data wajib pilih
     */
    public function apiWajibPilih(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getWajibPilihData($tahun));
    }

    /**
     * Get data untuk chart pie perkawinan (API Chart)
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $perkawinanData = $data['perkawinan'];
        $belumKawin = $data['belumKawin'];

        return [
            'labels' => ['Belum Kawin', 'Kawin', 'Cerai Mati', 'Cerai Hidup'],
            'datasets' => [
                [
                    'data' => [
                        $belumKawin,
                        $perkawinanData->kawin ?? 0,
                        $perkawinanData->cerai_mati ?? 0,
                        $perkawinanData->cerai_hidup ?? 0
                    ],
                    'backgroundColor' => ['#36A2EB', '#4BC0C0', '#FFCE56', '#FF6384']
                ]
            ]
        ];
    }

    /**
     * Get chart data untuk wajib pilih (API Chart)
     */
    public function getWajibPilihChartData($tahun = null)
    {
        $data = $this->getWajibPilihData($tahun);

        return [
            'labels' => $data['wajibPilihLabels'],
            'datasets' => [
                [
                    'label' => 'Total Jiwa',
                    'data' => $data['wajibPilihTotals'],
                    'backgroundColor' => ["#3b82f6", "#ec4899"], // Biru (L), Pink (P)
                    'borderRadius' => 6,
                    'barThickness' => 50
                ]
            ]
        ];
    }
    
    public function getAnalisis($tahun = null) {
        $data = $this->getData($tahun);
        $perkawinanData = $data['perkawinan'];
        
        // Hitung total dari data yang ada
        $total = ($perkawinanData->kawin ?? 0) + 
                 ($perkawinanData->cerai_mati ?? 0) + 
                 ($perkawinanData->cerai_hidup ?? 0);
        
        if ($total == 0) return ['total_penduduk' => 0];

        return [
            'total_penduduk' => $total,
            'persentase_menikah' => round((($perkawinanData->kawin ?? 0) / $total) * 100, 2)
        ];
    }
}   
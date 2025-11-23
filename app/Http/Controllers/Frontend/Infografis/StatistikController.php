<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * StatistikController - Handle statistik demografi dasar
 * 
 * Responsibilities:
 * - Data total penduduk, laki-laki, perempuan
 * - Penduduk sementara dan mutasi penduduk
 * - Statistik dasar untuk dashboard
 */
class StatistikController extends Controller
{
    /**
     * Get data statistik demografi dasar
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

        $demografi = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$demografi) {
            // Data dummy jika tidak ada data real
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
     * API endpoint untuk data statistik
     * Route: GET /api/infografis/statistik
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * Get perbandingan dengan tahun sebelumnya
     */
    public function getPerbandingan($tahun = null)
    {
        $dataSekarang = $this->getData($tahun);
        $tahunSebelumnya = ($tahun ?? date('Y')) - 1;
        $dataSebelumnya = $this->getData($tahunSebelumnya);

        return [
            'sekarang' => $dataSekarang,
            'sebelumnya' => $dataSebelumnya,
            'pertumbuhan' => [
                'total' => $dataSekarang['totalPenduduk'] - $dataSebelumnya['totalPenduduk'],
                'laki' => $dataSekarang['totalLaki'] - $dataSebelumnya['totalLaki'],
                'perempuan' => $dataSekarang['totalPerempuan'] - $dataSebelumnya['totalPerempuan']
            ]
        ];
    }
}

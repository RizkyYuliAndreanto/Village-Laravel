<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Ambil data statistik demografi berdasarkan tahun tertentu
     */
    public function getData($tahun = null)
    {
        // Tentukan tahun aktif
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru->tahun ?? date('Y');
        }

        // Ambil data demografi
        $demografi = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // Return data aman tanpa memanggil properti null
        return [
            'totalPenduduk'      => optional($demografi)->total_penduduk ?? 0,
            'totalLaki'          => optional($demografi)->laki_laki ?? 0,
            'totalPerempuan'     => optional($demografi)->perempuan ?? 0,
            'pendudukSementara'  => optional($demografi)->penduduk_sementara ?? 0,
            'mutasiPenduduk'     => optional($demografi)->mutasi_penduduk ?? 0,
            'demografi'          => $demografi,
            'tahun'              => $tahun
        ];
    }

    /**
     * Endpoint API
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getData($tahun));
    }

    /**
     * Bandingkan dua tahun
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

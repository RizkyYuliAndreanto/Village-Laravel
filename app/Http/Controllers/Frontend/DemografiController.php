<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * DemografiController - Khusus untuk data demografi umum saja
 */
class DemografiController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $demografi = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        if (!$demografi) {
            $demografi = DemografiPenduduk::with('tahunData')->latest('tahun_id')->first();
            $tahun = $demografi->tahunData->tahun ?? date('Y');
        }

        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();
        $tahunSebelumnya = $tahun - 1;
        $demografiSebelumnya = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahunSebelumnya) {
            $query->where('tahun', $tahunSebelumnya);
        })->first();

        return view('frontend.demografi.index', [
            'demografi' => $demografi,
            'demografiSebelumnya' => $demografiSebelumnya,
            'tahunTersedia' => $tahunTersedia,
            'tahun' => $tahun
        ]);
    }

    public function widget()
    {
        $tahunTerbaru = TahunData::latest('tahun')->first();
        $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        $demografi = DemografiPenduduk::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        $ringkasan = [];
        if ($demografi) {
            $ringkasan = [
                'total_penduduk' => $demografi->total_penduduk,
                'laki_laki' => $demografi->laki_laki,
                'perempuan' => $demografi->perempuan,
                'kepala_keluarga' => $demografi->kepala_keluarga ?? 0,
                'tahun' => $tahun
            ];
        }

        return response()->json(['ringkasan' => $ringkasan, 'tahun' => $tahun]);
    }
}

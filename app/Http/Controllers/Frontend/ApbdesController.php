<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DetailApbdes;
use App\Models\LaporanApbdes;
use App\Models\BidangApbdes;
use App\Models\TahunData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApbdesController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun yang tersedia
        $tahunTersedia = TahunData::whereHas('laporanApbdes', function ($query) {
            $query->where('status', 'diterbitkan');
        })
            ->orderBy('tahun', 'desc')
            ->get();

        // Ambil tahun yang dipilih atau tahun terbaru
        $tahunDipilih = $request->get('tahun', $tahunTersedia->first()?->tahun);

        $laporan = LaporanApbdes::with(['tahunData', 'detailApbdes.bidangApbdes'])
            ->when($tahunDipilih, function ($query) use ($tahunDipilih) {
                $query->whereHas('tahunData', function ($q) use ($tahunDipilih) {
                    $q->where('tahun', $tahunDipilih);
                });
            })
            ->where('status', 'diterbitkan')
            ->latest()
            ->first();

        if (!$laporan) {
            return view('frontend.apbdes.index', [
                'laporan' => null,
                'balance' => null,
                'pendapatan' => collect(),
                'belanja' => collect(),
                'grafikData' => null,
                'tahunTersedia' => $tahunTersedia,
                'tahunDipilih' => $tahunDipilih,
            ]);
        }

        // Hitung balance/surplus/defisit
        $balance = $this->hitungBalance($laporan);

        // Ambil data pendapatan per bidang
        $pendapatan = $this->getDataPerBidang($laporan, 'pendapatan');

        // Ambil data belanja per bidang
        $belanja = $this->getDataPerBidang($laporan, 'belanja');

        // Data untuk grafik
        $grafikData = $this->prepareGrafikData($laporan);

        return view('frontend.apbdes.index', compact(
            'laporan',
            'balance',
            'pendapatan',
            'belanja',
            'grafikData',
            'tahunTersedia',
            'tahunDipilih'
        ));
    }

    private function hitungBalance($laporan)
    {
        $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'pendapatan')
            ->sum('realisasi');

        $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        $selisih = $totalPendapatan - $totalBelanja;

        return [
            'total_pendapatan' => $totalPendapatan,
            'total_belanja' => $totalBelanja,
            'selisih' => $selisih,
            'status' => $selisih >= 0 ? 'surplus' : 'defisit',
            'persentase_pendapatan' => $totalPendapatan > 0
                ? round(($totalPendapatan / ($totalPendapatan + $totalBelanja)) * 100, 1)
                : 0,
            'persentase_belanja' => $totalBelanja > 0
                ? round(($totalBelanja / ($totalPendapatan + $totalBelanja)) * 100, 1)
                : 0,
        ];
    }

    private function getDataPerBidang($laporan, $tipe)
    {
        return DetailApbdes::with('bidangApbdes')
            ->where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', $tipe)
            ->select([
                'bidang_apbdes_id',
                DB::raw('SUM(anggaran) as total_anggaran'),
                DB::raw('SUM(realisasi) as total_realisasi'),
                DB::raw('ROUND(AVG(persentase_realisasi), 2) as rata_persentase'),
            ])
            ->groupBy('bidang_apbdes_id')
            ->get()
            ->map(function ($item) {
                return [
                    'bidang' => $item->bidangApbdes->nama_bidang ?? 'Tidak Kategorisasi',
                    'kode_bidang' => $item->bidangApbdes->kode_bidang ?? '',
                    'anggaran' => $item->total_anggaran,
                    'realisasi' => $item->total_realisasi,
                    'persentase' => $item->total_anggaran > 0
                        ? round(($item->total_realisasi / $item->total_anggaran) * 100, 1)
                        : 0,
                ];
            });
    }

    private function prepareGrafikData($laporan)
    {
        // Data untuk chart pie pendapatan vs belanja
        $pendapatanTotal = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'pendapatan')
            ->sum('realisasi');

        $belanjaTotal = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        // Data untuk chart bar per bidang belanja
        $belanjaBidang = DetailApbdes::with('bidangApbdes')
            ->where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->select([
                'bidang_apbdes_id',
                DB::raw('SUM(realisasi) as total'),
            ])
            ->groupBy('bidang_apbdes_id')
            ->get()
            ->pluck('total', 'bidangApbdes.nama_bidang');

        return [
            'pendapatan_vs_belanja' => [
                'labels' => ['Pendapatan', 'Belanja'],
                'data' => [$pendapatanTotal, $belanjaTotal],
                'colors' => ['#10B981', '#F59E0B'], // green, yellow
            ],
            'belanja_per_bidang' => [
                'labels' => $belanjaBidang->keys()->toArray(),
                'data' => $belanjaBidang->values()->toArray(),
                'colors' => ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6'],
            ],
        ];
    }

    public function show($id)
    {
        $laporan = LaporanApbdes::with(['tahunData', 'detailApbdes.bidangApbdes'])
            ->findOrFail($id);

        $balance = $this->hitungBalance($laporan);
        $pendapatan = $this->getDataPerBidang($laporan, 'pendapatan');
        $belanja = $this->getDataPerBidang($laporan, 'belanja');

        return view('frontend.apbdes.detail', compact(
            'laporan',
            'balance',
            'pendapatan',
            'belanja'
        ));
    }
}

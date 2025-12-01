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

        // Debug: Log grafik data
        \Log::info('Grafik Data Debug:', [
            'laporan_id' => $laporan->id,
            'grafik_data' => $grafikData,
            'has_pendapatan' => !empty($grafikData['pendapatan_vs_belanja']),
            'has_belanja_bidang' => !empty($grafikData['belanja_per_bidang'])
        ]);

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
        // Pendapatan menggunakan anggaran (target yang ditetapkan)
        $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'pendapatan')
            ->sum('anggaran');

        // Belanja menggunakan realisasi (yang sudah dikeluarkan)
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
            ->map(function ($item) use ($tipe) {
                // Untuk pendapatan, gunakan anggaran sebagai nilai utama
                // Untuk belanja, gunakan realisasi sebagai nilai utama
                $nilaiUtama = $tipe === 'pendapatan' ? $item->total_anggaran : $item->total_realisasi;

                return [
                    'bidang' => $item->bidangApbdes->nama_bidang ?? 'Tidak Kategorisasi',
                    'kode_bidang' => $item->bidangApbdes->kode_bidang ?? '',
                    'anggaran' => $item->total_anggaran,
                    'realisasi' => $item->total_realisasi,
                    'nilai_utama' => $nilaiUtama,
                    'persentase' => $tipe === 'belanja' && $item->total_anggaran > 0
                        ? round(($item->total_realisasi / $item->total_anggaran) * 100, 1)
                        : null, // Tidak ada persentase untuk pendapatan
                ];
            });
    }

    private function prepareGrafikData($laporan)
    {
        // Pendapatan menggunakan anggaran, belanja menggunakan realisasi
        $pendapatanTotal = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'pendapatan')
            ->sum('anggaran');

        $belanjaTotal = DetailApbdes::where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->sum('realisasi');

        // Data untuk chart bar per bidang belanja (menggunakan realisasi)
        $belanjaBidang = DetailApbdes::with('bidangApbdes')
            ->where('laporan_apbdes_id', $laporan->id)
            ->where('tipe', 'belanja')
            ->select([
                'bidang_apbdes_id',
                DB::raw('SUM(realisasi) as total'),
            ])
            ->groupBy('bidang_apbdes_id')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->bidangApbdes->nama_bidang ?? 'Tidak Dikategorikan',
                    'total' => $item->total
                ];
            });

        $labels = $belanjaBidang->pluck('nama')->toArray();
        $data = $belanjaBidang->pluck('total')->toArray();

        return [
            'pendapatan_vs_belanja' => [
                'labels' => ['Target Pendapatan', 'Realisasi Belanja'],
                'data' => [$pendapatanTotal, $belanjaTotal],
                'colors' => ['#10B981', '#F59E0B'], // green, yellow
            ],
            'belanja_per_bidang' => [
                'labels' => $labels,
                'data' => $data,
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

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home dengan data statistik dan APBDes.
     */
    public function index()
    {
        // // === 1. LOGIKA STATISTIK ===
        // $tahunDataTerbaru = DB::table('tahun_data')->latest('tahun')->first();

        // $stats = null;
        // if ($tahunDataTerbaru) {
        //     $stats = DB::table('demografi_penduduk')
        //                ->where('tahun_id', $tahunDataTerbaru->id_tahun)
        //                ->first();
        // }

        // // === 2. LOGIKA APBDES ===
        // $apbdesTahun = DB::table('apbdes_tahun')->latest('tahun')->first();

        // $pendapatanItems = collect();
        // $pengeluaranItems = collect();
        // $persenRealisasiPendapatan = 0;
        // $persenRealisasiPengeluaran = 0;

        // if ($apbdesTahun) {
        //     // Karena tabel pendapatan dan pengeluaran memakai `tahun_id`,
        //     // maka kita hubungkan via kolom `tahun` dari apbdes_tahun
        //     $pendapatanItems = DB::table('pendapatan')
        //                        ->join('tahun_data', 'pendapatan.tahun_id', '=', 'tahun_data.id_tahun')
        //                        ->where('tahun_data.tahun', $apbdesTahun->tahun)
        //                        ->select('pendapatan.*')
        //                        ->get();

        //     $pengeluaranItems = DB::table('pengeluaran')
        //                         ->join('tahun_data', 'pengeluaran.tahun_id', '=', 'tahun_data.id_tahun')
        //                         ->where('tahun_data.tahun', $apbdesTahun->tahun)
        //                         ->select('pengeluaran.*')
        //                         ->get();

        //     // Hitung total (menggunakan kolom 'jumlah')
        //     $totalAnggaranPendapatan = $pendapatanItems->sum('jumlah');
        //     $totalAnggaranPengeluaran = $pengeluaranItems->sum('jumlah');

        //     // Jika belum ada realisasi, anggap realisasi = jumlah
        //     $totalRealisasiPendapatan = $totalAnggaranPendapatan;
        //     $totalRealisasiPengeluaran = $totalAnggaranPengeluaran;

        //     if ($totalAnggaranPendapatan > 0) {
        //         $persenRealisasiPendapatan = ($totalRealisasiPendapatan / $totalAnggaranPendapatan) * 100;
        //     }

        //     if ($totalAnggaranPengeluaran > 0) {
        //         $persenRealisasiPengeluaran = ($totalRealisasiPengeluaran / $totalAnggaranPengeluaran) * 100;
        //     }
        // }

        // === 3. KIRIM SEMUA DATA KE VIEW ===
        return view('frontend.home', [
            // // Data Statistik
            // 'totalPenduduk' => $stats->total_penduduk ?? 0,
            // 'totalLaki' => $stats->laki_laki ?? 0,
            // 'totalPerempuan' => $stats->perempuan ?? 0,
            // 'pendudukSementara' => $stats->penduduk_sementara ?? 0,
            // 'mutasiPenduduk' => $stats->mutasi_penduduk ?? 0,

            // // Data APBDes
            // 'apbdesTahun' => $apbdesTahun,
            // 'pendapatanItems' => $pendapatanItems,
            // 'pengeluaranItems' => $pengeluaranItems,
            // 'persenRealisasiPendapatan' => $persenRealisasiPendapatan,
            // 'persenRealisasiPengeluaran' => $persenRealisasiPengeluaran,
        ]);
    }
}

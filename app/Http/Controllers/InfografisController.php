<?php

namespace App\Http\Controllers;

use App\Models\TahunData;
use Illuminate\Http\Request;
use App\Models\UmurStatistik;
use App\Models\DemografiPenduduk;
use Illuminate\Support\Facades\DB;

class InfografisController extends Controller
{
    public function index()
    {
        // === 1. LOGIKA STATISTIK ===
        $tahunDataTerbaru = TahunData::orderByDesc('tahun')->first();
        $umurData = collect();
    if ($tahunDataTerbaru) {
        $umurData = UmurStatistik::where('tahun_id', $tahunDataTerbaru->id_tahun)->first();
    }

$totalPenduduk = $totalLaki = $totalPerempuan = $pendudukSementara = $mutasiPenduduk = 0;

if ($tahunDataTerbaru) {
    $stats = DemografiPenduduk::where('tahun_id', $tahunDataTerbaru->id_tahun)->first();

    if ($stats) {
        $totalPenduduk = $stats->total_penduduk ?? (($stats->laki_laki ?? 0) + ($stats->perempuan ?? 0));
        $totalLaki = $stats->laki_laki ?? 0;
        $totalPerempuan = $stats->perempuan ?? 0;
        $pendudukSementara = $stats->penduduk_sementara ?? 0;
        $mutasiPenduduk = $stats->mutasi_penduduk ?? 0;
    }
}

        // === 2. LOGIKA APBDES ===
        $apbdesTahun = DB::table('apbdes_tahun')->latest('tahun')->first();

        $pendapatanItems = collect();
        $pengeluaranItems = collect();
        $persenRealisasiPendapatan = 0;
        $persenRealisasiPengeluaran = 0;

        if ($apbdesTahun) {
            $pendapatanItems = DB::table('pendapatan')
                ->join('tahun_data', 'pendapatan.tahun_id', '=', 'tahun_data.id_tahun')
                ->where('tahun_data.tahun', $apbdesTahun->tahun)
                ->select('pendapatan.*')
                ->get();

            $pengeluaranItems = DB::table('pengeluaran')
                ->join('tahun_data', 'pengeluaran.tahun_id', '=', 'tahun_data.id_tahun')
                ->where('tahun_data.tahun', $apbdesTahun->tahun)
                ->select('pengeluaran.*')
                ->get();

            $totalAnggaranPendapatan = $pendapatanItems->sum('jumlah');
            $totalAnggaranPengeluaran = $pengeluaranItems->sum('jumlah');

            // Anggap realisasi sama dengan jumlah jika belum ada kolom realisasi
            $totalRealisasiPendapatan = $totalAnggaranPendapatan;
            $totalRealisasiPengeluaran = $totalAnggaranPengeluaran;

            if ($totalAnggaranPendapatan > 0) {
                $persenRealisasiPendapatan = ($totalRealisasiPendapatan / $totalAnggaranPendapatan) * 100;
            }

            if ($totalAnggaranPengeluaran > 0) {
                $persenRealisasiPengeluaran = ($totalRealisasiPengeluaran / $totalAnggaranPengeluaran) * 100;
            }
        }

        // === 3. KIRIM KE VIEW ===
        return view('Infografis.index', compact(
            'tahunDataTerbaru',
            'umurData',
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'pendudukSementara',
            'mutasiPenduduk',
            'apbdesTahun',
            'pendapatanItems',
            'pengeluaranItems',
            'persenRealisasiPendapatan',
            'persenRealisasiPengeluaran'
        ));
    }

    // Halaman tambahan
    public function apbdes()
    {
        return view('Infografis.apbdes');
    }

    public function stunting()
    {
        return view('Infografis.stunting');
    }

    public function bansos()
    {
        return view('Infografis.bansos');
    }

    public function idm()
    {
        return view('IDM.index');
    }

    public function sdg()
    {
        return view('Infografis.sdg');
    }
}

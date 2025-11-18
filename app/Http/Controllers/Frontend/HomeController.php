<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanApbdes;
use App\Models\StrukturOrganisasi;
use App\Models\Berita;
use App\Models\Umkm;
use App\Models\Galeri;             // <-- Tambahan
use App\Models\TahunData;         // <-- Tambahan
use App\Models\DemografiPenduduk; // <-- Tambahan
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home dengan data statistik dan APBDes.
     */
    public function index()
    {
        // === 1. LOGIKA STATISTIK (Menggunakan Eloquent) ===
        $tahunTerbaru = TahunData::latest('tahun')->first();

        $stats = null;
        if ($tahunTerbaru) {
            $stats = DemografiPenduduk::where('tahun_id', $tahunTerbaru->id_tahun)->first();
        }

        // Siapkan variabel statistik dengan nilai default 0
        $totalPenduduk = $stats->total_penduduk ?? 0;
        $totalLaki = $stats->laki_laki ?? 0;
        $totalPerempuan = $stats->perempuan ?? 0;
        $pendudukSementara = $stats->penduduk_sementara ?? 0;
        $mutasiPenduduk = $stats->mutasi_penduduk ?? 0;


        // === 2. LOGIKA APBDES (Sudah Benar) ===
        $apbdesLaporan = LaporanApbdes::with(['tahunData', 'detailApbdes'])
            ->join('tahun_data', 'laporan_apbdes.tahun_id', '=', 'tahun_data.id_tahun')
            ->orderBy('tahun_data.tahun', 'DESC')
            ->select('laporan_apbdes.*')
            ->first();

        $pendapatanItems = collect();
        $pengeluaranItems = collect();
        $persenRealisasiPendapatan = 0;
        $persenRealisasiPengeluaran = 0;
        $totalAnggaranPendapatan = 0;
        $totalAnggaranPengeluaran = 0;
        $totalRealisasiPendapatan = 0;
        $totalRealisasiPengeluaran = 0;

        if ($apbdesLaporan) {
            $pendapatanItems = $apbdesLaporan->detailApbdes->where('tipe', 'pendapatan');
            $pengeluaranItems = $apbdesLaporan->detailApbdes->where('tipe', 'belanja');

            $totalAnggaranPendapatan = $pendapatanItems->sum('anggaran');
            $totalRealisasiPendapatan = $pendapatanItems->sum('realisasi');
            
            $totalAnggaranPengeluaran = $pengeluaranItems->sum('anggaran');
            $totalRealisasiPengeluaran = $pengeluaranItems->sum('realisasi');

            if ($totalAnggaranPendapatan > 0) {
                $persenRealisasiPendapatan = ($totalRealisasiPendapatan / $totalAnggaranPendapatan) * 100;
            }

            if ($totalAnggaranPengeluaran > 0) {
                $persenRealisasiPengeluaran = ($totalRealisasiPengeluaran / $totalAnggaranPengeluaran) * 100;
            }
        }

        // === 3. LOGIKA SOTK ===
        $sotk = StrukturOrganisasi::orderBy('id_struktur', 'asc')->take(4)->get();

        // === 4. LOGIKA BERITA TERBARU (Perbaikan status) ===
        $beritaTerbaru = Berita::where('status', 'published') // <-- Diperbaiki
                               ->latest()
                               ->take(6)
                               ->get();

        // === 5. LOGIKA POTENSI DESA / UMKM ===
        $potensiDesa = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)
                           ->inRandomOrder()
                           ->take(3)
                           ->get();

        // === 7. KIRIM SEMUA DATA KE VIEW (Gabungan) ===
        return view('frontend.home', compact(
            'totalPenduduk', 'totalLaki', 'totalPerempuan', 'pendudukSementara', 'mutasiPenduduk',
            'apbdesLaporan',
            'totalAnggaranPendapatan', 'totalRealisasiPendapatan', 'persenRealisasiPendapatan',
            'totalAnggaranPengeluaran', 'totalRealisasiPengeluaran', 'persenRealisasiPengeluaran',
            'sotk', 'beritaTerbaru', 'potensiDesa',
        ));
    }
}
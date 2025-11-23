<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Infografis\StatistikController;
use App\Models\Berita;
use App\Models\TahunData;
use App\Models\LaporanApbdes;
use App\Models\DetailApbdes;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * HomeController - Handle halaman home/landing page
 * 
 * Responsibilities:
 * - Render halaman home dengan semua sections
 * - Koordinasi data dari berbagai controller
 * - Provide data tahun terbaru untuk statistik
 */
class HomeController extends Controller
{
    protected $statistikController;

    public function __construct()
    {
        $this->statistikController = new StatistikController();
    }

    /**
     * Halaman home utama dengan sections modular
     * Route: GET /
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil tahun data terbaru
        $tahunDataTerbaru = $this->getTahunTerbaru();

        // Kumpulkan data untuk semua sections
        $data = [
            // Data tahun
            'tahunDataTerbaru' => $tahunDataTerbaru->tahun,

            // Statistik penduduk (tahun terbaru)
            'statistikPenduduk' => $this->getStatistikPenduduk($tahunDataTerbaru->tahun),

            // Data Struktur Organisasi
            'strukturOrganisasi' => $this->getStrukturOrganisasi(),

            // Data APBD
            'apbdData' => $this->getAPBDData($tahunDataTerbaru->tahun),

            // Berita terbaru
            'berita' => $this->getBeritaTerbaru(),

            // Potensi desa
            'potensiDesa' => $this->getPotensiDesa(),

            // Galeri
            'galeri' => $this->getGaleriTerbaru()
        ];

        return view('frontend.home.index', $data);
    }

    /**
     * Get tahun data terbaru
     */
    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();

        if (!$tahunDataTerbaru) {
            return (object)['tahun' => date('Y')];
        }

        return $tahunDataTerbaru;
    }

    /**
     * Get statistik penduduk untuk tahun terbaru
     */
    private function getStatistikPenduduk($tahun)
    {
        try {
            return $this->statistikController->getData($tahun);
        } catch (\Exception $e) {
            // Fallback ke data dummy jika error
            return [
                'totalPenduduk' => 5420,
                'totalLaki' => 2710,
                'totalPerempuan' => 2710,
                'pendudukSementara' => 150,
                'mutasiPenduduk' => 85
            ];
        }
    }

    /**
     * Get data Struktur Organisasi untuk ditampilkan di home
     */
    private function getStrukturOrganisasi()
    {
        try {
            return StrukturOrganisasi::orderBy('id_struktur')->get();
        } catch (\Exception $e) {
            // Jika ada error, return collection kosong
            return collect();
        }
    }

    /**
     * Get data APBD untuk tahun tertentu
     */
    private function getAPBDData($tahun)
    {
        try {
            $laporanApbd = LaporanApbdes::whereHas('tahunData', function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            })->first();

            if (!$laporanApbd) {
                return ['hasData' => false];
            }

            // Hitung total pendapatan
            $totalPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('jenis', 'pendapatan')
                ->sum('nilai');

            $targetPendapatan = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('jenis', 'pendapatan')
                ->sum('target');

            // Hitung total belanja
            $totalBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('jenis', 'belanja')
                ->sum('nilai');

            $targetBelanja = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('jenis', 'belanja')
                ->sum('target');

            return [
                'hasData' => true,
                'pendapatan' => [
                    'realisasi' => $totalPendapatan,
                    'target' => $targetPendapatan,
                    'persentase' => $targetPendapatan > 0 ? ($totalPendapatan / $targetPendapatan) * 100 : 0
                ],
                'belanja' => [
                    'realisasi' => $totalBelanja,
                    'target' => $targetBelanja,
                    'persentase' => $targetBelanja > 0 ? ($totalBelanja / $targetBelanja) * 100 : 0
                ]
            ];
        } catch (\Exception $e) {
            return ['hasData' => false];
        }
    }

    /**
     * Get berita terbaru
     */
    private function getBeritaTerbaru($limit = 6)
    {
        try {
            return Berita::orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect(); // Return empty collection jika error
        }
    }

    /**
     * Get potensi desa
     */
    private function getPotensiDesa()
    {
        // Implementasi sesuai model yang ada
        // Contoh: return PotensiDesa::where('aktif', true)->limit(3)->get();

        // Sementara return null untuk menggunakan data dummy
        return null;
    }

    /**
     * Get galeri terbaru
     */
    private function getGaleriTerbaru($limit = 8)
    {
        // Implementasi sesuai model yang ada
        // Contoh: return Galeri::orderBy('created_at', 'desc')->limit($limit)->get();

        // Sementara return null untuk menggunakan data dummy
        return null;
    }

    /**
     * API endpoint untuk refresh data home
     * Route: GET /api/home/refresh
     */
    public function refreshData(Request $request)
    {
        $tahunDataTerbaru = $this->getTahunTerbaru();

        return response()->json([
            'status' => 'success',
            'tahun_terbaru' => $tahunDataTerbaru->tahun,
            'statistik_penduduk' => $this->getStatistikPenduduk($tahunDataTerbaru->tahun),
            'updated_at' => now()
        ]);
    }

    /**
     * Method lama untuk backward compatibility
     */
    public function indexOld()
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

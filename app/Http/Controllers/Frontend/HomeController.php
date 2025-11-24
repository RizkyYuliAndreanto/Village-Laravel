<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Infografis\StatistikController;
use App\Models\Berita;
use App\Models\TahunData;
use App\Models\LaporanApbdes;
use App\Models\DetailApbdes;
use App\Models\StrukturOrganisasi;
use App\Models\Umkm; 
use Illuminate\Http\Request;

/**
 * HomeController - Handle halaman home/landing page
 */
class HomeController extends Controller
{
    protected $statistikController;

    public function __construct()
    {
        // Pastikan StatistikController ada di namespace yang benar
        $this->statistikController = new StatistikController();
    }

    /**
     * Halaman home utama dengan sections modular
     */
    public function index(Request $request)
    {
        // 1. Ambil tahun data terbaru
        $tahunDataTerbaru = $this->getTahunTerbaru();

        // 2. Ambil Data Statistik (Array)
        $stats = $this->getStatistikPenduduk($tahunDataTerbaru->tahun);

        // 3. Kumpulkan data untuk View (Sesuaikan nama variabel dengan View Blade)
        $data = [
            // Data Dasar
            'tahunDataTerbaru' => $tahunDataTerbaru->tahun,

            // Statistik Penduduk (Di-unpack agar View bisa baca $totalPenduduk langsung)
            'totalPenduduk'     => $stats['totalPenduduk'],
            'totalLaki'         => $stats['totalLaki'],
            'totalPerempuan'    => $stats['totalPerempuan'],
            'pendudukSementara' => $stats['pendudukSementara'],
            'mutasiPenduduk'    => $stats['mutasiPenduduk'],

            // Struktur Organisasi (View biasanya pakai $sotk)
            'sotk' => $this->getStrukturOrganisasi(),

            // Data APBD
            'apbdData' => $this->getAPBDData($tahunDataTerbaru->tahun),

            // Berita Terbaru (PERBAIKAN: Ganti key 'berita' jadi 'beritaTerbaru')
            'beritaTerbaru' => $this->getBeritaTerbaru(),

            // Potensi desa
            'potensiDesa' => $this->getPotensiDesa(),

            // Galeri
            'galeri' => $this->getGaleriTerbaru()
        ];

        return view('frontend.home.index', $data);
    }

    /**
     * ==========================================
     * PRIVATE HELPER METHODS
     * ==========================================
     */

    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();

        if (!$tahunDataTerbaru) {
            return (object)['tahun' => date('Y')];
        }

        return $tahunDataTerbaru;
    }

    private function getStatistikPenduduk($tahun)
    {
        try {
            // Ambil data dari controller statistik
            $dataRaw = $this->statistikController->getData($tahun);
            
            // Konversi object/array dari controller lain ke format array standar
            // Kita gunakan null coalescing operator (??) untuk safety
            $total = $dataRaw->total_penduduk ?? $dataRaw['total_penduduk'] ?? 5420;
            $laki = $dataRaw->laki_laki ?? $dataRaw['laki_laki'] ?? 2710;
            $perempuan = $dataRaw->perempuan ?? $dataRaw['perempuan'] ?? 2710;
            $sementara = $dataRaw->penduduk_sementara ?? $dataRaw['penduduk_sementara'] ?? 150;
            $mutasi = $dataRaw->mutasi_penduduk ?? $dataRaw['mutasi_penduduk'] ?? 85;

            return [
                'totalPenduduk'     => $total,
                'totalLaki'         => $laki,
                'totalPerempuan'    => $perempuan,
                'pendudukSementara' => $sementara,
                'mutasiPenduduk'    => $mutasi
            ];
        } catch (\Exception $e) {
            // Fallback ke data dummy jika error
            return [
                'totalPenduduk'     => 5420,
                'totalLaki'         => 2710,
                'totalPerempuan'    => 2710,
                'pendudukSementara' => 150,
                'mutasiPenduduk'    => 85
            ];
        }
    }

    private function getStrukturOrganisasi()
    {
        try {
            return StrukturOrganisasi::orderBy('id_struktur')->take(4)->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

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

    private function getBeritaTerbaru($limit = 6)
    {
        try {
            return Berita::where('status', 'published') // Filter status published
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            return collect(); // Return empty collection jika error
        }
    }

    private function getPotensiDesa()
    {
        try {
            // Gunakan Model UMKM
            return Umkm::where('status_usaha', 'aktif')
                ->inRandomOrder()
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getGaleriTerbaru($limit = 8)
    {
        // Return null sementara agar tidak error jika Model Galeri belum ada
        return null; 
    }
}
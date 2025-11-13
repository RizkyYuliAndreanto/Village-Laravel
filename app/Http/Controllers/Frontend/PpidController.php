<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PpidDokumen;
use Illuminate\Http\Request;

/**
 * Frontend PpidController - Untuk menampilkan dokumen PPID di website publik
 * 
 * PPID (Pejabat Pengelola Informasi dan Dokumentasi) adalah layanan informasi publik
 * Controller ini menyediakan akses ke berbagai dokumen publik:
 * - Dokumen berkala, serta merta, setiap saat
 * - Pencarian dan filter dokumen
 * - Download tracking
 */
class PpidController extends Controller
{
    /**
     * Halaman utama PPID dengan semua dokumen
     * Route: GET /ppid
     * 
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $tahun = $request->get('tahun');
        $jenisDokumen = $request->get('jenis_dokumen');

        // Query dokumen PPID
        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul_dokumen', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('kategori_informasi', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori_informasi', $kategori);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal_dokumen', $tahun);
            })
            ->when($jenisDokumen, function ($query, $jenisDokumen) {
                return $query->where('jenis_dokumen', $jenisDokumen);
            })
            ->orderBy('tanggal_dokumen', 'desc')
            ->paginate(12);

        // Data untuk filter
        $kategoris = PpidDokumen::where('status_publikasi', 'published')
            ->select('kategori_informasi')
            ->distinct()
            ->pluck('kategori_informasi')
            ->filter()
            ->sort();

        $jenisDokumens = PpidDokumen::where('status_publikasi', 'published')
            ->select('jenis_dokumen')
            ->distinct()
            ->pluck('jenis_dokumen')
            ->filter();

        $tahuns = PpidDokumen::where('status_publikasi', 'published')
            ->selectRaw('YEAR(tanggal_dokumen) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Statistik
        $totalDokumen = PpidDokumen::where('status_publikasi', 'published')->count();
        $totalDownload = PpidDokumen::where('status_publikasi', 'published')->sum('jumlah_download');

        return [
            'dokumen' => $dokumen,
            'kategoris' => $kategoris,
            'jenisDokumens' => $jenisDokumens,
            'tahuns' => $tahuns,
            'search' => $search,
            'kategori' => $kategori,
            'tahun' => $tahun,
            'jenisDokumen' => $jenisDokumen,
            'totalDokumen' => $totalDokumen,
            'totalDownload' => $totalDownload
        ];
    }

    /**
     * Detail dokumen PPID
     * Route: GET /ppid/{id}
     * 
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->findOrFail($id);

        // Increment view count
        $dokumen->increment('jumlah_akses');

        // Dokumen terkait dari kategori yang sama
        $dokumenTerkait = PpidDokumen::where('status_publikasi', 'published')
            ->where('kategori_informasi', $dokumen->kategori_informasi)
            ->where('id', '!=', $dokumen->id)
            ->orderBy('tanggal_dokumen', 'desc')
            ->limit(5)
            ->get();

        // Dokumen terbaru lainnya
        $dokumenTerbaru = PpidDokumen::where('status_publikasi', 'published')
            ->where('id', '!=', $dokumen->id)
            ->orderBy('tanggal_dokumen', 'desc')
            ->limit(5)
            ->get();

        return [
            'dokumen' => $dokumen,
            'dokumenTerkait' => $dokumenTerkait,
            'dokumenTerbaru' => $dokumenTerbaru
        ];
    }

    /**
     * Dokumen berdasarkan jenis (berkala, serta merta, setiap saat)
     * Route: GET /ppid/jenis/{jenis}
     * 
     * @param string $jenis
     * @param Request $request
     * @return array
     */
    public function jenis($jenis, Request $request)
    {
        $search = $request->get('search');
        $tahun = $request->get('tahun');

        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->where('jenis_dokumen', $jenis)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul_dokumen', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal_dokumen', $tahun);
            })
            ->orderBy('tanggal_dokumen', 'desc')
            ->paginate(12);

        $tahuns = PpidDokumen::where('status_publikasi', 'published')
            ->where('jenis_dokumen', $jenis)
            ->selectRaw('YEAR(tanggal_dokumen) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $totalDokumen = PpidDokumen::where('status_publikasi', 'published')
            ->where('jenis_dokumen', $jenis)
            ->count();

        // Deskripsi jenis dokumen
        $deskripsiJenis = [
            'berkala' => 'Informasi yang wajib disediakan dan diumumkan secara berkala',
            'serta_merta' => 'Informasi yang wajib diumumkan serta merta',
            'setiap_saat' => 'Informasi yang wajib tersedia setiap saat'
        ];

        return [
            'dokumen' => $dokumen,
            'jenis' => $jenis,
            'tahuns' => $tahuns,
            'search' => $search,
            'tahun' => $tahun,
            'totalDokumen' => $totalDokumen,
            'deskripsiJenis' => $deskripsiJenis[$jenis] ?? 'Dokumen PPID'
        ];
    }

    /**
     * Dokumen berdasarkan kategori informasi
     * Route: GET /ppid/kategori/{kategori}
     * 
     * @param string $kategori
     * @param Request $request
     * @return array
     */
    public function kategori($kategori, Request $request)
    {
        $search = $request->get('search');
        $tahun = $request->get('tahun');

        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->where('kategori_informasi', $kategori)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul_dokumen', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('tanggal_dokumen', $tahun);
            })
            ->orderBy('tanggal_dokumen', 'desc')
            ->paginate(12);

        $tahuns = PpidDokumen::where('status_publikasi', 'published')
            ->where('kategori_informasi', $kategori)
            ->selectRaw('YEAR(tanggal_dokumen) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $totalDokumen = PpidDokumen::where('status_publikasi', 'published')
            ->where('kategori_informasi', $kategori)
            ->count();

        return [
            'dokumen' => $dokumen,
            'kategori' => $kategori,
            'tahuns' => $tahuns,
            'search' => $search,
            'tahun' => $tahun,
            'totalDokumen' => $totalDokumen
        ];
    }

    /**
     * Download dokumen dengan tracking
     * Route: GET /ppid/download/{id}
     * 
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function download($id)
    {
        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->findOrFail($id);

        // Increment download count
        $dokumen->increment('jumlah_download');

        // Log download (optional - bisa ditambahkan model DownloadLog)

        if ($dokumen->file_url && file_exists(public_path($dokumen->file_url))) {
            return response()->download(
                public_path($dokumen->file_url),
                $dokumen->nama_file ?? $dokumen->judul_dokumen . '.pdf'
            );
        }

        // Jika file tidak ada, redirect ke halaman detail dengan error
        return redirect()->route('ppid.show', $dokumen->id)
            ->with('error', 'File tidak ditemukan atau telah dipindahkan.');
    }

    /**
     * Search AJAX untuk autocomplete
     * Route: GET /api/ppid/search
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAjax(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = PpidDokumen::where('status_publikasi', 'published')
            ->where(function ($q) use ($query) {
                $q->where('judul_dokumen', 'like', "%{$query}%")
                    ->orWhere('deskripsi', 'like', "%{$query}%")
                    ->orWhere('kategori_informasi', 'like', "%{$query}%");
            })
            ->orderBy('tanggal_dokumen', 'desc')
            ->limit(10)
            ->get(['id', 'judul_dokumen', 'kategori_informasi', 'tanggal_dokumen', 'jenis_dokumen']);

        return response()->json($results);
    }

    /**
     * Widget PPID untuk homepage/sidebar
     * Route: GET /api/ppid/widget
     * 
     * @return array
     */
    public function widget()
    {
        // Dokumen terbaru
        $dokumenTerbaru = PpidDokumen::where('status_publikasi', 'published')
            ->orderBy('tanggal_dokumen', 'desc')
            ->limit(5)
            ->get(['id', 'judul_dokumen', 'tanggal_dokumen', 'jenis_dokumen']);

        // Dokumen paling banyak didownload
        $dokumenPopuler = PpidDokumen::where('status_publikasi', 'published')
            ->orderBy('jumlah_download', 'desc')
            ->limit(5)
            ->get(['id', 'judul_dokumen', 'jumlah_download', 'jenis_dokumen']);

        // Statistik
        $totalDokumen = PpidDokumen::where('status_publikasi', 'published')->count();
        $totalDownload = PpidDokumen::where('status_publikasi', 'published')->sum('jumlah_download');

        return [
            'dokumenTerbaru' => $dokumenTerbaru,
            'dokumenPopuler' => $dokumenPopuler,
            'totalDokumen' => $totalDokumen,
            'totalDownload' => $totalDownload
        ];
    }

    /**
     * Statistik PPID untuk dashboard
     * Route: GET /api/ppid/statistik
     * 
     * @return array
     */
    public function statistik()
    {
        $statistikPerJenis = PpidDokumen::where('status_publikasi', 'published')
            ->selectRaw('jenis_dokumen, COUNT(*) as total, SUM(jumlah_download) as total_download')
            ->groupBy('jenis_dokumen')
            ->get();

        $statistikPerKategori = PpidDokumen::where('status_publikasi', 'published')
            ->selectRaw('kategori_informasi, COUNT(*) as total')
            ->groupBy('kategori_informasi')
            ->orderBy('total', 'desc')
            ->get();

        $statistikPerBulan = PpidDokumen::where('status_publikasi', 'published')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'perJenis' => $statistikPerJenis,
            'perKategori' => $statistikPerKategori,
            'perBulan' => $statistikPerBulan
        ];
    }

    /**
     * Arsip dokumen berdasarkan tahun
     * Route: GET /ppid/arsip/{tahun}
     * 
     * @param int $tahun
     * @return array
     */
    public function arsip($tahun)
    {
        $dokumen = PpidDokumen::where('status_publikasi', 'published')
            ->whereYear('tanggal_dokumen', $tahun)
            ->orderBy('tanggal_dokumen', 'desc')
            ->paginate(15);

        // Statistik per bulan dalam tahun tersebut
        $statistikBulan = PpidDokumen::where('status_publikasi', 'published')
            ->whereYear('tanggal_dokumen', $tahun)
            ->selectRaw('MONTH(tanggal_dokumen) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Statistik per kategori dalam tahun tersebut
        $statistikKategori = PpidDokumen::where('status_publikasi', 'published')
            ->whereYear('tanggal_dokumen', $tahun)
            ->selectRaw('kategori_informasi, COUNT(*) as total')
            ->groupBy('kategori_informasi')
            ->orderBy('total', 'desc')
            ->get();

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        return [
            'dokumen' => $dokumen,
            'tahun' => $tahun,
            'statistikBulan' => $statistikBulan,
            'statistikKategori' => $statistikKategori,
            'namaBulan' => $namaBulan
        ];
    }
}

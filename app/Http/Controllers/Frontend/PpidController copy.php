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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $tahun = $request->get('tahun');
        $jenisDokumen = $request->get('jenis_dokumen');

        // Query dokumen PPID
        $dokumen = PpidDokumen::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul_dokumen', 'like', "%{$search}%")
                        ->orWhere('uploader', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->where('tahun', $tahun);
            })
            ->orderBy('tanggal_upload', 'desc')
            ->paginate(12);

        // Data untuk filter
        $kategoris = PpidDokumen::select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        // Jenis dokumen tidak ada di schema saat ini
        $jenisDokumens = collect();

        $tahuns = PpidDokumen::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Statistik
        $totalDokumen = PpidDokumen::count();
        // Note: download count not available in current schema
        $totalDownload = 0; // PpidDokumen::sum('jumlah_download');

        return view('frontend.ppid.index', compact(
            'dokumen',
            'kategoris',
            'jenisDokumens',
            'tahuns',
            'search',
            'kategori',
            'tahun',
            'totalDokumen',
            'totalDownload'
        ));
    }

    /**
     * Detail dokumen PPID
     * Route: GET /ppid/{id}
     * 
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $dokumen = PpidDokumen::findOrFail($id);

        // Note: access count not available in current schema
        // $dokumen->increment('jumlah_akses');

        // Dokumen terkait dari kategori yang sama
        $dokumenTerkait = PpidDokumen::where('kategori', $dokumen->kategori)
            ->where('id', '!=', $dokumen->id)
            ->orderBy('tanggal_upload', 'desc')
            ->limit(5)
            ->get();

        // Dokumen terbaru lainnya
        $dokumenTerbaru = PpidDokumen::where('id', '!=', $dokumen->id)
            ->orderBy('tanggal_upload', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.ppid.show', compact(
            'dokumen',
            'dokumenTerkait',
            'dokumenTerbaru'
        ));
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

        $dokumen = PpidDokumen::where('kategori', $jenis)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul_dokumen', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->where('tahun', $tahun);
            })
            ->orderBy('tanggal_upload', 'desc')
            ->paginate(12);

        $tahuns = PpidDokumen::where('kategori', $jenis)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $totalDokumen = PpidDokumen::where('kategori', $jenis)
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
     * @return \Illuminate\Contracts\View\View
     */
    public function kategori($kategori, Request $request)
    {
        $search = $request->get('search');
        $tahun = $request->get('tahun');
        $sort = $request->get('sort', 'terbaru');

        $query = PpidDokumen::where('kategori', $kategori)
            ->when($search, function ($query, $search) {
                return $query->where('judul_dokumen', 'like', "%{$search}%");
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->where('tahun', $tahun);
            });

        // Sorting
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tanggal_upload', 'asc');
                break;
            case 'a-z':
                $query->orderBy('judul_dokumen', 'asc');
                break;
            case 'z-a':
                $query->orderBy('judul_dokumen', 'desc');
                break;
            default: // terbaru
                $query->orderBy('tanggal_upload', 'desc');
                break;
        }

        $dokumen = $query->paginate(12);

        // Get available years for this category
        $tahunList = PpidDokumen::where('kategori', $kategori)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->get();

        // Get other categories
        $kategoriLain = PpidDokumen::where('kategori', '!=', $kategori)
            ->selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->limit(4)
            ->get();

        return view('frontend.ppid.kategori', compact(
            'dokumen',
            'kategori',
            'tahunList',
            'kategoriLain',
            'search',
            'tahun',
            'sort'
        ));
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
        $dokumen = PpidDokumen::findOrFail($id);

        // Note: download count not available in current schema
        // $dokumen->increment('jumlah_download');

        // Log download (optional - bisa ditambahkan model DownloadLog)

        if ($dokumen->file_url && file_exists(public_path($dokumen->file_url))) {
            return response()->download(
                public_path($dokumen->file_url),
                $dokumen->judul_dokumen . '.pdf'
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

        $results = PpidDokumen::where('judul_dokumen', 'like', "%{$query}%")
            ->orderBy('tanggal_upload', 'desc')
            ->limit(10)
            ->get(['id', 'judul_dokumen', 'kategori', 'tanggal_upload', 'tahun']);

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
        $dokumenTerbaru = PpidDokumen::orderBy('tanggal_upload', 'desc')
            ->limit(5)
            ->get(['id', 'judul_dokumen', 'tanggal_upload', 'kategori']);

        // Dokumen terbaru (menggantikan populer karena tidak ada jumlah_download)
        $populerDokumen = PpidDokumen::orderBy('tanggal_upload', 'desc')
            ->limit(5)
            ->get(['id', 'judul_dokumen', 'kategori', 'tahun']);

        // Total statistik
        $totalDokumen = PpidDokumen::count();
        $totalDownload = 0; // PpidDokumen::sum('jumlah_download');

        return [
            'dokumenTerbaru' => $dokumenTerbaru,
            'dokumenPopuler' => $populerDokumen,
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
        $statistikPerKategori = PpidDokumen::selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->orderBy('total', 'desc')
            ->get();

        $statistikPerTahun = PpidDokumen::selectRaw('tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        $statistikPerBulan = PpidDokumen::whereYear('tanggal_upload', date('Y'))
            ->selectRaw('MONTH(tanggal_upload) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return [
            'perKategori' => $statistikPerKategori,
            'perTahun' => $statistikPerTahun,
            'perBulan' => $statistikPerBulan
        ];
    }

    /**
     * Arsip dokumen berdasarkan tahun
     * Route: GET /ppid/arsip/{tahun}
     * 
     * @param int $tahun
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function arsip($tahun, Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $bulan = $request->get('bulan');
        $sort = $request->get('sort', 'terbaru');

        $query = PpidDokumen::where('tahun', $tahun)
            ->when($search, function ($query, $search) {
                return $query->where('judul_dokumen', 'like', "%{$search}%");
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('tanggal_upload', $bulan);
            });

        // Sorting
        switch ($sort) {
            case 'terlama':
                $query->orderBy('tanggal_upload', 'asc');
                break;
            case 'a-z':
                $query->orderBy('judul_dokumen', 'asc');
                break;
            case 'z-a':
                $query->orderBy('judul_dokumen', 'desc');
                break;
            default: // terbaru
                $query->orderBy('tanggal_upload', 'desc');
                break;
        }

        $dokumen = $query->paginate(15);

        // Get available categories for this year
        $kategoriList = PpidDokumen::where('tahun', $tahun)
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->get();

        // Get available months for this year
        $bulanList = PpidDokumen::where('tahun', $tahun)
            ->selectRaw('MONTH(tanggal_upload) as bulan')
            ->distinct()
            ->orderBy('bulan')
            ->get();

        // Get available years
        $tahunTersedia = PpidDokumen::selectRaw('tahun, COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        // Statistik per kategori dalam tahun tersebut
        $statistikKategori = PpidDokumen::where('tahun', $tahun)
            ->selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
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

        return view('frontend.ppid.arsip', compact(
            'dokumen',
            'tahun',
            'kategoriList',
            'bulanList',
            'tahunTersedia',
            'statistikKategori',
            'namaBulan',
            'search',
            'kategori',
            'bulan',
            'sort'
        ));
    }
}

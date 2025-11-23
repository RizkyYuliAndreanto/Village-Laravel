<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

/**
 * Frontend BeritaController - Untuk menampilkan berita desa di website publik
 * 
 * Controller ini menyediakan semua method untuk menampilkan berita:
 * - Daftar berita dengan pagination dan filter
 * - Detail berita
 * - Berita terbaru untuk widget
 * - Search berita
 */
class BeritaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua berita
     * Route: GET /berita
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Parameter filter dari URL
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan');

        // Query berita dengan filter
        $berita = Berita::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%");
                });
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->whereMonth('created_at', $bulan);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9); // 9 berita per halaman

        // Data tambahan untuk filter
        $kategoris = Berita::select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        $tahuns = Berita::selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Statistik
        $totalBerita = Berita::count();
        $beritaBulanIni = Berita::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('frontend.berita.index', compact(
            'berita',
            'kategoris', 
            'tahuns',
            'search',
            'kategori',
            'tahun',
            'bulan',
            'totalBerita',
            'beritaBulanIni'
        ));
    }

    /**
     * Menampilkan detail berita
     * Route: GET /berita/{id}
     * 
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        // Cari berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Note: views column not available in current schema
        // $berita->increment('views');

        // Berita terkait (kategori sama, exclude current)
        $beritaTerkait = Berita::where('kategori', $berita->kategori)
            ->where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Berita terbaru untuk sidebar
        $beritaTerbaru = Berita::where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.berita.show', compact(
            'berita',
            'beritaTerkait',
            'beritaTerbaru'
        ));
    }

    /**
     * Berita terbaru untuk widget/homepage
     * Route: GET /api/berita/terbaru
     * 
     * @param int $limit
     * @return array
     */
    public function terbaru($limit = 6)
    {
        $berita = Berita::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['id', 'judul', 'isi', 'gambar_url', 'created_at', 'penulis', 'kategori']);

        return [
            'data' => $berita,
            'total' => $berita->count()
        ];
    }

    /**
     * Berita populer berdasarkan views
     * Route: GET /api/berita/populer
     * 
     * @param int $limit
     * @return array
     */
    public function populer($limit = 5)
    {
        $berita = Berita::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['id', 'judul', 'isi', 'gambar_url', 'created_at', 'penulis']);

        return [
            'data' => $berita,
            'total' => $berita->count()
        ];
    }

    /**
     * Search AJAX untuk autocomplete
     * Route: GET /api/berita/search
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

        $results = Berita::where(function ($q) use ($query) {
                $q->where('judul', 'like', "%{$query}%")
                    ->orWhere('isi', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['id', 'judul', 'created_at']);

        return response()->json($results);
    }

    /**
     * Berita berdasarkan kategori
     * Route: GET /berita/kategori/{kategori}
     * 
     * @param string $kategori
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function kategori($kategori, Request $request)
    {
        $search = $request->get('search');
        $tahun = $request->get('tahun');

        $berita = Berita::where('kategori', $kategori)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%");
                });
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        // Data untuk filter
        $tahuns = Berita::where('kategori', $kategori)
            ->selectRaw('YEAR(created_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $totalBerita = Berita::where('kategori', $kategori)
            ->count();

        return view('frontend.berita.kategori', compact(
            'berita',
            'kategori',
            'tahuns',
            'search',
            'tahun',
            'totalBerita'
        ));
    }

    /**
     * Arsip berita berdasarkan tahun dan bulan
     * Route: GET /berita/arsip/{tahun}/{bulan?}
     * 
     * @param int $tahun
     * @param int|null $bulan
     * @return \Illuminate\Contracts\View\View
     */
    public function arsip($tahun, $bulan = null)
    {
        $query = Berita::whereYear('created_at', $tahun);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $berita = $query->orderBy('created_at', 'desc')
            ->paginate(12);

        // Statistik bulan untuk tahun tersebut
        $statistikBulan = Berita::whereYear('created_at', $tahun)
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

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

        return view('frontend.berita.arsip', compact(
            'berita',
            'tahun',
            'bulan',
            'statistikBulan',
            'namaBulan'
        ));
    }

    /**
     * Widget berita untuk dashboard atau sidebar
     * Route: GET /api/berita/widget
     * 
     * @return array
     */
    public function widget()
    {
        $beritaTerbaru = Berita::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'judul', 'created_at']);

        $beritaPopuler = Berita::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'judul', 'created_at']);

        $totalBerita = Berita::count();
        $totalViews = 0; // views column not available

        return [
            'terbaru' => $beritaTerbaru,
            'populer' => $beritaPopuler,
            'total_berita' => $totalBerita,
            'total_views' => $totalViews
        ];
    }
}

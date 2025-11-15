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
     * @return array
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
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        // Data tambahan untuk filter
        $kategoris = Berita::select('kategori')
            ->where('status', 'published')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        $tahuns = Berita::selectRaw('YEAR(created_at) as tahun')
            ->where('status', 'published')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Statistik
        $totalBerita = Berita::where('status', 'published')->count();
        $beritaBulanIni = Berita::where('status', 'published')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $data = [
            'berita' => $berita,
            'kategoris' => $kategoris,
            'tahuns' => $tahuns,
            'search' => $search,
            'kategori' => $kategori,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'totalBerita' => $totalBerita,
            'beritaBulanIni' => $beritaBulanIni
        ];
        return view('frontend.Berita.index', $data);
    }

    /**
     * Menampilkan detail berita
     * Route: GET /berita/{id}
     * 
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        // Cari berita berdasarkan ID
        $berita = Berita::where('status', 'published')
            ->findOrFail($id);

        // Increment view count
        $berita->increment('views');

        // Berita terkait (kategori sama, exclude current)
        $beritaTerkait = Berita::where('status', 'published')
            ->where('kategori', $berita->kategori)
            ->where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Berita terbaru untuk sidebar
        $beritaTerbaru = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $data = [
            'berita' => $berita,
            'beritaTerkait' => $beritaTerkait,
            'beritaTerbaru' => $beritaTerbaru
        ];
        return view('frontend.Berita.show', $data);
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
        $berita = Berita::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['id', 'judul', 'slug', 'konten', 'gambar_url', 'created_at', 'penulis', 'kategori']);

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
        $berita = Berita::where('status', 'published')
            ->orderBy('views', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get(['id', 'judul', 'slug', 'konten', 'gambar_url', 'views', 'created_at', 'penulis']);

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

        $results = Berita::where('status', 'published')
            ->where(function ($q) use ($query) {
                $q->where('judul', 'like', "%{$query}%")
                    ->orWhere('konten', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get(['id', 'judul', 'slug', 'created_at']);

        return response()->json($results);
    }

    /**
     * Berita berdasarkan kategori
     * Route: GET /berita/kategori/{kategori}
     * 
     * @param string $kategori
     * @param Request $request
     * @return array
     */
    public function kategori($kategori, Request $request)
    {
        $search = $request->get('search');
        $tahun = $request->get('tahun');
        $bulan = $request->get('bulan'); // <-- Tambahkan ini

        $query = Berita::where('status', 'published')
            ->where('kategori', $kategori);

        // Terapkan filter tambahan
        $query->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('isi', 'like', "%{$search}%");
                });
            })
            ->when($tahun, function ($query, $tahun) {
                return $query->whereYear('created_at', $tahun);
            })
            ->when($bulan, function ($query, $bulan) { // <-- Tambahkan filter bulan
                return $query->whereMonth('created_at', $bulan);
            });

        $berita = $query->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString(); // <-- TAMBAHKAN INI

        // Data untuk filter (HARUS SAMA DENGAN METHOD INDEX)
        $kategoris = Berita::select('kategori')
            ->where('status', 'published')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        $tahuns = Berita::selectRaw('YEAR(created_at) as tahun')
            ->where('status', 'published')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Statistik (HARUS SAMA DENGAN METHOD INDEX)
        $totalBerita = Berita::where('status', 'published')->count();
        $beritaBulanIni = Berita::where('status', 'published')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Kirim semua data yang dibutuhkan oleh view index
        $data = [
            'berita' => $berita,
            'kategoris' => $kategoris, // <-- Tambahkan ini
            'tahuns' => $tahuns,
            'search' => $search,
            'kategori' => $kategori, // Ini dari parameter URL, bukan form
            'tahun' => $tahun,
            'bulan' => $bulan, // <-- Tambahkan ini
            'totalBerita' => $totalBerita, // <-- Tambahkan ini
            'beritaBulanIni' => $beritaBulanIni // <-- Tambahkan ini
        ];
        
        return view('frontend.Berita.index', $data);
    }

    /**
     * Arsip berita berdasarkan tahun dan bulan
     * Route: GET /berita/arsip/{tahun}/{bulan?}
     * 
     * @param int $tahun
     * @param int|null $bulan
     * @return array
     */
    public function arsip($tahun, $bulan = null)
    {
        $query = Berita::where('status', 'published')
            ->whereYear('created_at', $tahun);

        if ($bulan) {
            $query->whereMonth('created_at', $bulan);
        }

        $berita = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        // Statistik bulan untuk tahun tersebut
        $statistikBulan = Berita::where('status', 'published')
            ->whereYear('created_at', $tahun)
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

        $data = [
            'berita' => $berita,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'statistikBulan' => $statistikBulan,
            'namaBulan' => $namaBulan
        ];
        return view('frontend.Berita.arsip', $data);
    }

    /**
     * Widget berita untuk dashboard atau sidebar
     * Route: GET /api/berita/widget
     * 
     * @return array
     */
    public function widget()
    {
        $beritaTerbaru = Berita::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'judul', 'slug', 'created_at']);

        $beritaPopuler = Berita::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get(['id', 'judul', 'slug', 'views']);

        $totalBerita = Berita::where('status', 'published')->count();
        $totalViews = Berita::where('status', 'published')->sum('views');

        return [
            'terbaru' => $beritaTerbaru,
            'populer' => $beritaPopuler,
            'total_berita' => $totalBerita,
            'total_views' => $totalViews
        ];
    }
}

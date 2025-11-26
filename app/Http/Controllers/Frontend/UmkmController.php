<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\KategoriUmkm;
use Illuminate\Http\Request;

/**
 * Frontend UmkmController - Untuk menampilkan data UMKM di website publik
 * 
 * Controller ini mengambil data dari database dan mengirimnya ke Blade template
 * Tidak memerlukan API, langsung render HTML
 */
class UmkmController extends Controller
{
    /**
     * Menampilkan halaman daftar semua UMKM
     * Route: GET /umkm
     */
    public function index(Request $request)
    {
        // 1. Mengambil parameter filter dari URL
        $kategori_id = $request->get('kategori');
        $search = $request->get('search');
        $dusun = $request->get('dusun');

        // 2. Query dasar - hanya UMKM yang aktif
        $query = Umkm::with('kategori')  // Eager loading relasi kategori
            ->where('status_usaha', 'aktif');  // Hanya tampilkan yang aktif

        // 3. Filter berdasarkan kategori (jika dipilih)
        if ($kategori_id) {
            $query->where('kategori_id', $kategori_id);
        }

        // 4. Filter berdasarkan pencarian (jika ada)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('pemilik', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhere('jenis_usaha', 'like', "%{$search}%");
            });
        }

        // 5. Filter berdasarkan dusun (jika dipilih)
        if ($dusun) {
            $query->where('dusun', $dusun);
        }

        // 6. Urutkan dan paginate
        $umkms = $query->orderBy('nama', 'asc')
            ->paginate(12); // 12 UMKM per halaman

        // 7. Data tambahan untuk filter dropdown
        $kategoris = KategoriUmkm::where('is_active', true)
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $dusuns = Umkm::whereNotNull('dusun')
            ->where('status_usaha', 'aktif')
            ->distinct()
            ->pluck('dusun')
            ->sort();

        // 8. Data statistik untuk info
        $totalUmkm = Umkm::where('status_usaha', 'aktif')->count();
        $totalKategori = KategoriUmkm::where('is_active', true)->count();

        // 9. Kirim data ke view
        return view('frontend.umkm.index', compact(
            'umkms',        // Data UMKM dengan pagination
            'kategoris',    // Daftar kategori untuk filter
            'dusuns',       // Daftar dusun untuk filter
            'totalUmkm',    // Total UMKM aktif
            'totalKategori', // Total kategori aktif
            'search',       // Keyword pencarian (untuk maintain form)
            'kategori_id',  // Kategori terpilih (untuk maintain form)
            'dusun'         // Dusun terpilih (untuk maintain form)
        ));
    }

    /**
     * Menampilkan detail UMKM
     * Route: GET /umkm/{slug}
     */
    public function show($slug)
    {
        $umkm = Umkm::with('kategori')
            ->where('slug', $slug)
            ->where('status_usaha', 'aktif')
            ->firstOrFail();

        $relatedUmkms = Umkm::where('kategori_id', $umkm->kategori_id)
            ->where('id', '!=', $umkm->id)
            ->where('status_usaha', 'aktif')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('frontend.umkm.show', compact('umkm', 'relatedUmkms'));
    }

    /**
     * Menampilkan UMKM berdasarkan kategori
     * Parameter $slug di sini sebenarnya adalah slug dari nama kategori
     */
    public function kategori($slug)
    {
        // Karena di database KategoriUmkm tidak ada kolom 'slug',
        // kita harus mencari manual atau menambahkan kolom slug ke database.
        // Solusi cepat: Cari berdasarkan nama yang di-slug-kan
        
        $kategori = KategoriUmkm::where('is_active', true)->get()->first(function ($k) use ($slug) {
            return Str::slug($k->nama_kategori) === $slug;
        });

        if (!$kategori) {
            abort(404, 'Kategori tidak ditemukan');
        }

        $umkms = Umkm::where('kategori_id', $kategori->id)
            ->where('status_usaha', 'aktif')
            ->with('kategori')
            ->orderBy('nama', 'asc')
            ->paginate(12);

        $totalUmkm = $umkms->total();

        return view('frontend.umkm.kategori', compact('kategori', 'umkms', 'totalUmkm'));
    }

    /**
     * API Sederhana untuk AJAX (Opsional)
     * Route: GET /umkm/search-ajax
     */
    public function searchAjax(Request $request)
    {
        $search = $request->get('q');

        $umkms = Umkm::where('status_usaha', 'aktif')
            ->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('pemilik', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get(['id', 'nama', 'pemilik', 'slug']);

        return response()->json($umkms);
    }

    /**
     * Menampilkan dashboard UMKM
     * Route: GET /umkm/dashboard
     */
    public function dashboard()
    {
        return view('frontend.umkm.dashboard');
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GaleriController extends Controller
{
    /**
     * Menampilkan halaman galeri dengan gambar dari berita dan UMKM
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all'); // all, berita, umkm
        $search = $request->get('search', '');

        $galeri = $this->getGaleriImages($type, $search);

        // Pagination manual untuk koleksi gabungan
        $perPage = 12;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $items = $galeri->slice($offset, $perPage)->values()->toArray();
        $totalItems = $galeri->count();
        $totalPages = ceil($totalItems / $perPage);

        return view('frontend.galeri.index', compact(
            'items',
            'currentPage',
            'totalPages',
            'totalItems',
            'type',
            'search'
        ));
    }

    /**
     * API untuk mendapatkan gambar galeri (untuk AJAX)
     */
    public function api(Request $request)
    {
        $type = $request->get('type', 'all');
        $search = $request->get('search', '');
        $limit = $request->get('limit', 8);

        $galeri = $this->getGaleriImages($type, $search)->take($limit);

        return response()->json([
            'success' => true,
            'data' => $galeri->values(),
            'total' => $galeri->count()
        ]);
    }

    /**
     * Mengambil gambar dari berbagai sumber
     */
    private function getGaleriImages($type = 'all', $search = ''): Collection
    {
        $galeri = collect();

        // Ambil dari Berita
        if ($type === 'all' || $type === 'berita') {
            $beritaQuery = Berita::whereNotNull('gambar_url');

            if ($search) {
                $beritaQuery->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%");
                });
            }

            $beritaItems = $beritaQuery->orderBy('created_at', 'desc')->get()->map(function ($berita) {
                return [
                    'id' => 'berita_' . $berita->id,
                    'title' => $berita->judul,
                    'description' => 'Berita oleh ' . $berita->penulis,
                    'image' => $berita->image_url,
                    'date' => $berita->created_at->format('d M Y'),
                    'type' => 'berita',
                    'url' => route('berita.show', $berita->id),
                    'created_at' => $berita->created_at,
                ];
            });

            $galeri = $galeri->merge($beritaItems);
        }

        // Ambil dari UMKM (Logo)
        if ($type === 'all' || $type === 'umkm') {
            $umkmQuery = Umkm::whereNotNull('logo_path');

            if ($search) {
                $umkmQuery->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('pemilik', 'like', "%{$search}%");
                });
            }

            $umkmLogos = $umkmQuery->orderBy('created_at', 'desc')->get()->map(function ($umkm) {
                return [
                    'id' => 'umkm_logo_' . $umkm->id,
                    'title' => 'Logo ' . $umkm->nama,
                    'description' => 'UMKM oleh ' . $umkm->pemilik,
                    'image' => asset('storage/' . $umkm->logo_path),
                    'date' => $umkm->created_at->format('d M Y'),
                    'type' => 'umkm',
                    'url' => route('umkm.show', $umkm->slug),
                    'created_at' => $umkm->created_at,
                ];
            });

            $galeri = $galeri->merge($umkmLogos);

            // Ambil dari UMKM (Galeri Foto)
            $umkmGaleriQuery = Umkm::whereNotNull('foto_galeri_paths');

            if ($search) {
                $umkmGaleriQuery->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('pemilik', 'like', "%{$search}%");
                });
            }

            $umkmGaleriItems = $umkmGaleriQuery->orderBy('created_at', 'desc')->get()->flatMap(function ($umkm) {
                if (!$umkm->foto_galeri_paths || !is_array($umkm->foto_galeri_paths)) {
                    return [];
                }

                return collect($umkm->foto_galeri_paths)->map(function ($foto, $index) use ($umkm) {
                    return [
                        'id' => 'umkm_galeri_' . $umkm->id . '_' . $index,
                        'title' => $umkm->nama . ' - Foto ' . ($index + 1),
                        'description' => 'Galeri UMKM oleh ' . $umkm->pemilik,
                        'image' => asset('storage/' . $foto),
                        'date' => $umkm->created_at->format('d M Y'),
                        'type' => 'umkm',
                        'url' => route('umkm.show', $umkm->slug),
                        'created_at' => $umkm->created_at,
                    ];
                });
            });

            $galeri = $galeri->merge($umkmGaleriItems);
        }

        // Sort berdasarkan tanggal terbaru
        return $galeri->sortByDesc('created_at');
    }
}

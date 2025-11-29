<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Berita (Pastikan menggunakan gambar_url sesuai Model Berita)
        $berita = Berita::whereNotNull('gambar_url')
            ->where('gambar_url', '!=', '')
            ->latest()
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'type' => 'Berita',
                    'title' => $item->judul,
                    'image' => $item->gambar_url, // Akses via attribute model / kolom DB
                    'url' => route('berita.show', $item->id), // Sesuaikan parameter route
                    'date' => $item->created_at,
                    'description' => Str::limit(strip_tags($item->isi), 100)
                ];
            });

        // 2. Ambil UMKM (FIX: Menggunakan 'logo_url' sesuai tabel database)
        $umkm = Umkm::where('status_usaha', 'aktif')
            ->whereNotNull('logo_url') // UBAH DISINI: gambar -> logo_url
            ->where('logo_url', '!=', '') // UBAH DISINI: gambar -> logo_url
            ->latest()
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'type' => 'UMKM',
                    'title' => $item->nama,
                    'image' => $item->logo_url, // UBAH DISINI: ambil dari logo_url
                    'url' => route('umkm.show', $item->id),
                    'date' => $item->created_at,
                    'description' => Str::limit($item->deskripsi, 100)
                ];
            });

        // 3. Gabungkan dan Sortir
        $gabungan = $berita->merge($umkm)->sortByDesc('date');

        // 4. Manual Pagination
        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $gabungan->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $galeri = new LengthAwarePaginator(
            $currentItems,
            $gabungan->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('frontend.galeri.index', compact('galeri'));
    }
}
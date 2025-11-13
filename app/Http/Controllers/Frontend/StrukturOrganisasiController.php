<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;

/**
 * Frontend StrukturOrganisasiController - Untuk menampilkan struktur organisasi desa
 * 
 * Controller ini menyediakan method untuk menampilkan:
 * - Struktur organisasi lengkap dengan hirarki
 * - Detail profil pejabat
 * - Organisasi berdasarkan jabatan/divisi
 */
class StrukturOrganisasiController extends Controller
{
    /**
     * Menampilkan struktur organisasi lengkap
     * Route: GET /struktur-organisasi
     * 
     * @return array
     */
    public function index()
    {
        // Ambil semua struktur organisasi yang aktif
        $strukturOrganisasi = StrukturOrganisasi::where('status_aktif', true)
            ->orderBy('urutan_tampil')
            ->orderBy('nama_jabatan')
            ->get();

        // Group berdasarkan level hirarki atau divisi
        $strukturByLevel = $strukturOrganisasi->groupBy('level_jabatan');

        // Statistik
        $totalPejabat = $strukturOrganisasi->count();
        $totalJabatan = $strukturOrganisasi->pluck('nama_jabatan')->unique()->count();

        // Jabatan utama (Kepala Desa, Sekdes, dll)
        $jabatanUtama = $strukturOrganisasi->whereIn('level_jabatan', [1, 2])->sortBy('urutan_tampil');

        // Staff dan jabatan lainnya
        $jabatanStaff = $strukturOrganisasi->where('level_jabatan', '>', 2)->sortBy('urutan_tampil');

        return [
            'strukturOrganisasi' => $strukturOrganisasi,
            'strukturByLevel' => $strukturByLevel,
            'totalPejabat' => $totalPejabat,
            'totalJabatan' => $totalJabatan,
            'jabatanUtama' => $jabatanUtama,
            'jabatanStaff' => $jabatanStaff
        ];
    }

    /**
     * Menampilkan detail pejabat berdasarkan ID
     * Route: GET /struktur-organisasi/{id}
     * 
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        $pejabat = StrukturOrganisasi::where('status_aktif', true)
            ->findOrFail($id);

        // Pejabat lain di level yang sama
        $pejabatSejabat = StrukturOrganisasi::where('status_aktif', true)
            ->where('level_jabatan', $pejabat->level_jabatan)
            ->where('id', '!=', $pejabat->id)
            ->orderBy('urutan_tampil')
            ->get();

        return [
            'pejabat' => $pejabat,
            'pejabatSejabat' => $pejabatSejabat
        ];
    }

    /**
     * Struktur organisasi berdasarkan divisi/bagian
     * Route: GET /struktur-organisasi/divisi/{divisi}
     * 
     * @param string $divisi
     * @return array
     */
    public function divisi($divisi)
    {
        $pejabatDivisi = StrukturOrganisasi::where('status_aktif', true)
            ->where('divisi', $divisi)
            ->orderBy('level_jabatan')
            ->orderBy('urutan_tampil')
            ->get();

        // Daftar semua divisi untuk navigasi
        $semuaDivisi = StrukturOrganisasi::where('status_aktif', true)
            ->select('divisi')
            ->distinct()
            ->pluck('divisi')
            ->filter()
            ->sort();

        $totalPejabatDivisi = $pejabatDivisi->count();

        return [
            'pejabatDivisi' => $pejabatDivisi,
            'divisi' => $divisi,
            'semuaDivisi' => $semuaDivisi,
            'totalPejabatDivisi' => $totalPejabatDivisi
        ];
    }

    /**
     * Widget struktur organisasi untuk sidebar/homepage
     * Route: GET /api/struktur-organisasi/widget
     * 
     * @return array
     */
    public function widget()
    {
        // Pejabat utama saja (Kades, Sekdes, dll)
        $pejabatUtama = StrukturOrganisasi::where('status_aktif', true)
            ->whereIn('level_jabatan', [1, 2])
            ->orderBy('urutan_tampil')
            ->get(['id', 'nama', 'nama_jabatan', 'foto_url']);

        $totalPejabat = StrukturOrganisasi::where('status_aktif', true)->count();

        return [
            'pejabatUtama' => $pejabatUtama,
            'totalPejabat' => $totalPejabat
        ];
    }

    /**
     * Bagan organisasi dalam format JSON untuk chart
     * Route: GET /api/struktur-organisasi/bagan
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function bagan()
    {
        $struktur = StrukturOrganisasi::where('status_aktif', true)
            ->orderBy('level_jabatan')
            ->orderBy('urutan_tampil')
            ->get();

        // Format untuk organizational chart
        $baganData = [];
        foreach ($struktur as $pejabat) {
            $baganData[] = [
                'id' => $pejabat->id,
                'name' => $pejabat->nama,
                'title' => $pejabat->nama_jabatan,
                'level' => $pejabat->level_jabatan,
                'divisi' => $pejabat->divisi,
                'foto' => $pejabat->foto_url,
                'kontak' => $pejabat->kontak,
                'email' => $pejabat->email
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $baganData,
            'total' => count($baganData)
        ]);
    }

    /**
     * Pencarian pejabat
     * Route: GET /struktur-organisasi/search
     * 
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function search(\Illuminate\Http\Request $request)
    {
        $query = $request->get('search');
        $divisi = $request->get('divisi');
        $level = $request->get('level');

        $results = StrukturOrganisasi::where('status_aktif', true)
            ->when($query, function ($q) use ($query) {
                return $q->where(function ($search) use ($query) {
                    $search->where('nama', 'like', "%{$query}%")
                        ->orWhere('nama_jabatan', 'like', "%{$query}%")
                        ->orWhere('divisi', 'like', "%{$query}%");
                });
            })
            ->when($divisi, function ($q) use ($divisi) {
                return $q->where('divisi', $divisi);
            })
            ->when($level, function ($q) use ($level) {
                return $q->where('level_jabatan', $level);
            })
            ->orderBy('level_jabatan')
            ->orderBy('urutan_tampil')
            ->get();

        // Filter options
        $divisiOptions = StrukturOrganisasi::where('status_aktif', true)
            ->select('divisi')
            ->distinct()
            ->pluck('divisi')
            ->filter()
            ->sort();

        $levelOptions = StrukturOrganisasi::where('status_aktif', true)
            ->select('level_jabatan')
            ->distinct()
            ->orderBy('level_jabatan')
            ->pluck('level_jabatan');

        return [
            'results' => $results,
            'query' => $query,
            'divisi' => $divisi,
            'level' => $level,
            'divisiOptions' => $divisiOptions,
            'levelOptions' => $levelOptions,
            'totalResults' => $results->count()
        ];
    }

    /**
     * Kontak pejabat untuk emergency atau informasi penting
     * Route: GET /api/struktur-organisasi/kontak
     * 
     * @return array
     */
    public function kontak()
    {
        $kontakPenting = StrukturOrganisasi::where('status_aktif', true)
            ->whereNotNull('kontak')
            ->whereIn('level_jabatan', [1, 2, 3]) // Level penting saja
            ->orderBy('level_jabatan')
            ->get(['id', 'nama', 'nama_jabatan', 'kontak', 'email', 'divisi']);

        return [
            'kontakPenting' => $kontakPenting,
            'total' => $kontakPenting->count()
        ];
    }
}

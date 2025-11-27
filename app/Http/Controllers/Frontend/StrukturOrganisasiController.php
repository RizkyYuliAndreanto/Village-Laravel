<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    /**
     * Menampilkan halaman daftar struktur organisasi
     * Route: GET /struktur-organisasi
     */
    public function index()
    {
        // Ambil semua data struktur organisasi
        // Menggunakan orderBy id_struktur karena kolom 'urutan_tampil' tidak ada di database
        $strukturOrganisasi = StrukturOrganisasi::orderBy('id_struktur', 'asc')->get();

        // Hitung statistik sederhana (opsional)
        $totalPejabat = $strukturOrganisasi->count();
        $totalJabatan = $strukturOrganisasi->pluck('jabatan')->unique()->count();

        // Return ke View
        return view('frontend.profil-desa.sections.struktur-anggota.index', [
            // PERBAIKAN: Menggunakan nama 'strukturOrganisasi' agar sesuai dengan View
            'strukturOrganisasi' => $strukturOrganisasi, 
            'pageTitle'    => 'Struktur Organisasi Pemerintahan Desa',
            'totalPejabat' => $totalPejabat,
            'totalJabatan' => $totalJabatan
        ]);
    }

    /**
     * Menampilkan detail anggota struktur
     * Route: GET /struktur-organisasi/{id}
     */
    public function show($id)
    {
        $anggota = StrukturOrganisasi::findOrFail($id);

        return view('frontend.profil-desa.sections.struktur-anggota.show', [
            'anggota'   => $anggota,
            'pageTitle' => $anggota->nama . ' - ' . $anggota->jabatan
        ]);
    }

    /**
     * Widget struktur organisasi untuk sidebar/homepage (API)
     */
    public function widget()
    {
        $pejabatUtama = StrukturOrganisasi::orderBy('id_struktur', 'asc')
            ->take(4)
            ->get(['id_struktur as id', 'nama', 'jabatan as nama_jabatan', 'foto_url']);

        $totalPejabat = StrukturOrganisasi::count();

        return [
            'pejabatUtama' => $pejabatUtama,
            'totalPejabat' => $totalPejabat
        ];
    }
}
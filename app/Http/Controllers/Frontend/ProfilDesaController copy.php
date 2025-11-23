<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StrukturOrganisasi;

class ProfilDesaController extends Controller
{
    /**
     * Tampilkan halaman profil desa
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Data struktur organisasi dari database
        $strukturOrganisasi = StrukturOrganisasi::orderBy('create_at', 'asc')
            ->get();

        return view('frontend.profil-desa.index', compact('strukturOrganisasi'));
    }

    /**
     * Section Visi Misi (static content)
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function visiMisi()
    {
        return view('frontend.profil-desa.visi-misi');
    }

    /**
     * Section Struktur Organisasi
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function strukturOrganisasi()
    {
        $strukturOrganisasi = StrukturOrganisasi::orderBy('create_at', 'asc')
            ->get();

        return view('frontend.profil-desa.struktur-organisasi', compact('strukturOrganisasi'));
    }

    /**
     * Section Potensi Desa (static content)
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function potensiDesa()
    {
        return view('frontend.profil-desa.potensi-desa');
    }

    /**
     * Section Peta Desa
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function petaDesa()
    {
        return view('frontend.profil-desa.peta-desa');
    }
}

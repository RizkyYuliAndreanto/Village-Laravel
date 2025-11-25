<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use App\Models\TahunData;
use App\Models\DemografiPenduduk;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use Illuminate\Http\Request;

class ProfilDesaController extends Controller
{
    public function index()
    {
        // 1. Data Struktur Organisasi
        $strukturOrganisasi = StrukturOrganisasi::orderBy('id_struktur', 'asc')->get();

        // 2. Ambil Tahun Data Terbaru
        $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
        $tahunId = $tahunTerbaru ? $tahunTerbaru->id_tahun : null;

        // --- A. DATA DEMOGRAFI (SDM) ---
        $demografi = $tahunId ? DemografiPenduduk::where('tahun_id', $tahunId)->first() : null;

        // Estimasi KK (Total Penduduk / 4) jika data KK kosong
        $estimasiKK = $demografi ? floor($demografi->total_penduduk / 4) : 0;

        $sdmStats = [
            'laki_laki' => $demografi->laki_laki ?? 0,
            'perempuan' => $demografi->perempuan ?? 0,
            'kk'        => $estimasiKK,
        ];

        // --- B. DATA PEKERJAAN (Sesuai Model PekerjaanStatistik) ---
        $pekerjaan = $tahunId ? PekerjaanStatistik::where('tahun_id', $tahunId)->first() : null;

        $pekerjaanStats = [
            // Kolom 'petani' ada di DB
            'pertanian'     => $pekerjaan->petani ?? 0,

            // Mapping 'wiraswasta' ke label Perdagangan/Wiraswasta
            'wiraswasta'    => $pekerjaan->wiraswasta ?? 0,

            // Mapping 'pegawai_swasta' ke label Jasa/Karyawan
            'pegawai_swasta' => $pekerjaan->pegawai_swasta ?? 0,

            // Kolom 'belum_bekerja' ada di DB
            'belum_bekerja' => $pekerjaan->belum_bekerja ?? 0,

            // PNS & Buruh Tani tidak ada kolom khususnya di model, set 0
            'pns_tni'       => 0,
            'buruh_tani'    => 0,
        ];

        // --- C. DATA PENDIDIKAN (Sesuai Model PendidikanStatistik) ---
        $pendidikan = $tahunId ? PendidikanStatistik::where('tahun_id', $tahunId)->first() : null;

        $pendidikanStats = [
            // Gabungkan semua jenjang tinggi (D1-D4 + S1 + S2 + S3)
            'sarjana'       => ($pendidikan->d1_d4 ?? 0) + ($pendidikan->s1 ?? 0) + ($pendidikan->s2 ?? 0) + ($pendidikan->s3 ?? 0),

            'slta'          => $pendidikan->sma ?? 0,
            'sltp'          => $pendidikan->smp ?? 0,
            'sd'            => $pendidikan->sd ?? 0,
            'tidak_sekolah' => $pendidikan->tidak_sekolah ?? 0,
        ];

        return view('frontend.profil-desa.index', compact(
            'strukturOrganisasi',
            'sdmStats',
            'pekerjaanStats',
            'pendidikanStats'
        ));
    }

    // Method static lainnya biarkan tetap ada
    public function visiMisi()
    {
        return view('frontend.profil-desa.visi-misi');
    }

    public function strukturOrganisasi()
    {
        $strukturOrganisasi = StrukturOrganisasi::orderBy('id_struktur', 'asc')->get();
        return view('frontend.profil-desa.sections.struktur-organisasi', compact('strukturOrganisasi'));
    }

    public function strukturSemua()
    {
        $strukturOrganisasi = StrukturOrganisasi::orderBy('id_struktur', 'asc')->get();

        return view('frontend.profil-desa.sections.struktur-anggota.index', compact('strukturOrganisasi'));
    }

    public function strukturShow($id)
    {
        $item = StrukturOrganisasi::where('id_struktur', $id)->firstOrFail();

        return view('frontend.profil-desa.sections.struktur-anggota.show', compact('item'));
    }
    public function potensiDesa()
    {
        return view('frontend.profil-desa.potensi-desa');
    }

    public function petaDesa()
    {
        return view('frontend.profil-desa.peta-desa');
    }
}

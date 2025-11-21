<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use App\Models\UmurStatistik;
use App\Models\AgamaStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Models\DusunStatistik;
use Illuminate\Http\Request;

/**
 * InfografisController - Khusus untuk halaman infografis
 * 
 * Controller ini menangani halaman infografis yang menampilkan
 * ringkasan data demografi dalam bentuk visual yang menarik
 */
class InfografisController extends Controller
{
    /**
     * Halaman Infografis Utama
     * Route: GET /infografis
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Ambil tahun dari request atau default ke tahun terbaru yang tersedia
        $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
        $defaultTahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        $tahun = $request->get('tahun', $defaultTahun);

        // Ambil data tahun yang dipilih
        $tahunData = TahunData::where('tahun', $tahun)->first();
        if (!$tahunData) {
            // Jika tahun tidak ditemukan, gunakan tahun terbaru
            $tahunData = $tahunTerbaru;
            $tahun = $tahunData ? $tahunData->tahun : date('Y');
        }

        // Ambil semua data yang tersedia untuk tahun tersebut
        $tahunId = $tahunData ? $tahunData->id_tahun : null;
        
        // Data demografi
        $demografi = DemografiPenduduk::where('tahun_id', $tahunId)->first();
        $demografiData = [
            'totalPenduduk' => $demografi->total_penduduk ?? 0,
            'totalLaki' => $demografi->laki_laki ?? 0,
            'totalPerempuan' => $demografi->perempuan ?? 0,
            'pendudukSementara' => $demografi->penduduk_sementara ?? 0,
            'mutasiPenduduk' => $demografi->mutasi_penduduk ?? 0,
        ];

        // Data umur
        $umurStatistik = UmurStatistik::where('tahun_id', $tahunId)->first();
        $umurData = [
            'umur_0_4' => $umurStatistik->umur_0_4 ?? 0,
            'umur_5_9' => $umurStatistik->umur_5_9 ?? 0,
            'umur_10_14' => $umurStatistik->umur_10_14 ?? 0,
            'umur_15_19' => $umurStatistik->umur_15_19 ?? 0,
            'umur_20_24' => $umurStatistik->umur_20_24 ?? 0,
            'umur_25_29' => $umurStatistik->umur_25_29 ?? 0,
            'umur_30_34' => $umurStatistik->umur_30_34 ?? 0,
            'umur_35_39' => $umurStatistik->umur_35_39 ?? 0,
            'umur_40_44' => $umurStatistik->umur_40_44 ?? 0,
            'umur_45_49' => $umurStatistik->umur_45_49 ?? 0,
            'umur_50_plus' => $umurStatistik->umur_50_plus ?? 0,
        ];

        // Data agama
        $agamaStatistik = AgamaStatistik::where('tahun_id', $tahunId)->first();
        $agamaData = [
            'islam' => $agamaStatistik->islam ?? 0,
            'katolik' => $agamaStatistik->katolik ?? 0,
            'kristen' => $agamaStatistik->kristen ?? 0,
            'hindu' => $agamaStatistik->hindu ?? 0,
            'buddha' => $agamaStatistik->buddha ?? 0,
            'konghucu' => $agamaStatistik->konghucu ?? 0,
            'kepercayaan_lain' => $agamaStatistik->kepercayaan_lain ?? 0,
        ];

        // Data pekerjaan
        $pekerjaanStatistik = PekerjaanStatistik::where('tahun_id', $tahunId)->first();
        $pekerjaanData = [
            'tidak_sekolah' => $pekerjaanStatistik->tidak_sekolah ?? 0,
            'petani' => $pekerjaanStatistik->petani ?? 0,
            'pelajar_mahasiswa' => $pekerjaanStatistik->pelajar_mahasiswa ?? 0,
            'pegawai_swasta' => $pekerjaanStatistik->pegawai_swasta ?? 0,
            'wiraswasta' => $pekerjaanStatistik->wiraswasta ?? 0,
            'ibu_rumah_tangga' => $pekerjaanStatistik->ibu_rumah_tangga ?? 0,
            'belum_bekerja' => $pekerjaanStatistik->belum_bekerja ?? 0,
            'lainnya' => $pekerjaanStatistik->lainnya ?? 0,
        ];

        // Data pendidikan
        $pendidikanStatistik = PendidikanStatistik::where('tahun_id', $tahunId)->first();
        $pendidikanData = [
            'tidak_sekolah_pendidikan' => $pendidikanStatistik->tidak_sekolah ?? 0,
            'sd' => $pendidikanStatistik->sd ?? 0,
            'smp' => $pendidikanStatistik->smp ?? 0,
            'sma' => $pendidikanStatistik->sma ?? 0,
            'd1_d4' => $pendidikanStatistik->d1_d4 ?? 0,
            's1' => $pendidikanStatistik->s1 ?? 0,
            's2' => $pendidikanStatistik->s2 ?? 0,
            's3' => $pendidikanStatistik->s3 ?? 0,
        ];

        // Data perkawinan
        $perkawinanStatistik = PerkawinanStatistik::where('tahun_id', $tahunId)->first();
        $perkawinanData = [
            'kawin' => $perkawinanStatistik->kawin ?? 0,
            'cerai_hidup' => $perkawinanStatistik->cerai_hidup ?? 0,
            'cerai_mati' => $perkawinanStatistik->cerai_mati ?? 0,
            'kawin_tercatat' => $perkawinanStatistik->kawin_tercatat ?? 0,
            'kawin_tidak_tercatat' => $perkawinanStatistik->kawin_tidak_tercatat ?? 0,
        ];

        // Data wajib pilih
        $wajibPilihStatistik = WajibPilihStatistik::where('tahun_id', $tahunId)->first();
        $wajibPilihData = [
            'wajib_pilih_laki' => $wajibPilihStatistik->laki_laki ?? 0,
            'wajib_pilih_perempuan' => $wajibPilihStatistik->perempuan ?? 0,
            'wajib_pilih_total' => $wajibPilihStatistik->total ?? 0,
        ];

        // Data dusun
        $dusunStatistik = DusunStatistik::where('tahun_id', $tahunId)->get();
        $dusunData = [
            'dusunStatistik' => $dusunStatistik,
        ];

        // Base data
        $baseData = [
            'tahunDataTerbaru' => $tahunTerbaru,
            'tahun' => $tahun,
            'tahunAktif' => $tahun,
            'tahunTersedia' => TahunData::orderBy('tahun', 'desc')->get()
        ];

        return view('frontend.infografis.index', array_merge(
            $baseData,
            $demografiData,
            $umurData,
            $agamaData,
            $pekerjaanData,
            $pendidikanData,
            $perkawinanData,
            $wajibPilihData,
            $dusunData
        ));
    }

    /**
     * API endpoint untuk mendapatkan data berdasarkan tahun
     */
    public function getData(Request $request)
    {
        $tahun = $request->get('tahun');
        $tahunData = TahunData::where('tahun', $tahun)->first();
        
        if (!$tahunData) {
            return response()->json(['error' => 'Data tahun tidak ditemukan'], 404);
        }

        $tahunId = $tahunData->id_tahun;
        
        // Ambil semua data untuk tahun tersebut
        return response()->json([
            'success' => true,
            'tahun' => $tahun,
            'demografi' => DemografiPenduduk::where('tahun_id', $tahunId)->first(),
            'umur' => UmurStatistik::where('tahun_id', $tahunId)->first(),
            'agama' => AgamaStatistik::where('tahun_id', $tahunId)->first(),
            'pekerjaan' => PekerjaanStatistik::where('tahun_id', $tahunId)->first(),
            'pendidikan' => PendidikanStatistik::where('tahun_id', $tahunId)->first(),
            'perkawinan' => PerkawinanStatistik::where('tahun_id', $tahunId)->first(),
            'wajibPilih' => WajibPilihStatistik::where('tahun_id', $tahunId)->first(),
            'dusun' => DusunStatistik::where('tahun_id', $tahunId)->get(),
        ]);
    }
}

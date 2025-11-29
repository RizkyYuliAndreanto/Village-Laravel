<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Infografis\StatistikController;
use App\Models\Berita;
use App\Models\TahunData;
use App\Models\LaporanApbdes;
use App\Models\DetailApbdes;
use App\Models\StrukturOrganisasi;
use App\Models\Umkm; 
use App\Models\DusunStatistik;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $statistikController;

    public function __construct()
    {
        $this->statistikController = new StatistikController();
    }

    public function index(Request $request)
    {
        // 1. Ambil tahun data terbaru
        $tahunDataTerbaru = $this->getTahunTerbaru();

        // 2. Ambil Data Statistik Penduduk
        $stats = $this->getStatistikPenduduk($tahunDataTerbaru->tahun);

        // 3. Kumpulkan data untuk View
        $data = [
            'tahunDataTerbaru' => $tahunDataTerbaru->tahun,

            // Statistik Penduduk
            'totalPenduduk'     => $stats['totalPenduduk'],
            'totalLaki'         => $stats['totalLaki'],
            'totalPerempuan'    => $stats['totalPerempuan'],
            'pendudukSementara' => $stats['pendudukSementara'],
            'mutasiPenduduk'    => $stats['mutasiPenduduk'],

            // Statistik Wilayah & Ekonomi
            'jumlahDusun'       => $this->getJumlahDusun($tahunDataTerbaru->tahun),
            'jumlahUmkm'        => Umkm::where('status_usaha', 'aktif')->count(),

            // Struktur Organisasi
            'sotk'              => $this->getStrukturOrganisasi(),

            // Data APBD
            'apbdData'          => $this->getAPBDData($tahunDataTerbaru->tahun),

            // Berita Terbaru
            'beritaTerbaru'     => $this->getBeritaTerbaru(),

            // Potensi desa
            'potensiDesa'       => $this->getPotensiDesa(),

            // Galeri (GABUNGAN BERITA + UMKM)
            'galeri'            => $this->getGaleriTerbaru()
        ];

        return view('frontend.home.index', $data);
    }

    // --- Private Helpers ---

    private function getTahunTerbaru()
    {
        $tahun = TahunData::orderBy('tahun', 'desc')->first();
        return $tahun ?: (object)['tahun' => date('Y')];
    }

    private function getStatistikPenduduk($tahun)
    {
        try {
            $dataRaw = $this->statistikController->getData($tahun);
            if (is_object($dataRaw)) $dataRaw = (array) $dataRaw;

            return [
                'totalPenduduk'     => $dataRaw['totalPenduduk'] ?? 0,
                'totalLaki'         => $dataRaw['totalLaki'] ?? 0,
                'totalPerempuan'    => $dataRaw['totalPerempuan'] ?? 0,
                'pendudukSementara' => $dataRaw['pendudukSementara'] ?? 0,
                'mutasiPenduduk'    => $dataRaw['mutasiPenduduk'] ?? 0
            ];
        } catch (\Exception $e) {
            return ['totalPenduduk' => 0, 'totalLaki' => 0, 'totalPerempuan' => 0, 'pendudukSementara' => 0, 'mutasiPenduduk' => 0];
        }
    }

    private function getJumlahDusun($tahun)
    {
        try {
            return DusunStatistik::whereHas('tahunData', fn($q) => $q->where('tahun', $tahun))->count();
        } catch (\Exception $e) { return 0; }
    }

    private function getStrukturOrganisasi()
    {
        try {
            return StrukturOrganisasi::orderBy('id_struktur', 'asc')
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            return collect();
        }
    }

    private function getAPBDData($tahun)
    {
        try {
            $laporanApbd = LaporanApbdes::whereHas('tahunData', function ($query) use ($tahun) {
                $query->where('tahun', $tahun);
            })
            ->where('status', 'diterbitkan')
            ->latest()
            ->first();

            if (!$laporanApbd) {
                $laporanApbd = LaporanApbdes::where('status', 'diterbitkan')->latest()->first();
            }

            if (!$laporanApbd) return ['hasData' => false];

            $pendapatanRealisasi = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('tipe', 'pendapatan')->sum('realisasi');
            $pendapatanTarget = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('tipe', 'pendapatan')->sum('anggaran');

            $belanjaRealisasi = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('tipe', 'belanja')->sum('realisasi');
            $belanjaTarget = DetailApbdes::where('laporan_apbdes_id', $laporanApbd->id)
                ->where('tipe', 'belanja')->sum('anggaran');

            return [
                'hasData' => true,
                'pendapatan' => [
                    'realisasi'  => $pendapatanRealisasi,
                    'target'     => $pendapatanTarget,
                    'persentase' => $pendapatanTarget > 0 ? ($pendapatanRealisasi / $pendapatanTarget) * 100 : 0
                ],
                'belanja' => [
                    'realisasi'  => $belanjaRealisasi,
                    'target'     => $belanjaTarget,
                    'persentase' => $belanjaTarget > 0 ? ($belanjaRealisasi / $belanjaTarget) * 100 : 0
                ]
            ];
        } catch (\Exception $e) {
            return ['hasData' => false];
        }
    }

    private function getBeritaTerbaru($limit = 6)
    {
        try {
            return Berita::orderByRaw('COALESCE(created_at) DESC')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) { return collect(); }
    }

    private function getPotensiDesa()
    {
        try {
            return Umkm::where('status_usaha', 'aktif')->inRandomOrder()->limit(3)->get();
        } catch (\Exception $e) { return collect(); }
    }

    private function getGaleriTerbaru($limit = 8)
    {
        try {
            // 1. Ambil Berita (Pastikan menggunakan 'gambar_url' sesuai Model Berita)
            $galeriBerita = Berita::whereNotNull('gambar_url')
                ->where('gambar_url', '!=', '')
                ->latest()
                ->take($limit)
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'type' => 'Berita',
                        'title' => $item->judul,
                        'image' => $item->gambar_url, // Sesuai kolom di Model Berita
                        'url' => route('berita.show', $item->id),
                        'date' => $item->created_at
                    ];
                });

            // 2. Ambil UMKM (Asumsi kolom 'gambar' atau 'foto_url' - sesuaikan dengan DB Anda)
            $galeriUmkm = Umkm::where('status_usaha', 'aktif')
                ->where(function($q) {
                    $q->whereNotNull('gambar')->where('gambar', '!=', '');
                    // Tambahkan orWhereNotNull('foto_url') jika nama kolomnya beda
                })
                ->latest()
                ->take($limit)
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'type' => 'UMKM',
                        'title' => $item->nama, 
                        'image' => $item->gambar, // Pastikan ini sesuai kolom di tabel UMKM
                        'url' => route('umkm.show', $item->id),
                        'date' => $item->created_at
                    ];
                });

            // 3. Gabung, Acak, dan Batasi jumlah
            return $galeriBerita->merge($galeriUmkm)->shuffle()->take($limit);
            
        } catch (\Exception $e) {
            return collect();
        }
    }
}
<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DemografiPenduduk;
use App\Models\UmurStatistik;
use App\Models\AgamaStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

class DemografiController extends Controller
{
    /**
     * Ambil id_tahun dari input tahun (angka), atau fallback ke tahun terbaru.
     *
     * @param  int|string|null $tahunInput
     * @return \App\Models\TahunData|null  (return object TahunData atau null)
     */
    protected function resolveTahunRecord($tahunInput = null)
    {
        // jika user tidak mengirim atau mengirim kosong, gunakan tahun sekarang sebagai angka
        $tahunInput = $tahunInput ?? date('Y');

        // cari record tahun_data berdasarkan angka tahun
        $tahunRecord = TahunData::where('tahun', $tahunInput)->first();

        // jika tidak ada, ambil yang paling terbaru
        if (! $tahunRecord) {
            $tahunRecord = TahunData::orderBy('tahun', 'desc')->first();
        }

        return $tahunRecord;
    }

    /**
     * Dashboard demografi lengkap (halaman Infografis / Demografi)
     * Route: GET /demografi
     */
    public function index(Request $request)
    {
        // 1. Resolve tahun (object TahunData)
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);

        // Jika tidak ada tahun apapun di database, tetap aman dengan nilai default
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;
        $tahunAngka = $tahunRecord ? $tahunRecord->tahun : date('Y');

        // 2. Ambil data demografi utama (menggunakan tahun_id)
        $demografi = $tahunId ? DemografiPenduduk::where('tahun_id', $tahunId)->first() : null;

        // jika tidak ada data demografi untuk tahun tersebut, coba ambil latest DemografiPenduduk
        if (! $demografi) {
            $demografi = DemografiPenduduk::orderBy('id_demografi', 'desc')->first();
        }

        // Extract ringkasan angka (beri default 0 bila null)
        $totalPenduduk = $demografi->total_penduduk ?? 0;
        $totalLaki = $demografi->laki_laki ?? 0;
        $totalPerempuan = $demografi->perempuan ?? 0;
        $pendudukSementara = $demografi->penduduk_sementara ?? 0;
        $mutasiPenduduk = $demografi->mutasi_penduduk ?? 0;
        $kepalaKeluarga = $demografi->kepala_keluarga ?? null; // bila ada

        // 3. Ambil statistik per-tabel (setiap tabel memakai kolom tahun_id)
        $umurData = $tahunId ? UmurStatistik::where('tahun_id', $tahunId)->first() : null;
        $agama = $tahunId ? AgamaStatistik::where('tahun_id', $tahunId)->first() : null;
        $pekerjaan = $tahunId ? PekerjaanStatistik::where('tahun_id', $tahunId)->first() : null;
        $pendidikan = $tahunId ? PendidikanStatistik::where('tahun_id', $tahunId)->first() : null;
        $perkawinan = $tahunId ? PerkawinanStatistik::where('tahun_id', $tahunId)->first() : null;
        $wajibPilih = $tahunId ? WajibPilihStatistik::where('tahun_id', $tahunId)->first() : null;

        // 4. Siapkan data chart yang biasa dipakai di view (fallbacks aman)
        // Piramida: kita tetap pakai umurData fields (umur_0_4 ...), set 0 bila null
        $umurDefaults = [
            'umur_0_4' => $umurData->umur_0_4 ?? 0,
            'umur_5_9' => $umurData->umur_5_9 ?? 0,
            'umur_10_14' => $umurData->umur_10_14 ?? 0,
            'umur_15_19' => $umurData->umur_15_19 ?? 0,
            'umur_20_24' => $umurData->umur_20_24 ?? 0,
            'umur_25_29' => $umurData->umur_25_29 ?? 0,
            'umur_30_34' => $umurData->umur_30_34 ?? 0,
            'umur_35_39' => $umurData->umur_35_39 ?? 0,
            'umur_40_44' => $umurData->umur_40_44 ?? 0,
            'umur_45_49' => $umurData->umur_45_49 ?? 0,
            'umur_50_plus' => $umurData->umur_50_plus ?? 0,
        ];

        // Pendidikan chart: $pendidikan mungkin null
        $pendidikanDefaults = [
            'tidak_sekolah' => $pendidikan->tidak_sekolah ?? 0,
            'sd' => $pendidikan->sd ?? 0,
            'smp' => $pendidikan->smp ?? 0,
            'sma' => $pendidikan->sma ?? 0,
            'd1_d4' => $pendidikan->d1_d4 ?? 0,
            's1' => $pendidikan->s1 ?? 0,
            's2' => $pendidikan->s2 ?? 0,
            's3' => $pendidikan->s3 ?? 0,
        ];

        // Pekerjaan: gunakan object $pekerjaan langsung di view (sudah dipakai di view kamu)
        // tapi buat default object minimal bila null untuk menghindari error
        if (! $pekerjaan) {
            // buat object sederhana agar view $pekerjaan->petani etc tidak error
            $pekerjaan = (object) [
                'petani' => 0,
                'belum_bekerja' => 0,
                'pelajar_mahasiswa' => 0,
                'ibu_rumah_tangga' => 0,
                'wiraswasta' => 0,
                'pegawai_swasta' => 0,
                'lainnya' => 0,
                'tidak_sekolah' => 0,
            ];
        }

        // Agama defaults (bila row terstruktur berbeda di view kamu sudah pakai $agama?->islam dll)
        if (! $agama) {
            $agama = (object) [
                'islam' => 0,
                'katolik' => 0,
                'kristen' => 0,
                'hindu' => 0,
                'buddha' => 0,
                'konghucu' => 0,
                'kepercayaan_lain' => 0
            ];
        }

        // Perkawinan defaults
        if (! $perkawinan) {
            $perkawinan = (object) [
                'kawin' => 0,
                'cerai_hidup' => 0,
                'cerai_mati' => 0,
                'kawin_tercatat' => 0,
                'kawin_tidak_tercatat' => 0
            ];
        }

        // WajibPilih chart labels & totals
        $wajibPilihLabels = ['Laki-laki', 'Perempuan'];
        $wajibPilihTotals = [0, 0];
        if ($wajibPilih) {
            $wajibPilihTotals = [
                $wajibPilih->laki_laki ?? 0,
                $wajibPilih->perempuan ?? 0
            ];
        }

        // Tahun yang tersedia pada dropdown / selector
        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();

        // Untuk perbandingan: ambil demografi tahun sebelumnya (gunakan tahun angka -> cari id lalu cari demografi)
        $tahunSebelumnyaAngka = $tahunAngka - 1;
        $tahunSebelumnyaRec = TahunData::where('tahun', $tahunSebelumnyaAngka)->first();
        $demografiSebelumnya = null;
        if ($tahunSebelumnyaRec) {
            $demografiSebelumnya = DemografiPenduduk::where('tahun_id', $tahunSebelumnyaRec->id_tahun)->first();
        }

        // 5. Kirim ke view frontend (frontend.demografi.index)
        return view('frontend.infografis.index', [
            // ringkasan
            'tahunDataTerbaru' => $tahunRecord,
            'totalPenduduk' => $totalPenduduk,
            'totalLaki' => $totalLaki,
            'totalPerempuan' => $totalPerempuan,
            'pendudukSementara' => $pendudukSementara,
            'mutasiPenduduk' => $mutasiPenduduk,
            'kepalaKeluarga' => $kepalaKeluarga,

            // data detail/statistik
            'demografi' => $demografi,
            'demografiSebelumnya' => $demografiSebelumnya,
            'umurData' => (object) $umurDefaults,
            'agama' => $agama,
            'pekerjaan' => $pekerjaan,
            'pendidikan' => (object) $pendidikanDefaults,
            'perkawinan' => $perkawinan,
            'wajibPilih' => $wajibPilih,

            // chart helpers
            'wajibPilihLabels' => $wajibPilihLabels,
            'wajibPilihTotals' => $wajibPilihTotals,

            // list tahun
            'tahunTersedia' => $tahunTersedia,
            'tahunTerpilih' => $tahunAngka,
        ]);
    }

    /**
     * Data demografi umum saja (API-style, tetap compatible)
     * Route: GET /demografi/umum
     */
    public function umum(Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;
        $demografi = $tahunId ? DemografiPenduduk::where('tahun_id', $tahunId)->first() : null;

        return [
            'demografi' => $demografi,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y')
        ];
    }

    /**
     * Statistik berdasarkan umur (API)
     * Route: GET /demografi/umur
     */
    public function umur(Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;

        $statistikUmur = $tahunId ? UmurStatistik::where('tahun_id', $tahunId)->orderBy('kelompok_umur')->get() : collect();
        $totalJiwa = $statistikUmur->sum('total_jiwa');

        $chartData = [
            'labels' => $statistikUmur->pluck('kelompok_umur')->toArray(),
            'datasets' => [
                [
                    'label' => 'Laki-laki',
                    'data' => $statistikUmur->pluck('laki_laki')->toArray()
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $statistikUmur->pluck('perempuan')->toArray()
                ]
            ]
        ];

        return [
            'statistikUmur' => $statistikUmur,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y')
        ];
    }

    /**
     * Statistik berdasarkan agama (API)
     * Route: GET /demografi/agama
     */
    public function agama(Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;

        $statistikAgama = $tahunId ? AgamaStatistik::where('tahun_id', $tahunId)->get() : collect();
        $totalJiwa = $statistikAgama->sum(function ($item) {
            // jika model menyimpan kolom agama terpisah, hitung total sesuai struktur model
            if (isset($item->total_jiwa)) {
                return $item->total_jiwa;
            }
            return ($item->islam ?? 0) + ($item->kristen ?? 0) + ($item->katolik ?? 0) + ($item->hindu ?? 0) + ($item->buddha ?? 0) + ($item->konghucu ?? 0) + ($item->kepercayaan_lain ?? 0);
        });

        $chartData = [
            'labels' => $statistikAgama->pluck('agama')->toArray(), // jika kamu pakai struktur 'agama' di row
            'datasets' => [[
                'data' => $statistikAgama->pluck('total_jiwa')->toArray()
            ]]
        ];

        return [
            'statistikAgama' => $statistikAgama,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y')
        ];
    }

    /**
     * Statistik berdasarkan pekerjaan (API)
     * Route: GET /demografi/pekerjaan
     */
    public function pekerjaan(Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;

        $statistikPekerjaan = $tahunId ? PekerjaanStatistik::where('tahun_id', $tahunId)->get() : collect();
        $totalJiwa = $statistikPekerjaan->sum('total_jiwa');

        return [
            'statistikPekerjaan' => $statistikPekerjaan,
            'totalJiwa' => $totalJiwa,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y')
        ];
    }

    /**
     * Statistik berdasarkan pendidikan (API)
     * Route: GET /demografi/pendidikan
     */
    public function pendidikan(Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;

        $statistikPendidikan = $tahunId ? PendidikanStatistik::where('tahun_id', $tahunId)->get() : collect();
        $totalJiwa = $statistikPendidikan->sum('total_jiwa');

        $chartData = [
            'labels' => $statistikPendidikan->pluck('tingkat_pendidikan')->toArray(),
            'datasets' => [[
                'label' => 'Jumlah Jiwa',
                'data' => $statistikPendidikan->pluck('total_jiwa')->toArray()
            ]]
        ];

        return [
            'statistikPendidikan' => $statistikPendidikan,
            'totalJiwa' => $totalJiwa,
            'chartData' => $chartData,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y')
        ];
    }

    /**
     * Perbandingan data antar tahun (API)
     * Route: GET /demografi/perbandingan
     */
    public function perbandingan(Request $request)
    {
        $tahun1Input = $request->get('tahun1', date('Y') - 1);
        $tahun2Input = $request->get('tahun2', date('Y'));

        $tahun1Rec = $this->resolveTahunRecord($tahun1Input);
        $tahun2Rec = $this->resolveTahunRecord($tahun2Input);

        $demografi1 = ($tahun1Rec) ? DemografiPenduduk::where('tahun_id', $tahun1Rec->id_tahun)->first() : null;
        $demografi2 = ($tahun2Rec) ? DemografiPenduduk::where('tahun_id', $tahun2Rec->id_tahun)->first() : null;

        $perbandingan = [];

        if ($demografi1 && $demografi2) {
            $perbandingan = [
                'total_jiwa' => [
                    'tahun1' => $demografi1->total_penduduk ?? 0,
                    'tahun2' => $demografi2->total_penduduk ?? 0,
                    'selisih' => ($demografi2->total_penduduk ?? 0) - ($demografi1->total_penduduk ?? 0),
                    'persentase' => ($demografi1->total_penduduk > 0) ?
                        round(((($demografi2->total_penduduk ?? 0) - $demografi1->total_penduduk) / $demografi1->total_penduduk) * 100, 2) : 0
                ],
                'laki_laki' => [
                    'tahun1' => $demografi1->laki_laki ?? 0,
                    'tahun2' => $demografi2->laki_laki ?? 0,
                    'selisih' => ($demografi2->laki_laki ?? 0) - ($demografi1->laki_laki ?? 0)
                ],
                'perempuan' => [
                    'tahun1' => $demografi1->perempuan ?? 0,
                    'tahun2' => $demografi2->perempuan ?? 0,
                    'selisih' => ($demografi2->perempuan ?? 0) - ($demografi1->perempuan ?? 0)
                ]
            ];
        }

        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();

        return [
            'demografi1' => $demografi1,
            'demografi2' => $demografi2,
            'perbandingan' => $perbandingan,
            'tahun1' => $tahun1Rec ? $tahun1Rec->tahun : $tahun1Input,
            'tahun2' => $tahun2Rec ? $tahun2Rec->tahun : $tahun2Input,
            'tahunTersedia' => $tahunTersedia
        ];
    }

    /**
     * Widget demografi untuk homepage/dashboard (API)
     * Route: GET /api/demografi/widget
     */
    public function widget()
    {
        $tahunRecord = TahunData::orderBy('tahun', 'desc')->first();
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;
        $tahunAngka = $tahunRecord ? $tahunRecord->tahun : date('Y');

        $demografi = $tahunId ? DemografiPenduduk::where('tahun_id', $tahunId)->first() : null;

        $ringkasan = [];
        if ($demografi) {
            $ringkasan = [
                'total_jiwa' => $demografi->total_penduduk ?? 0,
                'laki_laki' => $demografi->laki_laki ?? 0,
                'perempuan' => $demografi->perempuan ?? 0,
                'kepala_keluarga' => $demografi->kepala_keluarga ?? 0,
                'tahun' => $tahunAngka
            ];
        }

        $topAgama = $tahunId ? AgamaStatistik::where('tahun_id', $tahunId)->limit(3)->get() : collect();
        $topPekerjaan = $tahunId ? PekerjaanStatistik::where('tahun_id', $tahunId)->limit(3)->get() : collect();

        return [
            'ringkasan' => $ringkasan,
            'topAgama' => $topAgama,
            'topPekerjaan' => $topPekerjaan,
            'tahun' => $tahunAngka
        ];
    }

    /**
     * Chart API: GET /api/demografi/chart/{type}
     */
    public function chart($type, Request $request)
    {
        $tahunInput = $request->get('tahun', null);
        $tahunRecord = $this->resolveTahunRecord($tahunInput);
        $tahunId = $tahunRecord ? $tahunRecord->id_tahun : null;
        $chartData = [];

        switch ($type) {
            case 'umur':
                $data = $tahunId ? UmurStatistik::where('tahun_id', $tahunId)->orderBy('id_umur')->get() : collect();
                $chartData = [
                    'labels' => $data->pluck('kelompok_umur')->toArray(),
                    'datasets' => [
                        ['label' => 'Laki-laki', 'data' => $data->pluck('laki_laki')->toArray()],
                        ['label' => 'Perempuan', 'data' => $data->pluck('perempuan')->toArray()]
                    ]
                ];
                break;

            case 'agama':
                $data = $tahunId ? AgamaStatistik::where('tahun_id', $tahunId)->get() : collect();
                // try structured 'total_jiwa' or per-agama fields
                if ($data->isNotEmpty() && isset($data->first()->total_jiwa)) {
                    $chartData = [
                        'labels' => $data->pluck('agama')->toArray(),
                        'datasets' => [['data' => $data->pluck('total_jiwa')->toArray()]]
                    ];
                } else {
                    // aggregate per-field from single-row agama_statistik
                    $row = $data->first();
                    if ($row) {
                        $chartData = [
                            'labels' => ['Islam','Katolik','Kristen','Hindu','Buddha','Konghucu','Kepercayaan Lainnya'],
                            'datasets' => [[
                                'data' => [
                                    $row->islam ?? 0, $row->katolik ?? 0, $row->kristen ?? 0,
                                    $row->hindu ?? 0, $row->buddha ?? 0, $row->konghucu ?? 0, $row->kepercayaan_lain ?? 0
                                ]
                            ]]
                        ];
                    } else {
                        $chartData = ['labels' => [], 'datasets' => [[]]];
                    }
                }
                break;

            case 'pekerjaan':
                $data = $tahunId ? PekerjaanStatistik::where('tahun_id', $tahunId)->get() : collect();
                if ($data->isNotEmpty() && isset($data->first()->total_jiwa)) {
                    $chartData = [
                        'labels' => $data->pluck('pekerjaan')->toArray(),
                        'datasets' => [['label' => 'Jumlah Jiwa', 'data' => $data->pluck('total_jiwa')->toArray()]]
                    ];
                } else {
                    // if it's single-row with fields, convert to labels
                    $row = $data->first();
                    if ($row) {
                        $labels = ['Petani','Belum/Tidak Bekerja','Pelajar/Mahasiswa','Ibu Rumah Tangga','Wiraswasta','Karyawan Swasta','Lainnya'];
                        $chartData = [
                            'labels' => $labels,
                            'datasets' => [[
                                'label' => 'Jumlah Jiwa',
                                'data' => [
                                    $row->petani ?? 0,
                                    $row->belum_bekerja ?? 0,
                                    $row->pelajar_mahasiswa ?? 0,
                                    $row->ibu_rumah_tangga ?? 0,
                                    $row->wiraswasta ?? 0,
                                    $row->pegawai_swasta ?? 0,
                                    $row->lainnya ?? 0
                                ]
                            ]]
                        ];
                    } else {
                        $chartData = ['labels' => [], 'datasets' => [[]]];
                    }
                }
                break;

            case 'trend':
                // trend population last 5 years
                $tahunAngka = $tahunRecord ? $tahunRecord->tahun : date('Y');
                $tahunAwal = $tahunAngka - 4;
                $trendData = DemografiPenduduk::whereHas('tahunData', function($q) use ($tahunAwal, $tahunAngka) {
                    $q->whereBetween('tahun', [$tahunAwal, $tahunAngka]);
                })->with('tahunData')->get()->sortBy(function($r) {
                    return $r->tahunData->tahun ?? 0;
                });

                $labels = $trendData->map(function ($r) { return $r->tahunData->tahun ?? null; })->filter()->values()->toArray();
                $values = $trendData->pluck('total_penduduk')->toArray();

                $chartData = [
                    'labels' => $labels,
                    'datasets' => [[
                        'label' => 'Total Jiwa',
                        'data' => $values
                    ]]
                ];
                break;

            default:
                $chartData = ['labels' => [], 'datasets' => []];
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'tahun' => $tahunRecord ? $tahunRecord->tahun : date('Y'),
            'type' => $type
        ]);
    }
}

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

/**
 * Frontend DemografiController - Untuk menampilkan data kependudukan dan statistik desa
 */
class DemografiController extends Controller
{
    /**
     * Helper: Mendapatkan Object Tahun Data (ID & Tahun)
     * Mencegah error jika data tahun kosong/null
     */
    private function getTahunData($tahunInput = null)
    {
        if ($tahunInput) {
            $tahunData = TahunData::where('tahun', $tahunInput)->first();
        } else {
            $tahunData = TahunData::orderBy('tahun', 'desc')->first();
        }

        // Return object dummy jika null agar tidak crash saat akses properti
        return $tahunData ?: new TahunData(['tahun' => date('Y'), 'id_tahun' => 0]);
    }

    /**
     * Helper: Mengubah Struktur Horizontal (Kolom) menjadi Collection (Baris)
     * Berguna untuk chart dan tabel yang butuh looping.
     */
    private function transformHorizontalData($dataRow, $columns, $labelKeyName)
    {
        $result = [];
        // Jika dataRow null (belum ada data tahun ini), return array kosong
        if (!$dataRow) return $result;

        foreach ($columns as $col => $label) {
            // Jika key array adalah angka, berarti $label adalah nama kolomnya
            $colName = is_numeric($col) ? $label : $col;
            // Format label: "tidak_sekolah" -> "Tidak Sekolah"
            $displayLabel = is_numeric($col) ? ucwords(str_replace('_', ' ', $label)) : $label;

            $result[] = (object) [
                $labelKeyName => $displayLabel,
                'total_jiwa' => $dataRow->$colName ?? 0
            ];
        }
        
        // Urutkan dari jumlah terbanyak ke terkecil
        usort($result, function($a, $b) {
            return $b->total_jiwa - $a->total_jiwa;
        });

        return $result;
    }

    /**
     * Halaman Dashboard Demografi Lengkap
     * Route: GET /demografi
     */
    public function index(Request $request)
    {
        $tahunReq = $request->get('tahun');
        $tahunData = $this->getTahunData($tahunReq);
        $tahunId = $tahunData->id_tahun;

        // 1. Data Demografi Utama
        $demografi = DemografiPenduduk::where('tahun_id', $tahunId)->first();

        // 2. Statistik Umur (Khusus: Perlu estimasi L/P karena DB hanya simpan total)
        $umurRow = UmurStatistik::where('tahun_id', $tahunId)->first();
        $umurMapping = [
            'umur_0_4' => '0-4', 'umur_5_9' => '5-9', 'umur_10_14' => '10-14',
            'umur_15_19' => '15-19', 'umur_20_24' => '20-24', 'umur_25_29' => '25-29',
            'umur_30_34' => '30-34', 'umur_35_39' => '35-39', 'umur_40_44' => '40-44',
            'umur_45_49' => '45-49', 'umur_50_plus' => '50+'
        ];
        
        $statistikUmur = [];
        if ($umurRow) {
            foreach ($umurMapping as $col => $label) {
                $val = $umurRow->$col ?? 0;
                $statistikUmur[] = (object)[
                    'kelompok_umur' => $label,
                    'total_jiwa' => $val,
                    'laki_laki' => round($val / 2), // Estimasi bagi 2
                    'perempuan' => $val - round($val / 2)
                ];
            }
        }
        $statistikUmur = collect($statistikUmur);

        // 3. Statistik Agama
        $agamaRow = AgamaStatistik::where('tahun_id', $tahunId)->first();
        $statistikAgama = collect($this->transformHorizontalData($agamaRow, [
            'islam', 'katolik', 'kristen', 'hindu', 'buddha', 'konghucu', 'kepercayaan_lain'
        ], 'agama'));

        // 4. Statistik Pekerjaan
        $pekerjaanRow = PekerjaanStatistik::where('tahun_id', $tahunId)->first();
        $statistikPekerjaan = collect($this->transformHorizontalData($pekerjaanRow, [
            'petani', 'pelajar_mahasiswa', 'pegawai_swasta', 'wiraswasta', 
            'ibu_rumah_tangga', 'belum_bekerja', 'lainnya'
        ], 'pekerjaan'));

        // 5. Statistik Pendidikan
        $pendidikanRow = PendidikanStatistik::where('tahun_id', $tahunId)->first();
        $statistikPendidikan = collect($this->transformHorizontalData($pendidikanRow, [
            'tidak_sekolah', 'sd', 'smp', 'sma', 'd1_d4', 's1', 's2', 's3'
        ], 'tingkat_pendidikan'));

        // 6. Statistik Lainnya (Asumsi tabel ini strukturnya Vertikal/Baris)
        $statistikPerkawinan = PerkawinanStatistik::where('tahun_id', $tahunId)->get();
        $statistikWajibPilih = WajibPilihStatistik::where('tahun_id', $tahunId)->get();

        // Data Pendukung
        $tahunTersedia = TahunData::orderBy('tahun', 'desc')->get();
        
        // Perbandingan dengan tahun lalu
        $tahunSebelumnyaData = TahunData::where('tahun', $tahunData->tahun - 1)->first();
        $demografiSebelumnya = $tahunSebelumnyaData 
            ? DemografiPenduduk::where('tahun_id', $tahunSebelumnyaData->id_tahun)->first() 
            : null;

        return [
            'demografi' => $demografi,
            'demografiSebelumnya' => $demografiSebelumnya,
            'statistikUmur' => $statistikUmur,
            'statistikAgama' => $statistikAgama,
            'statistikPekerjaan' => $statistikPekerjaan,
            'statistikPendidikan' => $statistikPendidikan,
            'statistikPerkawinan' => $statistikPerkawinan,
            'statistikWajibPilih' => $statistikWajibPilih,
            'tahunTersedia' => $tahunTersedia,
            'tahunTerpilih' => $tahunData->tahun
        ];
    }

    /**
     * Data Chart API (JSON Response)
     * Route: GET /api/demografi/chart/{type}
     */
    public function chart($type, Request $request)
    {
        $tahunData = $this->getTahunData($request->get('tahun'));
        $tahunId = $tahunData->id_tahun;
        $chartData = [];

        switch ($type) {
            case 'umur':
                // Logic Chart Umur (Piramida)
                $row = UmurStatistik::where('tahun_id', $tahunId)->first();
                $cols = [
                    'umur_0_4' => '0-4', 'umur_5_9' => '5-9', 'umur_10_14' => '10-14',
                    'umur_15_19' => '15-19', 'umur_20_24' => '20-24', 'umur_25_29' => '25-29',
                    'umur_30_34' => '30-34', 'umur_35_39' => '35-39', 'umur_40_44' => '40-44',
                    'umur_45_49' => '45-49', 'umur_50_plus' => '50+'
                ];
                $labels = []; $dataLaki = []; $dataPerempuan = [];
                
                if ($row) {
                    foreach ($cols as $col => $label) {
                        $labels[] = $label;
                        $val = $row->$col ?? 0;
                        $dataLaki[] = round($val / 2);
                        $dataPerempuan[] = $val - round($val / 2);
                    }
                }
                $chartData = [
                    'labels' => $labels,
                    'datasets' => [
                        ['label' => 'Laki-laki', 'data' => $dataLaki, 'backgroundColor' => 'rgba(56, 161, 105, 0.8)'],
                        ['label' => 'Perempuan', 'data' => $dataPerempuan, 'backgroundColor' => 'rgba(255, 99, 132, 0.8)']
                    ]
                ];
                break;

            case 'agama':
                $row = AgamaStatistik::where('tahun_id', $tahunId)->first();
                $data = collect($this->transformHorizontalData($row, [
                    'islam','katolik','kristen','hindu','buddha','konghucu','kepercayaan_lain'
                ], 'agama'));
                $chartData = [
                    'labels' => $data->pluck('agama')->toArray(),
                    'datasets' => [[
                        'data' => $data->pluck('total_jiwa')->toArray(), 
                        'backgroundColor' => ['#4CAF50', '#2196F3', '#FF9800', '#E91E63', '#9C27B0', '#607D8B', '#795548']
                    ]]
                ];
                break;

            case 'pekerjaan':
                $row = PekerjaanStatistik::where('tahun_id', $tahunId)->first();
                $data = collect($this->transformHorizontalData($row, [
                    'petani','pelajar_mahasiswa','pegawai_swasta','wiraswasta','ibu_rumah_tangga','belum_bekerja','lainnya'
                ], 'pekerjaan'))->take(10);
                $chartData = [
                    'labels' => $data->pluck('pekerjaan')->toArray(),
                    'datasets' => [[
                        'label' => 'Jumlah Jiwa', 
                        'data' => $data->pluck('total_jiwa')->toArray(), 
                        'backgroundColor' => 'rgba(75, 192, 192, 0.8)'
                    ]]
                ];
                break;

            case 'pendidikan':
                $row = PendidikanStatistik::where('tahun_id', $tahunId)->first();
                $data = collect($this->transformHorizontalData($row, [
                    'tidak_sekolah', 'sd', 'smp', 'sma', 'd1_d4', 's1', 's2', 's3'
                ], 'tingkat_pendidikan'));
                $chartData = [
                    'labels' => $data->pluck('tingkat_pendidikan')->toArray(),
                    'datasets' => [[
                        'label' => 'Jumlah Jiwa',
                        'data' => $data->pluck('total_jiwa')->toArray(),
                        'backgroundColor' => '#2563eb',
                        'borderColor' => '#1d4ed8',
                        'borderWidth' => 1
                    ]]
                ];
                break;

            case 'wajib-pilih':
                $data = WajibPilihStatistik::where('tahun_id', $tahunId)->get();
                $chartData = [
                    'labels' => $data->pluck('kategori_wajib_pilih')->toArray(),
                    'datasets' => [[
                        'label' => 'Jumlah',
                        'data' => $data->pluck('total_jiwa')->toArray(),
                        'backgroundColor' => ["#dc2626", "#e5e7eb"],
                        'borderRadius' => 6,
                        'barThickness' => 50
                    ]]
                ];
                break;

            case 'trend':
                $tahunAwal = $tahunData->tahun - 4;
                $rangeIds = TahunData::whereBetween('tahun', [$tahunAwal, $tahunData->tahun])->pluck('id_tahun');
                
                $trendData = DemografiPenduduk::whereIn('tahun_id', $rangeIds)
                    ->with('tahunData')
                    ->get()
                    ->sortBy(fn($item) => $item->tahunData->tahun ?? 0);

                $chartData = [
                    'labels' => $trendData->pluck('tahunData.tahun')->toArray(),
                    'datasets' => [[
                        'label' => 'Total Jiwa',
                        'data' => $trendData->pluck('total_penduduk')->toArray(),
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'fill' => true
                    ]]
                ];
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $chartData,
            'tahun' => $tahunData->tahun,
            'type' => $type
        ]);
    }

    /**
     * Endpoint khusus untuk data section (API/Partial)
     */
    public function umum(Request $request) {
        $data = $this->index($request);
        return ['demografi' => $data['demografi'], 'tahun' => $data['tahunTerpilih']];
    }

    public function umur(Request $request) {
        $data = $this->index($request);
        return [
            'statistikUmur' => $data['statistikUmur'],
            'totalJiwa' => $data['statistikUmur']->sum('total_jiwa'),
            'tahun' => $data['tahunTerpilih']
        ];
    }

    public function agama(Request $request) {
        $data = $this->index($request);
        return [
            'statistikAgama' => $data['statistikAgama'],
            'totalJiwa' => $data['statistikAgama']->sum('total_jiwa'),
            'tahun' => $data['tahunTerpilih']
        ];
    }

    public function pekerjaan(Request $request) {
        $data = $this->index($request);
        return [
            'statistikPekerjaan' => $data['statistikPekerjaan'],
            'totalJiwa' => $data['statistikPekerjaan']->sum('total_jiwa'),
            'tahun' => $data['tahunTerpilih']
        ];
    }

    public function pendidikan(Request $request) {
        $data = $this->index($request);
        return [
            'statistikPendidikan' => $data['statistikPendidikan'],
            'totalJiwa' => $data['statistikPendidikan']->sum('total_jiwa'),
            'tahun' => $data['tahunTerpilih']
        ];
    }

    public function perbandingan(Request $request) {
        $tahun1Data = $this->getTahunData($request->get('tahun1', date('Y') - 1));
        $tahun2Data = $this->getTahunData($request->get('tahun2', date('Y')));

        $demografi1 = DemografiPenduduk::where('tahun_id', $tahun1Data->id_tahun)->first();
        $demografi2 = DemografiPenduduk::where('tahun_id', $tahun2Data->id_tahun)->first();

        $perbandingan = [];
        if ($demografi1 && $demografi2) {
            $perbandingan = [
                'total_jiwa' => [
                    'tahun1' => $demografi1->total_penduduk,
                    'tahun2' => $demografi2->total_penduduk,
                    'selisih' => $demografi2->total_penduduk - $demografi1->total_penduduk,
                    'persentase' => $demografi1->total_penduduk > 0 ? 
                        round((($demografi2->total_penduduk - $demografi1->total_penduduk) / $demografi1->total_penduduk) * 100, 2) : 0
                ],
            ];
        }
        
        return [
            'demografi1' => $demografi1,
            'demografi2' => $demografi2,
            'perbandingan' => $perbandingan,
            'tahun1' => $tahun1Data->tahun,
            'tahun2' => $tahun2Data->tahun,
            'tahunTersedia' => TahunData::orderBy('tahun', 'desc')->get()
        ];
    }

    public function widget() {
        $data = $this->index(request());
        
        $ringkasan = [];
        if ($data['demografi']) {
            $ringkasan = [
                'total_jiwa' => $data['demografi']->total_penduduk,
                'laki_laki' => $data['demografi']->laki_laki,
                'perempuan' => $data['demografi']->perempuan,
                'tahun' => $data['tahunTerpilih']
            ];
        }

        return [
            'ringkasan' => $ringkasan,
            'topAgama' => $data['statistikAgama']->take(3),
            'topPekerjaan' => $data['statistikPekerjaan']->take(3),
            'tahun' => $data['tahunTerpilih']
        ];
    }

    public function infografis()
    {
        return app(\App\Http\Controllers\Frontend\Infografis\InfografisController::class)->index(request());
    }
}
<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PekerjaanController - Handle data pekerjaan
 * 
 * Responsibilities:
 * - Data statistik jenis pekerjaan
 * - Tabel dan grid cards pekerjaan
 * - Analisis sebaran mata pencaharian
 */
class PekerjaanController extends Controller
{
    /**
     * Get data pekerjaan
     * 
     * @param string|null $tahun
     * @return array
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // Coba ambil data dari database
        $statistikPekerjaan = PekerjaanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->orderBy('total_jiwa', 'desc')->get();

        if ($statistikPekerjaan->isEmpty()) {
            // Data dummy jika tidak ada data real
            return $this->getDummyData();
        }

        // Transform database data
        return $this->transformDatabaseData($statistikPekerjaan);
    }

    /**
     * Data dummy untuk testing
     */
    private function getDummyData()
    {
        return [
            'pekerjaan' => (object)[
                'petani' => 1250,
                'belum_bekerja' => 890,
                'pelajar_mahasiswa' => 680,
                'ibu_rumah_tangga' => 750,
                'wiraswasta' => 420,
                'pegawai_swasta' => 380,
                'lainnya' => 150
            ]
        ];
    }

    /**
     * Transform database data ke format view
     */
    private function transformDatabaseData($statistikPekerjaan)
    {
        $mapping = [
            'Petani/Pekebun' => 'petani',
            'Belum/Tidak Bekerja' => 'belum_bekerja',
            'Pelajar/Mahasiswa' => 'pelajar_mahasiswa',
            'Mengurus Rumah Tangga' => 'ibu_rumah_tangga',
            'Wiraswasta' => 'wiraswasta',
            'Karyawan Swasta' => 'pegawai_swasta',
            'Buruh Tani/Perkebunan' => 'lainnya'
        ];

        $data = [];
        foreach ($statistikPekerjaan as $stat) {
            $key = $mapping[$stat->jenis_pekerjaan] ?? strtolower(str_replace([' ', '/'], '_', $stat->jenis_pekerjaan));
            $data[$key] = $stat->total_jiwa;
        }

        return [
            'pekerjaan' => (object)$data
        ];
    }

    /**
     * API endpoint untuk data pekerjaan
     * Route: GET /api/infografis/pekerjaan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $data = $this->getData($tahun);

        return response()->json($data);
    }

    /**
     * Get data untuk tabel pekerjaan
     */
    public function getTabelData($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = $data['pekerjaan'];

        return [
            ['jenis' => 'Petani/Pekebun', 'jumlah' => $pekerjaanData->petani ?? 0],
            ['jenis' => 'Belum/Tidak Bekerja', 'jumlah' => $pekerjaanData->belum_bekerja ?? 0],
            ['jenis' => 'Pelajar/Mahasiswa', 'jumlah' => $pekerjaanData->pelajar_mahasiswa ?? 0],
            ['jenis' => 'Mengurus Rumah Tangga', 'jumlah' => $pekerjaanData->ibu_rumah_tangga ?? 0],
            ['jenis' => 'Wiraswasta', 'jumlah' => $pekerjaanData->wiraswasta ?? 0],
            ['jenis' => 'Karyawan Swasta', 'jumlah' => $pekerjaanData->pegawai_swasta ?? 0],
            ['jenis' => 'Buruh Tani/Perkebunan', 'jumlah' => $pekerjaanData->lainnya ?? 0],
        ];
    }

    /**
     * Get analisis pekerjaan
     */
    public function getAnalisis($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = (array)$data['pekerjaan'];

        $total = array_sum($pekerjaanData);
        $sektor_primer = ($pekerjaanData['petani'] ?? 0) + ($pekerjaanData['lainnya'] ?? 0);
        $sektor_tersier = ($pekerjaanData['wiraswasta'] ?? 0) + ($pekerjaanData['pegawai_swasta'] ?? 0);
        $tidak_bekerja = ($pekerjaanData['belum_bekerja'] ?? 0) +
            ($pekerjaanData['pelajar_mahasiswa'] ?? 0) +
            ($pekerjaanData['ibu_rumah_tangga'] ?? 0);

        return [
            'total_angkatan_kerja' => $total,
            'sektor_primer' => $sektor_primer,
            'sektor_tersier' => $sektor_tersier,
            'tidak_bekerja' => $tidak_bekerja,
            'persentase_petani' => $total > 0 ? round((($pekerjaanData['petani'] ?? 0) / $total) * 100, 2) : 0,
            'pekerjaan_terbanyak' => array_keys($pekerjaanData, max($pekerjaanData))[0] ?? 'petani',
            'jumlah_terbanyak' => max($pekerjaanData),
            'tingkat_pengangguran' => $total > 0 ? round((($pekerjaanData['belum_bekerja'] ?? 0) / $total) * 100, 2) : 0
        ];
    }

    /**
     * Get ranking pekerjaan
     */
    public function getRanking($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = (array)$data['pekerjaan'];

        arsort($pekerjaanData);

        $ranking = [];
        $no = 1;
        foreach ($pekerjaanData as $jenis => $jumlah) {
            $ranking[] = [
                'ranking' => $no++,
                'jenis' => $jenis,
                'jumlah' => $jumlah,
                'persentase' => array_sum($pekerjaanData) > 0 ?
                    round(($jumlah / array_sum($pekerjaanData)) * 100, 2) : 0
            ];
        }

        return $ranking;
    }

    /**
     * Get data untuk chart pie/donut pekerjaan
     */
    public function getChartData($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = (array)$data['pekerjaan'];

        return [
            'labels' => [
                'Petani/Pekebun',
                'Belum/Tidak Bekerja',
                'Pelajar/Mahasiswa',
                'Mengurus Rumah Tangga',
                'Wiraswasta',
                'Karyawan Swasta',
                'Buruh Tani/Perkebunan'
            ],
            'datasets' => [
                [
                    'data' => array_values($pekerjaanData),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FF6384'
                    ]
                ]
            ]
        ];
    }
}

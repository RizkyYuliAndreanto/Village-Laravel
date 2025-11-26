<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Models\PekerjaanStatistik;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * PekerjaanController - Handle data pekerjaan
 * * Responsibilities:
 * - Data statistik jenis pekerjaan
 * - Tabel dan grid cards pekerjaan
 * - Analisis sebaran mata pencaharian
 */
class PekerjaanController extends Controller
{
    /**
     * Get data pekerjaan
     * * @param string|null $tahun
     * @return array
     */
    public function getData($tahun = null)
    {
        if (!$tahun) {
            $tahunTerbaru = TahunData::orderBy('tahun', 'desc')->first();
            $tahun = $tahunTerbaru ? $tahunTerbaru->tahun : date('Y');
        }

        // PERBAIKAN: Ambil satu baris data (first) karena struktur horizontal
        // Hapus orderBy karena tidak ada kolom total_jiwa di tabel ini
        $data = PekerjaanStatistik::whereHas('tahunData', function ($query) use ($tahun) {
            $query->where('tahun', $tahun);
        })->first();

        // Map kolom database ke object
        return [
            'pekerjaan' => (object)[
                'petani' => $data->petani ?? 0,
                'belum_bekerja' => $data->belum_bekerja ?? 0,
                'pelajar_mahasiswa' => $data->pelajar_mahasiswa ?? 0,
                'ibu_rumah_tangga' => $data->ibu_rumah_tangga ?? 0,
                'wiraswasta' => $data->wiraswasta ?? 0,
                'pegawai_swasta' => $data->pegawai_swasta ?? 0,
                'lainnya' => $data->lainnya ?? 0,
            ]
        ];
    }

    /**
     * API endpoint untuk data pekerjaan
     * Route: GET /api/infografis/pekerjaan
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        return response()->json($this->getData($tahun));
    }

    /**
     * Get data untuk tabel pekerjaan
     */
    public function getTabelData($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = $data['pekerjaan'];

        return [
            ['jenis' => 'Petani/Pekebun', 'jumlah' => $pekerjaanData->petani],
            ['jenis' => 'Belum/Tidak Bekerja', 'jumlah' => $pekerjaanData->belum_bekerja],
            ['jenis' => 'Pelajar/Mahasiswa', 'jumlah' => $pekerjaanData->pelajar_mahasiswa],
            ['jenis' => 'Mengurus Rumah Tangga', 'jumlah' => $pekerjaanData->ibu_rumah_tangga],
            ['jenis' => 'Wiraswasta', 'jumlah' => $pekerjaanData->wiraswasta],
            ['jenis' => 'Karyawan Swasta', 'jumlah' => $pekerjaanData->pegawai_swasta],
            ['jenis' => 'Buruh Tani/Perkebunan', 'jumlah' => $pekerjaanData->lainnya],
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
        
        if ($total == 0) {
            return [
                'total_angkatan_kerja' => 0,
                'sektor_primer' => 0,
                'sektor_tersier' => 0,
                'tidak_bekerja' => 0,
                'persentase_petani' => 0,
                'pekerjaan_terbanyak' => '-',
                'jumlah_terbanyak' => 0,
                'tingkat_pengangguran' => 0
            ];
        }

        $sektor_primer = ($pekerjaanData['petani'] ?? 0) + ($pekerjaanData['lainnya'] ?? 0);
        $sektor_tersier = ($pekerjaanData['wiraswasta'] ?? 0) + ($pekerjaanData['pegawai_swasta'] ?? 0);
        $tidak_bekerja = ($pekerjaanData['belum_bekerja'] ?? 0) +
            ($pekerjaanData['pelajar_mahasiswa'] ?? 0) +
            ($pekerjaanData['ibu_rumah_tangga'] ?? 0);

        // Cari yang terbanyak
        $terbanyakKey = array_keys($pekerjaanData, max($pekerjaanData))[0] ?? '-';
        
        $labelMapping = [
            'petani' => 'Petani', 
            'belum_bekerja' => 'Belum Bekerja', 
            'pelajar_mahasiswa' => 'Pelajar', 
            'ibu_rumah_tangga' => 'IRT',
            'wiraswasta' => 'Wiraswasta', 
            'pegawai_swasta' => 'Karyawan Swasta', 
            'lainnya' => 'Buruh Tani'
        ];

        return [
            'total_angkatan_kerja' => $total,
            'sektor_primer' => $sektor_primer,
            'sektor_tersier' => $sektor_tersier,
            'tidak_bekerja' => $tidak_bekerja,
            'persentase_petani' => round((($pekerjaanData['petani'] ?? 0) / $total) * 100, 2),
            'pekerjaan_terbanyak' => $labelMapping[$terbanyakKey] ?? ucfirst($terbanyakKey),
            'jumlah_terbanyak' => max($pekerjaanData),
            'tingkat_pengangguran' => round((($pekerjaanData['belum_bekerja'] ?? 0) / $total) * 100, 2)
        ];
    }

    /**
     * Get ranking pekerjaan
     */
    public function getRanking($tahun = null)
    {
        $data = $this->getData($tahun);
        $pekerjaanData = (array)$data['pekerjaan'];

        // Sorting di PHP
        arsort($pekerjaanData);

        $ranking = [];
        $no = 1;
        
        $labelMapping = [
            'petani' => 'Petani/Pekebun', 
            'belum_bekerja' => 'Belum/Tidak Bekerja', 
            'pelajar_mahasiswa' => 'Pelajar/Mahasiswa', 
            'ibu_rumah_tangga' => 'Mengurus Rumah Tangga',
            'wiraswasta' => 'Wiraswasta', 
            'pegawai_swasta' => 'Karyawan Swasta', 
            'lainnya' => 'Buruh Tani/Perkebunan'
        ];

        foreach ($pekerjaanData as $jenis => $jumlah) {
            $ranking[] = [
                'ranking' => $no++,
                'jenis' => $labelMapping[$jenis] ?? ucfirst($jenis),
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
        $pekerjaanData = $data['pekerjaan'];

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
                    'data' => [
                        $pekerjaanData->petani ?? 0,
                        $pekerjaanData->belum_bekerja ?? 0,
                        $pekerjaanData->pelajar_mahasiswa ?? 0,
                        $pekerjaanData->ibu_rumah_tangga ?? 0,
                        $pekerjaanData->wiraswasta ?? 0,
                        $pekerjaanData->pegawai_swasta ?? 0,
                        $pekerjaanData->lainnya ?? 0
                    ],
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
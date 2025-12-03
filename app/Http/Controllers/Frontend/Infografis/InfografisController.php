<?php

namespace App\Http\Controllers\Frontend\Infografis;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Infografis\StatistikController;
use App\Http\Controllers\Frontend\Infografis\UmurController;
use App\Http\Controllers\Frontend\Infografis\PendidikanController;
use App\Http\Controllers\Frontend\Infografis\PekerjaanController;
use App\Http\Controllers\Frontend\Infografis\AgamaController;
use App\Http\Controllers\Frontend\Infografis\PerkawinanController;
use App\Models\TahunData;
use Illuminate\Http\Request;

/**
 * InfografisController - Controller utama untuk halaman infografis
 * 
 * Responsibilities:
 * - Koordinasi semua controller section
 * - Render halaman infografis utama
 * - API endpoints untuk data lengkap
 * - Management tahun data
 */
class InfografisController extends Controller
{
    protected $statistikController;
    protected $umurController;
    protected $pendidikanController;
    protected $pekerjaanController;
    protected $agamaController;
    protected $perkawinanController;

    public function __construct()
    {
        $this->statistikController = new StatistikController();
        $this->umurController = new UmurController();
        $this->pendidikanController = new PendidikanController();
        $this->pekerjaanController = new PekerjaanController();
        $this->agamaController = new AgamaController();
        $this->perkawinanController = new PerkawinanController();
    }

    /**
     * Halaman infografis utama
     * Route: GET /infografis
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun');

        // Ambil tahun data terbaru jika tidak ada parameter
        $tahunDataTerbaru = $this->getTahunTerbaru();
        $tahunAktif = $tahun ?: $tahunDataTerbaru->tahun;
        $tahunTersedia = $this->getTahunTersedia();

        // Kumpulkan data dari semua controller section
        $data = $this->getAllData($tahunAktif);

        // Tambahkan informasi tahun untuk setiap view
        $data['tahunDataTerbaru'] = $tahunDataTerbaru;
        $data['tahunAktif'] = $tahunAktif;
        $data['tahunTersedia'] = $tahunTersedia;

        // Pastikan tahun data tersedia untuk semua sections
        $data = $this->addTahunDataToAll($data, $tahunAktif, $tahunTersedia);

        return view('frontend.infografis.index', $data);
    }

    /**
     * Tambahkan tahun data ke semua sections
     */
    private function addTahunDataToAll($data, $tahunAktif, $tahunTersedia)
    {
        // Data sudah memiliki tahun informasi, hanya pastikan konsistensi
        return $data;
    }

    /**
     * API endpoint untuk semua data infografis
     * Route: GET /api/infografis
     */
    public function apiData(Request $request)
    {
        $tahun = $request->get('tahun');
        $tahunDataTerbaru = $this->getTahunTerbaru();
        $tahunAktif = $tahun ?: $tahunDataTerbaru->tahun;

        $data = $this->getAllData($tahunAktif);
        $data['tahun_aktif'] = $tahunAktif;
        $data['tahun_tersedia'] = $this->getTahunTersedia();

        return response()->json($data);
    }

    /**
     * Kumpulkan semua data dari controller section
     */
    private function getAllData($tahun = null)
    {
        return array_merge(
            $this->statistikController->getData($tahun),
            $this->umurController->getData($tahun),
            $this->pendidikanController->getData($tahun),
            $this->pekerjaanController->getData($tahun),
            $this->agamaController->getData($tahun),
            $this->perkawinanController->getData($tahun),
            $this->perkawinanController->getWajibPilihData($tahun)
        );
    }

    /**
     * Get tahun data terbaru
     */
    private function getTahunTerbaru()
    {
        $tahunDataTerbaru = TahunData::orderBy('tahun', 'desc')->first();

        if (!$tahunDataTerbaru) {
            return (object)['tahun' => date('Y')];
        }

        return $tahunDataTerbaru;
    }

    /**
     * Get semua tahun yang tersedia
     */
    private function getTahunTersedia()
    {
        return TahunData::orderBy('tahun', 'desc')->pluck('tahun', 'tahun')->toArray();
    }

    /**
     * API untuk data section tertentu
     * Route: GET /api/infografis/{section}
     */
    public function getSectionData(Request $request, $section)
    {
        $tahun = $request->get('tahun');

        switch ($section) {
            case 'statistik':
                return $this->statistikController->apiData($request);
            case 'umur':
                return $this->umurController->apiData($request);
            case 'pendidikan':
                return $this->pendidikanController->apiData($request);
            case 'pekerjaan':
                return $this->pekerjaanController->apiData($request);
            case 'agama':
                return $this->agamaController->apiData($request);
            case 'perkawinan':
                return $this->perkawinanController->apiData($request);
            case 'wajib-pilih':
                return $this->perkawinanController->apiWajibPilih($request);
            default:
                return response()->json(['error' => 'Section not found'], 404);
        }
    }

    /**
     * API untuk chart data section tertentu
     * Route: GET /api/infografis/{section}/chart
     */
    public function getChartData(Request $request, $section)
    {
        $tahun = $request->get('tahun');

        switch ($section) {
            case 'umur':
                return response()->json($this->umurController->getChartData($tahun));
            case 'pendidikan':
                return response()->json($this->pendidikanController->getChartData($tahun));
            case 'pekerjaan':
                return response()->json($this->pekerjaanController->getChartData($tahun));
            case 'agama':
                return response()->json($this->agamaController->getChartData($tahun));
            case 'perkawinan':
                return response()->json($this->perkawinanController->getChartData($tahun));
            case 'wajib-pilih':
                return response()->json($this->perkawinanController->getWajibPilihChartData($tahun));
            default:
                return response()->json(['error' => 'Chart not found'], 404);
        }
    }

    /**
     * API untuk analisis section tertentu  
     * Route: GET /api/infografis/{section}/analisis
     */
    public function getAnalisis(Request $request, $section)
    {
        $tahun = $request->get('tahun');

        switch ($section) {
            case 'statistik':
                return response()->json($this->statistikController->getPerbandingan($tahun));
            case 'umur':
                return response()->json($this->umurController->getInsights($tahun));
            case 'pendidikan':
                return response()->json($this->pendidikanController->getAnalisis($tahun));
            case 'pekerjaan':
                return response()->json($this->pekerjaanController->getAnalisis($tahun));
            case 'agama':
                return response()->json($this->agamaController->getAnalisis($tahun));
            case 'perkawinan':
                return response()->json($this->perkawinanController->getAnalisis($tahun));
            default:
                return response()->json(['error' => 'Analysis not found'], 404);
        }
    }

    /**
     * Refresh data - untuk rebuild cache jika ada
     * Route: POST /api/infografis/refresh
     */
    public function refresh(Request $request)
    {
        // Bisa ditambahkan logic untuk refresh cache
        // atau sinkronisasi data jika diperlukan

        return response()->json([
            'message' => 'Data refreshed successfully',
            'timestamp' => now()
        ]);
    }

    /**
     * Export data infografis
     * Route: GET /infografis/export
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'json'); // json, csv, excel
        $tahun = $request->get('tahun');
        $tahunAktif = $tahun ?: $this->getTahunTerbaru()->tahun;

        $data = $this->getAllData($tahunAktif);
        $data['metadata'] = [
            'tahun' => $tahunAktif,
            'exported_at' => now(),
            'format' => $format
        ];

        switch ($format) {
            case 'json':
                return response()->json($data);
            case 'csv':
                // Implementasi CSV export
                return $this->exportToCsv($data);
            case 'excel':
                // Implementasi Excel export  
                return $this->exportToExcel($data);
            default:
                return response()->json($data);
        }
    }

    /**
     * Export ke CSV (implementasi basic)
     */
    private function exportToCsv($data)
    {
        // Basic CSV export implementation
        $filename = 'infografis_' . ($data['tahun'] ?? date('Y')) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        return response()->stream(function () use ($data) {
            $handle = fopen('php://output', 'w');

            // CSV headers dan data
            fputcsv($handle, ['Section', 'Item', 'Value']);

            // Flatten data untuk CSV
            foreach ($data as $section => $values) {
                if (is_object($values) || is_array($values)) {
                    foreach ((array)$values as $key => $value) {
                        if (!is_array($value) && !is_object($value)) {
                            fputcsv($handle, [$section, $key, $value]);
                        }
                    }
                } else {
                    fputcsv($handle, [$section, '', $values]);
                }
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Export ke Excel (placeholder)
     */
    private function exportToExcel($data)
    {
        // Bisa diimplementasi dengan library seperti PhpSpreadsheet
        return response()->json([
            'message' => 'Excel export not yet implemented',
            'data' => $data
        ]);
    }
}

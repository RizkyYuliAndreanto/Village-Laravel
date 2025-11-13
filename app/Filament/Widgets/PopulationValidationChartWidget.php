<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\TahunData;
use App\Models\DemografiPenduduk;
use App\Services\PopulationValidationService;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;

class PopulationValidationChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Validasi Populasi per Tahun';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = null;

    protected function getData(): array
    {
        $validationService = new PopulationValidationService();

        // Get all years with demographic data
        $years = TahunData::whereHas('demografiPenduduk')
            ->orderBy('tahun')
            ->get();

        $labels = [];
        $populationData = [];
        $umurData = [];
        $pekerjaanData = [];
        $pendidikanData = [];
        $agamaData = [];
        $perkawinanData = [];
        $wajibPilihData = [];

        foreach ($years as $year) {
            $labels[] = $year->tahun;

            // Get total population - use correct primary key
            if ($year->id_tahun) {
                $totalPopulation = $validationService->getTotalPopulation($year->id_tahun);
                $populationData[] = $totalPopulation ?? 0;
            } else {
                $populationData[] = 0;
            }

            // Get validation results for each statistic type
            $statisticTypes = [
                'umur' => &$umurData,
                'pekerjaan' => &$pekerjaanData,
                'pendidikan' => &$pendidikanData,
                'agama' => &$agamaData,
                'perkawinan' => &$perkawinanData,
                'wajib_pilih' => &$wajibPilihData,
            ];

            foreach ($statisticTypes as $type => &$dataArray) {
                if ($year->id_tahun) {
                    $result = $validationService->getExistingDataValidation($year->id_tahun, $type);
                    $dataArray[] = $result['totalCount'];
                } else {
                    $dataArray[] = 0;
                }
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Populasi',
                    'data' => $populationData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Umur',
                    'data' => $umurData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.5)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pekerjaan',
                    'data' => $pekerjaanData,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.5)',
                    'borderColor' => 'rgb(245, 158, 11)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pendidikan',
                    'data' => $pendidikanData,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.5)',
                    'borderColor' => 'rgb(239, 68, 68)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Agama',
                    'data' => $agamaData,
                    'backgroundColor' => 'rgba(168, 85, 247, 0.5)',
                    'borderColor' => 'rgb(168, 85, 247)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Perkawinan',
                    'data' => $perkawinanData,
                    'backgroundColor' => 'rgba(236, 72, 153, 0.5)',
                    'borderColor' => 'rgb(236, 72, 153)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Wajib Pilih',
                    'data' => $wajibPilihData,
                    'backgroundColor' => 'rgba(14, 165, 233, 0.5)',
                    'borderColor' => 'rgb(14, 165, 233)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'all' => 'Semua Tahun',
            'latest_5' => '5 Tahun Terakhir',
            'latest_3' => '3 Tahun Terakhir',
            'latest_1' => 'Tahun Terbaru',
        ];
    }
}

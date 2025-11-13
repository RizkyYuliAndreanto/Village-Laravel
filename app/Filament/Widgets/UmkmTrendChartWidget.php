<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Umkm;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UmkmTrendChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Trend Pendaftaran UMKM';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public ?string $filter = '12_months';

    protected function getData(): array
    {
        $period = $this->filter;

        switch ($period) {
            case '6_months':
                return $this->get6MonthsData();
            case '12_months':
                return $this->get12MonthsData();
            case '24_months':
                return $this->get24MonthsData();
            case 'yearly':
                return $this->getYearlyData();
            default:
                return $this->get12MonthsData();
        }
    }

    private function get6MonthsData(): array
    {
        $months = collect(range(0, 5))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        })->reverse();

        $labels = [];
        $registrations = [];
        $activeData = [];

        foreach ($months as $month) {
            $labels[] = $month->format('M Y');

            // UMKM yang terdaftar pada bulan tersebut
            $monthlyRegistrations = Umkm::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $registrations[] = $monthlyRegistrations;

            // UMKM aktif pada bulan tersebut
            $activeCount = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)
                ->whereYear('created_at', '<=', $month->year)
                ->where(function ($query) use ($month) {
                    $query->whereYear('created_at', '<', $month->year)
                        ->orWhere(function ($q) use ($month) {
                            $q->whereYear('created_at', $month->year)
                                ->whereMonth('created_at', '<=', $month->month);
                        });
                })
                ->count();
            $activeData[] = $activeCount;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendaftaran Baru',
                    'data' => $registrations,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Kumulatif Aktif',
                    'data' => $activeData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function get12MonthsData(): array
    {
        $months = collect(range(0, 11))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        })->reverse();

        return $this->processMonthlyData($months);
    }

    private function get24MonthsData(): array
    {
        $months = collect(range(0, 23))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        })->reverse();

        return $this->processMonthlyData($months);
    }

    private function getYearlyData(): array
    {
        $years = Umkm::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('year');

        $labels = [];
        $registrations = [];
        $totalOmset = [];

        foreach ($years as $year) {
            $labels[] = (string) $year;

            $yearlyRegistrations = Umkm::whereYear('created_at', $year)->count();
            $registrations[] = $yearlyRegistrations;

            $yearlyOmset = Umkm::whereYear('created_at', $year)
                ->where('status_usaha', Umkm::STATUS_AKTIF)
                ->sum('omset_per_bulan');
            $totalOmset[] = $yearlyOmset / 1000000; // Convert to millions
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendaftaran per Tahun',
                    'data' => $registrations,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Total Omset (Juta Rp)',
                    'data' => $totalOmset,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    private function processMonthlyData($months): array
    {
        $labels = [];
        $registrations = [];
        $activeData = [];
        $omsetData = [];

        foreach ($months as $month) {
            $labels[] = $month->format('M Y');

            // Pendaftaran baru
            $monthlyRegistrations = Umkm::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $registrations[] = $monthlyRegistrations;

            // Kumulatif aktif
            $activeCount = Umkm::where('status_usaha', Umkm::STATUS_AKTIF)
                ->where('created_at', '<=', $month->endOfMonth())
                ->count();
            $activeData[] = $activeCount;

            // Total omset bulan itu
            $monthlyOmset = Umkm::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status_usaha', Umkm::STATUS_AKTIF)
                ->sum('omset_per_bulan');
            $omsetData[] = $monthlyOmset / 1000000; // Convert to millions
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendaftaran Baru',
                    'data' => $registrations,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Kumulatif Aktif',
                    'data' => $activeData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Omset Baru (Juta Rp)',
                    'data' => $omsetData,
                    'borderColor' => '#F59E0B',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
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
                    'position' => 'left',
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'beginAtZero' => true,
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                ],
            ],
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            '6_months' => '6 Bulan Terakhir',
            '12_months' => '12 Bulan Terakhir',
            '24_months' => '24 Bulan Terakhir',
            'yearly' => 'Trend Tahunan',
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\TahunData;
use App\Models\DemografiPenduduk;
use App\Models\UmurStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\AgamaStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;

class QuickStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        // Total years with data
        $totalYears = TahunData::whereHas('demografiPenduduk')->count();

        // Total population (latest year)
        $latestYear = DemografiPenduduk::latest('tahun_id')->first();
        $latestPopulation = $latestYear ? ($latestYear->laki_laki + $latestYear->perempuan) : 0;

        // Count completed statistics
        $statisticsCount = [
            'umur' => UmurStatistik::count(),
            'pekerjaan' => PekerjaanStatistik::count(),
            'pendidikan' => PendidikanStatistik::count(),
            'agama' => AgamaStatistik::count(),
            'perkawinan' => PerkawinanStatistik::count(),
            'wajib_pilih' => WajibPilihStatistik::count(),
        ];

        $totalStatistics = array_sum($statisticsCount);
        $maxPossibleStats = $totalYears * 6; // 6 types of statistics
        $completionRate = $maxPossibleStats > 0 ? ($totalStatistics / $maxPossibleStats) * 100 : 0;

        // Most complete statistic type
        $mostCompleteType = array_keys($statisticsCount, max($statisticsCount))[0] ?? 'Belum ada';
        $mostCompleteCount = max($statisticsCount);

        return [
            Stat::make('Total Tahun Data', $totalYears)
                ->description('Tahun dengan data demografi')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Populasi Terbaru', number_format($latestPopulation))
                ->description($latestYear ? 'Tahun ' . TahunData::find($latestYear->tahun_id)?->tahun : 'Belum ada data')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Data Statistik', $totalStatistics . ' / ' . $maxPossibleStats)
                ->description('Tingkat kelengkapan: ' . number_format($completionRate, 1) . '%')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color($completionRate >= 80 ? 'success' : ($completionRate >= 50 ? 'warning' : 'danger')),

            Stat::make('Terlengkap', ucfirst(str_replace('_', ' ', $mostCompleteType)))
                ->description($mostCompleteCount . ' data tersedia')
                ->descriptionIcon('heroicon-m-trophy')
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}

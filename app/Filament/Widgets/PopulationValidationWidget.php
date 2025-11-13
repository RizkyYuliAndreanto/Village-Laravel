<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\DemografiPenduduk;
use App\Models\UmurStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\AgamaStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Services\PopulationValidationService;
use Illuminate\Support\Facades\DB;

class PopulationValidationWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $validationService = new PopulationValidationService();

        // Get current year or latest year with data
        $currentYear = now()->year;
        $latestYear = DemografiPenduduk::max('tahun_id') ?? $currentYear;

        // Get total population for latest year
        $totalPopulation = $validationService->getTotalPopulation($latestYear);

        // Statistics validation status
        $stats = [];

        // Population Overview
        $stats[] = Stat::make('Total Populasi ' . $latestYear, number_format($totalPopulation))
            ->description('Data dari DemografiPenduduk')
            ->descriptionIcon('heroicon-m-users')
            ->color('primary');

        // Validation status for each statistic type
        $statisticTypes = [
            'umur' => ['model' => UmurStatistik::class, 'name' => 'Umur'],
            'pekerjaan' => ['model' => PekerjaanStatistik::class, 'name' => 'Pekerjaan'],
            'pendidikan' => ['model' => PendidikanStatistik::class, 'name' => 'Pendidikan'],
            'agama' => ['model' => AgamaStatistik::class, 'name' => 'Agama'],
            'perkawinan' => ['model' => PerkawinanStatistik::class, 'name' => 'Perkawinan'],
            'wajib_pilih' => ['model' => WajibPilihStatistik::class, 'name' => 'Wajib Pilih'],
        ];

        foreach ($statisticTypes as $type => $config) {
            $validationResult = $validationService->getExistingDataValidation($latestYear, $type);

            $isValid = $validationResult['isValid'];
            $totalCount = $validationResult['totalCount'];
            $difference = $validationResult['difference'];

            $color = $isValid ? 'success' : 'danger';
            $icon = $isValid ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

            $description = $isValid
                ? 'Data konsisten dengan populasi'
                : 'Selisih: ' . number_format(abs($difference));

            $stats[] = Stat::make($config['name'], number_format($totalCount))
                ->description($description)
                ->descriptionIcon($icon)
                ->color($color);
        }

        // Years with data
        $yearsWithData = DemografiPenduduk::distinct('tahun_id')
            ->orderBy('tahun_id', 'desc')
            ->pluck('tahun_id')
            ->count();

        $stats[] = Stat::make('Tahun Data', $yearsWithData)
            ->description('Tahun dengan data demografi')
            ->descriptionIcon('heroicon-m-calendar')
            ->color('info');

        // Overall validation status
        $allValid = true;
        $totalInconsistencies = 0;

        foreach ($statisticTypes as $type => $config) {
            $result = $validationService->getExistingDataValidation($latestYear, $type);
            if (!$result['isValid']) {
                $allValid = false;
                $totalInconsistencies++;
            }
        }

        $overallColor = $allValid ? 'success' : ($totalInconsistencies > 3 ? 'danger' : 'warning');
        $overallIcon = $allValid ? 'heroicon-m-shield-check' : 'heroicon-m-shield-exclamation';
        $overallDescription = $allValid
            ? 'Semua statistik konsisten'
            : $totalInconsistencies . ' statistik tidak konsisten';

        $stats[] = Stat::make('Status Validasi', $allValid ? 'Valid' : 'Ada Masalah')
            ->description($overallDescription)
            ->descriptionIcon($overallIcon)
            ->color($overallColor);

        return $stats;
    }

    protected function getColumns(): int
    {
        return 4; // Display in 4 columns
    }
}

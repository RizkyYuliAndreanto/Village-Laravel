<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\DemografiPenduduk;
use App\Models\TahunData;
use App\Models\UmurStatistik;
use App\Models\PekerjaanStatistik;
use App\Models\PendidikanStatistik;
use App\Models\AgamaStatistik;
use App\Models\PerkawinanStatistik;
use App\Models\WajibPilihStatistik;
use App\Services\PopulationValidationService;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PopulationValidationByYearWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?string $pollingInterval = null;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $validationService = new PopulationValidationService();

        // Get selected year from filters or use latest year
        $selectedYear = $this->filters['year'] ?? null;

        if (!$selectedYear) {
            $selectedYear = DemografiPenduduk::max('tahun_id') ?? now()->year;
        }

        // Get total population for selected year
        $totalPopulation = $validationService->getTotalPopulation($selectedYear);

        // Get year name for display
        $tahunData = TahunData::find($selectedYear);
        $yearName = $tahunData ? $tahunData->tahun : $selectedYear;

        // Statistics validation status
        $stats = [];

        // Population Overview
        if ($totalPopulation > 0) {
            $stats[] = Stat::make('Total Populasi ' . $yearName, number_format($totalPopulation))
                ->description('Data dari DemografiPenduduk')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary');
        } else {
            $stats[] = Stat::make('Total Populasi ' . $yearName, 'Tidak Ada Data')
                ->description('Data demografi belum tersedia')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning');

            return $stats; // Return early if no population data
        }

        // Validation status for each statistic type
        $statisticTypes = [
            'umur' => ['model' => UmurStatistik::class, 'name' => 'Umur', 'icon' => 'heroicon-m-user-group'],
            'pekerjaan' => ['model' => PekerjaanStatistik::class, 'name' => 'Pekerjaan', 'icon' => 'heroicon-m-briefcase'],
            'pendidikan' => ['model' => PendidikanStatistik::class, 'name' => 'Pendidikan', 'icon' => 'heroicon-m-academic-cap'],
            'agama' => ['model' => AgamaStatistik::class, 'name' => 'Agama', 'icon' => 'heroicon-m-heart'],
            'perkawinan' => ['model' => PerkawinanStatistik::class, 'name' => 'Perkawinan', 'icon' => 'heroicon-m-heart'],
            'wajib_pilih' => ['model' => WajibPilihStatistik::class, 'name' => 'Wajib Pilih', 'icon' => 'heroicon-m-identification'],
        ];

        foreach ($statisticTypes as $type => $config) {
            $validationResult = $validationService->getExistingDataValidation($selectedYear, $type);
            
            $isValid = $validationResult['isValid'];
            $totalCount = $validationResult['totalCount'];
            $difference = $validationResult['difference'];

            if ($totalCount === 0) {
                $stats[] = Stat::make($config['name'], 'Belum Ada Data')
                    ->description('Data belum diinput')
                    ->descriptionIcon('heroicon-m-minus-circle')
                    ->color('gray');
            } else {
                $color = $isValid ? 'success' : 'danger';
                $icon = $isValid ? 'heroicon-m-check-circle' : 'heroicon-m-x-circle';

                // Special handling for wajib_pilih and perkawinan (always show as available if data exists)
                if (in_array($type, ['wajib_pilih', 'perkawinan'])) {
                    $color = 'info';
                    $icon = 'heroicon-m-information-circle';
                    $description = 'Data tersedia (tidak divalidasi dengan populasi)';
                } else {
                    $description = $isValid
                        ? 'Data konsisten dengan populasi'
                        : 'Selisih: ' . number_format(abs($difference)) . ($difference > 0 ? ' (lebih)' : ' (kurang)');
                }

                $stats[] = Stat::make($config['name'], number_format($totalCount))
                    ->description($description)
                    ->descriptionIcon($icon)
                    ->color($color);
            }
        }

        // Overall validation status (exclude wajib_pilih and perkawinan from validation)
        $allValid = true;
        $totalInconsistencies = 0;
        $totalWithData = 0;

        foreach ($statisticTypes as $type => $config) {
            $result = $validationService->getExistingDataValidation($selectedYear, $type);
            if ($result['totalCount'] > 0) {
                $totalWithData++;
                // Only count inconsistency for statistics that are validated against population
                if (!in_array($type, ['wajib_pilih', 'perkawinan']) && !$result['isValid']) {
                    $allValid = false;
                    $totalInconsistencies++;
                }
            }
        }

        if ($totalWithData === 0) {
            $stats[] = Stat::make('Status Validasi', 'Belum Ada Data Statistik')
                ->description('Mulai input data statistik')
                ->descriptionIcon('heroicon-m-information-circle')
                ->color('info');
        } else {
            $overallColor = $allValid ? 'success' : ($totalInconsistencies > 3 ? 'danger' : 'warning');
            $overallIcon = $allValid ? 'heroicon-m-shield-check' : 'heroicon-m-shield-exclamation';
            $overallDescription = $allValid
                ? $totalWithData . ' statistik konsisten'
                : $totalInconsistencies . ' dari ' . $totalWithData . ' statistik tidak konsisten';

            $stats[] = Stat::make('Status Validasi', $allValid ? 'Semua Valid' : 'Ada Masalah')
                ->description($overallDescription)
                ->descriptionIcon($overallIcon)
                ->color($overallColor);
        }

        return $stats;
    }

    protected function getColumns(): int
    {
        return 4; // Display in 4 columns
    }
}

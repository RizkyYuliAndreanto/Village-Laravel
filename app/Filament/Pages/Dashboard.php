<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\QuickStatsWidget;
use App\Filament\Widgets\YearFilterWidget;
use App\Filament\Widgets\PopulationValidationChartWidget;
use App\Filament\Widgets\YearValidationSummaryWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Validasi Populasi';

    public function getWidgets(): array
    {
        return [
            YearFilterWidget::class,
            PopulationValidationChartWidget::class,
            YearValidationSummaryWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }
}

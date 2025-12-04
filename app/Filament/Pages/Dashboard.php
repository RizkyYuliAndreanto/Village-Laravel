<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\QuickStatsWidget;
use App\Filament\Widgets\YearFilterWidget;
use App\Filament\Widgets\PopulationValidationChartWidget;
use App\Filament\Widgets\YearValidationSummaryWidget;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard Validasi Populasi';
    protected static string $routePath = '/';
    protected static ?string $slug = 'dashboard';
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        // Temporarily disable custom widgets for debugging
        return [
            // YearFilterWidget::class,
            // PopulationValidationChartWidget::class,
            // YearValidationSummaryWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 1;
    }
}

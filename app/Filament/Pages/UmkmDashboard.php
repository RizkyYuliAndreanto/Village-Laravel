<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UmkmStatsWidget;
use App\Filament\Widgets\UmkmDistributionChartWidget;
use App\Filament\Widgets\UmkmTableWidget;
use App\Filament\Widgets\UmkmTrendChartWidget;
use Filament\Pages\Dashboard;

class UmkmDashboard extends Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Dashboard UMKM';
    protected static ?string $title = 'Dashboard UMKM';
    protected static ?string $navigationGroup = 'UMKM Management';
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            UmkmStatsWidget::class,
            UmkmDistributionChartWidget::class,
            UmkmTrendChartWidget::class,
            UmkmTableWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('manage_umkm')
                ->label('Kelola UMKM')
                ->icon('heroicon-o-building-storefront')
                ->color('primary')
                ->url(fn() => \App\Filament\Resources\UmkmResource::getUrl('index')),
            \Filament\Actions\Action::make('manage_kategori')
                ->label('Kelola Kategori')
                ->icon('heroicon-o-tag')
                ->color('warning')
                ->url(fn() => \App\Filament\Resources\KategoriUmkmResource::getUrl('index')),
            \Filament\Actions\Action::make('add_umkm')
                ->label('Tambah UMKM')
                ->icon('heroicon-o-plus-circle')
                ->color('success')
                ->url(fn() => \App\Filament\Resources\UmkmResource::getUrl('create')),
        ];
    }
}

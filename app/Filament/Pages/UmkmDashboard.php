<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\UmkmStatsWidget;
use App\Filament\Widgets\UmkmDistributionChartWidget;
use App\Filament\Widgets\UmkmTableWidget;
use App\Filament\Widgets\UmkmTrendChartWidget;
use Filament\Pages\Page;

class UmkmDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Dashboard UMKM';
    protected static ?string $title = 'Dashboard UMKM';
    protected static ?string $navigationGroup = 'UMKM';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.umkm-dashboard';

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
        return 1;
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
            \Filament\Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $this->dispatch('$refresh');
                    \Filament\Notifications\Notification::make()
                        ->success()
                        ->title('Dashboard telah diperbarui')
                        ->send();
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources\UmurStatistikResource\Pages;

use App\Filament\Resources\UmurStatistikResource;
use App\Models\UmurStatistik;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUmurStatistik extends ViewRecord
{
    protected static string $resource = UmurStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Tahun')
                    ->schema([
                        Infolists\Components\TextEntry::make('tahunData.tahun')
                            ->label('Tahun')
                            ->badge()
                            ->color('primary'),
                    ])->columns(1),

                Infolists\Components\Section::make('Data Statistik Umur')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('umur_0_4')
                                    ->label('Umur 0-4 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_5_9')
                                    ->label('Umur 5-9 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_10_14')
                                    ->label('Umur 10-14 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_15_19')
                                    ->label('Umur 15-19 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_20_24')
                                    ->label('Umur 20-24 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_25_29')
                                    ->label('Umur 25-29 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_30_34')
                                    ->label('Umur 30-34 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_35_39')
                                    ->label('Umur 35-39 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_40_44')
                                    ->label('Umur 40-44 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_45_49')
                                    ->label('Umur 45-49 Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),

                                Infolists\Components\TextEntry::make('umur_50_plus')
                                    ->label('Umur 50+ Tahun')
                                    ->formatStateUsing(fn(string $state): string => number_format($state) . ' orang'),
                            ]),
                    ]),

                Infolists\Components\Section::make('Ringkasan')
                    ->schema([
                        Infolists\Components\TextEntry::make('total_penduduk')
                            ->label('Total Penduduk')
                            ->formatStateUsing(function (UmurStatistik $record): string {
                                $total = $record->umur_0_4 + $record->umur_5_9 + $record->umur_10_14 +
                                    $record->umur_15_19 + $record->umur_20_24 + $record->umur_25_29 +
                                    $record->umur_30_34 + $record->umur_35_39 + $record->umur_40_44 +
                                    $record->umur_45_49 + $record->umur_50_plus;
                                return number_format($total) . ' orang';
                            })
                            ->badge()
                            ->color('success')
                            ->size('lg'),
                    ])->columns(1),
            ]);
    }
}

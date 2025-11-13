<?php

namespace App\Filament\Resources\DemografiPendudukResource\Pages;

use App\Filament\Resources\DemografiPendudukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDemografiPenduduks extends ListRecords
{
    protected static string $resource = DemografiPendudukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Demografi')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}

<?php

namespace App\Filament\Resources\TahunDataResource\Pages;

use App\Filament\Resources\TahunDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahunData extends ListRecords
{
    protected static string $resource = TahunDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Tahun')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}

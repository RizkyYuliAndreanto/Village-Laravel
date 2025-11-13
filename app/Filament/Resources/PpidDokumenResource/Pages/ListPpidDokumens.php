<?php

namespace App\Filament\Resources\PpidDokumenResource\Pages;

use App\Filament\Resources\PpidDokumenResource;
use Filament\Resources\Pages\ListRecords;

class ListPpidDokumens extends ListRecords
{
    protected static string $resource = PpidDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

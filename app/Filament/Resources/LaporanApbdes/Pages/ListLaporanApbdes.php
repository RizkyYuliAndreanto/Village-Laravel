<?php

namespace App\Filament\Resources\LaporanApbdes\Pages;

use App\Filament\Resources\LaporanApbdesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaporanApbdes extends ListRecords
{
    protected static string $resource = LaporanApbdesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

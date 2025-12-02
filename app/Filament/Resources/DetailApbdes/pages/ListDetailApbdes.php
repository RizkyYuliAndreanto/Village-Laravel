<?php

namespace App\Filament\Resources\DetailApbdes\Pages;

use App\Filament\Resources\DetailApbdesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDetailApbdes extends ListRecords
{
    protected static string $resource = DetailApbdesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

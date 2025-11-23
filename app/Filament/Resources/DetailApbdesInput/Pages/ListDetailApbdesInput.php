<?php

namespace App\Filament\Resources\DetailApbdesInput\Pages;

use App\Filament\Resources\DetailApbdesInputResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDetailApbdesInput extends ListRecords
{
    protected static string $resource = DetailApbdesInputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

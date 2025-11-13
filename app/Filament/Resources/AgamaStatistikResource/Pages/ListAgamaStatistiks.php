<?php

namespace App\Filament\Resources\AgamaStatistikResource\Pages;

use App\Filament\Resources\AgamaStatistikResource;
use Filament\Resources\Pages\ListRecords;

class ListAgamaStatistiks extends ListRecords
{
    protected static string $resource = AgamaStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

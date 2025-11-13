<?php

namespace App\Filament\Resources\PerkawinanStatistikResource\Pages;

use App\Filament\Resources\PerkawinanStatistikResource;
use Filament\Resources\Pages\ListRecords;

class ListPerkawinanStatistiks extends ListRecords
{
    protected static string $resource = PerkawinanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

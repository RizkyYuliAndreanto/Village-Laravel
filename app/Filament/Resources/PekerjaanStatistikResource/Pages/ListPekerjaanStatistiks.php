<?php

namespace App\Filament\Resources\PekerjaanStatistikResource\Pages;

use App\Filament\Resources\PekerjaanStatistikResource;
use Filament\Resources\Pages\ListRecords;

class ListPekerjaanStatistiks extends ListRecords
{
    protected static string $resource = PekerjaanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

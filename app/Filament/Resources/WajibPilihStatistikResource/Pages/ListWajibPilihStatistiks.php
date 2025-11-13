<?php

namespace App\Filament\Resources\WajibPilihStatistikResource\Pages;

use App\Filament\Resources\WajibPilihStatistikResource;
use Filament\Resources\Pages\ListRecords;

class ListWajibPilihStatistiks extends ListRecords
{
    protected static string $resource = WajibPilihStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

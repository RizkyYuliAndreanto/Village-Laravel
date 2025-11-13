<?php

namespace App\Filament\Resources\PendidikanStatistikResource\Pages;

use App\Filament\Resources\PendidikanStatistikResource;
use Filament\Resources\Pages\ListRecords;

class ListPendidikanStatistiks extends ListRecords
{
    protected static string $resource = PendidikanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

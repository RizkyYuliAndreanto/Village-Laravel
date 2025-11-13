<?php

namespace App\Filament\Resources\UmurStatistikResource\Pages;

use App\Filament\Resources\UmurStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUmurStatistiks extends ListRecords
{
    protected static string $resource = UmurStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

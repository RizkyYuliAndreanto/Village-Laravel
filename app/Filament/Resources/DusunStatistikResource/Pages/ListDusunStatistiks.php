<?php

namespace App\Filament\Resources\DusunStatistikResource\Pages;

use App\Filament\Resources\DusunStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDusunStatistiks extends ListRecords
{
    protected static string $resource = DusunStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

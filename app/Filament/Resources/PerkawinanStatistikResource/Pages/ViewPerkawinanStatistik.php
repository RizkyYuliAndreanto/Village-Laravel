<?php

namespace App\Filament\Resources\PerkawinanStatistikResource\Pages;

use App\Filament\Resources\PerkawinanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPerkawinanStatistik extends ViewRecord
{
    protected static string $resource = PerkawinanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

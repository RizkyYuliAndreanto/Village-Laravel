<?php

namespace App\Filament\Resources\AgamaStatistikResource\Pages;

use App\Filament\Resources\AgamaStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAgamaStatistik extends ViewRecord
{
    protected static string $resource = AgamaStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

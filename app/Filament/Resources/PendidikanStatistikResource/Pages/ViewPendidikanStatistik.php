<?php

namespace App\Filament\Resources\PendidikanStatistikResource\Pages;

use App\Filament\Resources\PendidikanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPendidikanStatistik extends ViewRecord
{
    protected static string $resource = PendidikanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

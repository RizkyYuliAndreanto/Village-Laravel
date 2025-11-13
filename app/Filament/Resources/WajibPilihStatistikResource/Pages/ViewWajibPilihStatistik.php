<?php

namespace App\Filament\Resources\WajibPilihStatistikResource\Pages;

use App\Filament\Resources\WajibPilihStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWajibPilihStatistik extends ViewRecord
{
    protected static string $resource = WajibPilihStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

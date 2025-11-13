<?php

namespace App\Filament\Resources\PekerjaanStatistikResource\Pages;

use App\Filament\Resources\PekerjaanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPekerjaanStatistik extends ViewRecord
{
    protected static string $resource = PekerjaanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

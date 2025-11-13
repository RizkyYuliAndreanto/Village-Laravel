<?php

namespace App\Filament\Resources\PekerjaanStatistikResource\Pages;

use App\Filament\Resources\PekerjaanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPekerjaanStatistik extends EditRecord
{
    protected static string $resource = PekerjaanStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

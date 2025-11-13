<?php

namespace App\Filament\Resources\WajibPilihStatistikResource\Pages;

use App\Filament\Resources\WajibPilihStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWajibPilihStatistik extends EditRecord
{
    protected static string $resource = WajibPilihStatistikResource::class;

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

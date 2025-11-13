<?php

namespace App\Filament\Resources\PerkawinanStatistikResource\Pages;

use App\Filament\Resources\PerkawinanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerkawinanStatistik extends EditRecord
{
    protected static string $resource = PerkawinanStatistikResource::class;

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

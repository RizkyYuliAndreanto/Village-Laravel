<?php

namespace App\Filament\Resources\AgamaStatistikResource\Pages;

use App\Filament\Resources\AgamaStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAgamaStatistik extends EditRecord
{
    protected static string $resource = AgamaStatistikResource::class;

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

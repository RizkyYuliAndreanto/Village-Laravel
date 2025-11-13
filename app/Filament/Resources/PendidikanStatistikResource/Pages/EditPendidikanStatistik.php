<?php

namespace App\Filament\Resources\PendidikanStatistikResource\Pages;

use App\Filament\Resources\PendidikanStatistikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendidikanStatistik extends EditRecord
{
    protected static string $resource = PendidikanStatistikResource::class;

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

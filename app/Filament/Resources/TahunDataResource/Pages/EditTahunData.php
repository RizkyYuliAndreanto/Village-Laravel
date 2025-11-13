<?php

namespace App\Filament\Resources\TahunDataResource\Pages;

use App\Filament\Resources\TahunDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahunData extends EditRecord
{
    protected static string $resource = TahunDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(fn() => $this->redirect($this->getResource()::getUrl('index'))),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data Tahun berhasil diperbarui!';
    }
}

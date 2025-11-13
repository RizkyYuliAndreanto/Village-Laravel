<?php

namespace App\Filament\Resources\StrukturOrganisasiResource\Pages;

use App\Filament\Resources\StrukturOrganisasiResource;
use App\Services\MediaStorageService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStrukturOrganisasi extends EditRecord
{
    protected static string $resource = StrukturOrganisasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle photo upload using MediaStorageService
        if (isset($data['foto_url']) && is_object($data['foto_url'])) {
            $mediaService = app(MediaStorageService::class);

            // Delete old photo if exists
            if ($this->record->foto_url) {
                $mediaService->delete($this->record->foto_url);
            }

            // Store new photo
            $data['foto_url'] = $mediaService->store($data['foto_url'], 'struktur-organisasi');
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Filament\Resources\StrukturOrganisasiResource\Pages;

use App\Filament\Resources\StrukturOrganisasiResource;
use App\Services\MediaStorageService;
use Filament\Resources\Pages\CreateRecord;

class CreateStrukturOrganisasi extends CreateRecord
{
    protected static string $resource = StrukturOrganisasiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle photo upload using MediaStorageService
        if (isset($data['foto_url']) && is_object($data['foto_url'])) {
            $mediaService = app(MediaStorageService::class);
            $data['foto_url'] = $mediaService->store($data['foto_url'], 'struktur-organisasi');
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

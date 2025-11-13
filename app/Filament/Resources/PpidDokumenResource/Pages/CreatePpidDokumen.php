<?php

namespace App\Filament\Resources\PpidDokumenResource\Pages;

use App\Filament\Resources\PpidDokumenResource;
use App\Services\MediaStorageService;
use Filament\Resources\Pages\CreateRecord;

class CreatePpidDokumen extends CreateRecord
{
    protected static string $resource = PpidDokumenResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle file upload using MediaStorageService
        if (isset($data['file_url']) && is_object($data['file_url'])) {
            $mediaService = app(MediaStorageService::class);
            $data['file_url'] = $mediaService->store($data['file_url'], 'ppid-dokumen');
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

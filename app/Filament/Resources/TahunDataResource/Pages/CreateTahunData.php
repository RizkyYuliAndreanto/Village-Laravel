<?php

namespace App\Filament\Resources\TahunDataResource\Pages;

use App\Filament\Resources\TahunDataResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTahunData extends CreateRecord
{
    protected static string $resource = TahunDataResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Tahun berhasil ditambahkan!';
    }
}

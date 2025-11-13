<?php

namespace App\Filament\Resources\KategoriUmkmResource\Pages;

use App\Filament\Resources\KategoriUmkmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriUmkm extends EditRecord
{
    protected static string $resource = KategoriUmkmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\DetailApbdesInput\Pages;

use App\Filament\Resources\DetailApbdesInputResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailApbdesInput extends EditRecord
{
    protected static string $resource = DetailApbdesInputResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

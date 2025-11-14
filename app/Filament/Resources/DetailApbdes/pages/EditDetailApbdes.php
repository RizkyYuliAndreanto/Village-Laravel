<?php

namespace App\Filament\Resources\DetailApbdes\Pages;

use App\Filament\Resources\DetailApbdesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDetailApbdes extends EditRecord
{
    protected static string $resource = DetailApbdesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

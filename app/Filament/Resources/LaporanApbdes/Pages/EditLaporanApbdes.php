<?php

namespace App\Filament\Resources\LaporanApbdes\Pages;

use App\Filament\Resources\LaporanApbdesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLaporanApbdes extends EditRecord
{
    protected static string $resource = LaporanApbdesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

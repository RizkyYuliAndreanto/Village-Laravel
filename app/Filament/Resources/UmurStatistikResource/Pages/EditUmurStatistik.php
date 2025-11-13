<?php

namespace App\Filament\Resources\UmurStatistikResource\Pages;

use App\Filament\Resources\UmurStatistikResource;
use App\Models\UmurStatistik;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditUmurStatistik extends EditRecord
{
    protected static string $resource = UmurStatistikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeSave(): void
    {
        // Check if tahun_id already exists (excluding current record)
        $tahunId = $this->data['tahun_id'];
        $currentId = $this->record->id_umur;

        if (UmurStatistik::where('tahun_id', $tahunId)->where('id_umur', '!=', $currentId)->exists()) {
            throw ValidationException::withMessages([
                'tahun_id' => 'Data statistik umur untuk tahun ini sudah ada. Silakan pilih tahun yang lain.',
            ]);
        }
    }
}

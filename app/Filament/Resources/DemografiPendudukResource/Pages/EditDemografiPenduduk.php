<?php

namespace App\Filament\Resources\DemografiPendudukResource\Pages;

use App\Filament\Resources\DemografiPendudukResource;
use App\Models\DemografiPenduduk;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditDemografiPenduduk extends EditRecord
{
    protected static string $resource = DemografiPendudukResource::class;

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
        return 'Data Demografi Penduduk berhasil diperbarui!';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If tahun_id is being set/changed, ensure no other record uses the same tahun_id
        if (isset($data['tahun_id'])) {
            $existing = DemografiPenduduk::where('tahun_id', $data['tahun_id'])
                ->where('id', '<>', $this->record->id)
                ->exists();

            if ($existing) {
                throw ValidationException::withMessages([
                    'tahun_id' => 'Data demografi untuk tahun yang dipilih sudah ada. Silakan edit atau hapus data tersebut jika ingin menambahkan/ubah data untuk tahun ini.',
                ]);
            }
        }

        return $data;
    }
}

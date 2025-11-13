<?php

namespace App\Filament\Resources\DusunStatistikResource\Pages;

use App\Filament\Resources\DusunStatistikResource;
use App\Models\DusunStatistik;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditDusunStatistik extends EditRecord
{
    protected static string $resource = DusunStatistikResource::class;

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
        return 'Data Statistik Dusun berhasil diperbarui!';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If tahun_id or nama_dusun is being changed, ensure no other record uses the same combination
        if (isset($data['tahun_id']) && isset($data['nama_dusun'])) {
            $existing = DusunStatistik::where('tahun_id', $data['tahun_id'])
                ->where('nama_dusun', $data['nama_dusun'])
                ->where('id_dusun', '<>', $this->record->id_dusun)
                ->exists();

            if ($existing) {
                throw ValidationException::withMessages([
                    'nama_dusun' => 'Data statistik untuk dusun "' . $data['nama_dusun'] . '" pada tahun yang dipilih sudah ada. Silakan pilih nama dusun yang berbeda atau edit data yang sudah ada.',
                ]);
            }
        }

        return $data;
    }
}

<?php

namespace App\Filament\Resources\DusunStatistikResource\Pages;

use App\Filament\Resources\DusunStatistikResource;
use App\Models\DusunStatistik;
use App\Traits\HasDuplicateValidation;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateDusunStatistik extends CreateRecord
{
    use HasDuplicateValidation;

    protected static string $resource = DusunStatistikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Statistik Dusun berhasil ditambahkan!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateDuplicateData($data['tahun_id'], $data['nama_dusun']);
        return $data;
    }

    protected function validateDuplicateData(int $tahunId, string $namaDusun): void
    {
        $existingRecord = DusunStatistik::where('tahun_id', $tahunId)
            ->where('nama_dusun', $namaDusun)
            ->with('tahunData')
            ->first();

        if ($existingRecord) {
            $tahun = $existingRecord->tahunData->tahun ?? 'Unknown';

            $this->showDuplicateNotification(
                'Data Sudah Ada!',
                "Data statistik dusun \"{$namaDusun}\" untuk tahun {$tahun} sudah tersedia.",
                DusunStatistikResource::getUrl('edit', ['record' => $existingRecord->id_dusun]),
                DusunStatistikResource::getUrl('index')
            );

            $this->throwDuplicateValidationException(
                'nama_dusun',
                "Data statistik dusun \"{$namaDusun}\" untuk tahun {$tahun} sudah ada."
            );
        }
    }
}

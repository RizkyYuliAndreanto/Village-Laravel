<?php

namespace App\Filament\Resources\DemografiPendudukResource\Pages;

use App\Filament\Resources\DemografiPendudukResource;
use App\Models\DemografiPenduduk;
use App\Traits\HasDuplicateValidation;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateDemografiPenduduk extends CreateRecord
{
    use HasDuplicateValidation;

    protected static string $resource = DemografiPendudukResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Data Demografi Penduduk berhasil ditambahkan!';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->validateDuplicateYear($data['tahun_id']);
        return $data;
    }

    protected function validateDuplicateYear(int $tahunId): void
    {
        $existingRecord = DemografiPenduduk::where('tahun_id', $tahunId)
            ->with('tahunData')
            ->first();

        if ($existingRecord) {
            $tahun = $existingRecord->tahunData->tahun ?? 'Unknown';

            $this->showDuplicateNotification(
                'Data Sudah Ada!',
                "Data demografi penduduk untuk tahun {$tahun} sudah tersedia.",
                DemografiPendudukResource::getUrl('edit', ['record' => $existingRecord->id_demografi]),
                DemografiPendudukResource::getUrl('index')
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                "Data demografi penduduk untuk tahun {$tahun} sudah ada."
            );
        }
    }
}

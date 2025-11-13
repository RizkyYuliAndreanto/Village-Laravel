<?php

namespace App\Filament\Resources\UmurStatistikResource\Pages;

use App\Filament\Resources\UmurStatistikResource;
use App\Models\UmurStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateUmurStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = UmurStatistikResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data first
        $this->validateDuplicateYear($data['tahun_id']);

        // Validate population consistency
        $this->validatePopulationData($data, 'umur');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function validateDuplicateYear(int $tahunId): void
    {
        $existingRecord = UmurStatistik::where('tahun_id', $tahunId)
            ->with('tahunData')
            ->first();

        if ($existingRecord) {
            $tahun = $existingRecord->tahunData->tahun ?? 'Unknown';

            $this->showDuplicateNotification(
                'Data Sudah Ada!',
                "Data statistik umur untuk tahun {$tahun} sudah tersedia.",
                UmurStatistikResource::getUrl('edit', ['record' => $existingRecord->id_umur]),
                UmurStatistikResource::getUrl('view', ['record' => $existingRecord->id_umur])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                "Data statistik umur untuk tahun {$tahun} sudah ada."
            );
        }
    }
}

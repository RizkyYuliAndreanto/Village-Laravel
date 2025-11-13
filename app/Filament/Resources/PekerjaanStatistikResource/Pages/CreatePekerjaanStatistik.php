<?php

namespace App\Filament\Resources\PekerjaanStatistikResource\Pages;

use App\Filament\Resources\PekerjaanStatistikResource;
use App\Models\PekerjaanStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePekerjaanStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = PekerjaanStatistikResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data
        $existing = PekerjaanStatistik::where('tahun_id', $data['tahun_id'])->first();

        if ($existing) {
            $this->showDuplicateNotification(
                'Data statistik pekerjaan untuk tahun ini sudah ada!',
                'Data dengan tahun yang sama sudah tersimpan dalam database.',
                PekerjaanStatistikResource::getUrl('edit', ['record' => $existing]),
                PekerjaanStatistikResource::getUrl('view', ['record' => $existing])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                'Data statistik pekerjaan untuk tahun yang dipilih sudah ada.'
            );
        }

        // Validate population consistency
        $this->validatePopulationData($data, 'pekerjaan');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

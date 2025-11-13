<?php

namespace App\Filament\Resources\PerkawinanStatistikResource\Pages;

use App\Filament\Resources\PerkawinanStatistikResource;
use App\Models\PerkawinanStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePerkawinanStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = PerkawinanStatistikResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data
        $existing = PerkawinanStatistik::where('tahun_id', $data['tahun_id'])->first();

        if ($existing) {
            $this->showDuplicateNotification(
                'Data statistik perkawinan untuk tahun ini sudah ada!',
                'Data dengan tahun yang sama sudah tersimpan dalam database.',
                PerkawinanStatistikResource::getUrl('edit', ['record' => $existing]),
                PerkawinanStatistikResource::getUrl('view', ['record' => $existing])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                'Data statistik perkawinan untuk tahun yang dipilih sudah ada.'
            );
        }

        // Validate population consistency
        $this->validatePopulationData($data, 'perkawinan');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

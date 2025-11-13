<?php

namespace App\Filament\Resources\PendidikanStatistikResource\Pages;

use App\Filament\Resources\PendidikanStatistikResource;
use App\Models\PendidikanStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePendidikanStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = PendidikanStatistikResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data
        $existing = PendidikanStatistik::where('tahun_id', $data['tahun_id'])->first();

        if ($existing) {
            $this->showDuplicateNotification(
                'Data statistik pendidikan untuk tahun ini sudah ada!',
                'Data dengan tahun yang sama sudah tersimpan dalam database.',
                PendidikanStatistikResource::getUrl('edit', ['record' => $existing]),
                PendidikanStatistikResource::getUrl('view', ['record' => $existing])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                'Data statistik pendidikan untuk tahun yang dipilih sudah ada.'
            );
        }

        // Validate population consistency
        $this->validatePopulationData($data, 'pendidikan');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

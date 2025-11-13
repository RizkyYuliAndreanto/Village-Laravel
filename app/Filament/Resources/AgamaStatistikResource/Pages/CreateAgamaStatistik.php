<?php

namespace App\Filament\Resources\AgamaStatistikResource\Pages;

use App\Filament\Resources\AgamaStatistikResource;
use App\Models\AgamaStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAgamaStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = AgamaStatistikResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data
        $existing = AgamaStatistik::where('tahun_id', $data['tahun_id'])->first();

        if ($existing) {
            $this->showDuplicateNotification(
                'Data statistik agama untuk tahun ini sudah ada!',
                'Data dengan tahun yang sama sudah tersimpan dalam database.',
                AgamaStatistikResource::getUrl('edit', ['record' => $existing]),
                AgamaStatistikResource::getUrl('view', ['record' => $existing])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                'Data statistik agama untuk tahun yang dipilih sudah ada.'
            );
        }

        // Validate population consistency
        $this->validatePopulationData($data, 'agama');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

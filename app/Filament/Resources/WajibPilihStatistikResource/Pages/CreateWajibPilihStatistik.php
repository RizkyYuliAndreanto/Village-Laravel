<?php

namespace App\Filament\Resources\WajibPilihStatistikResource\Pages;

use App\Filament\Resources\WajibPilihStatistikResource;
use App\Models\WajibPilihStatistik;
use App\Traits\HasDuplicateValidation;
use App\Traits\HasPopulationValidation;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateWajibPilihStatistik extends CreateRecord
{
    use HasDuplicateValidation, HasPopulationValidation;

    protected static string $resource = WajibPilihStatistikResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for duplicate data
        $existing = WajibPilihStatistik::where('tahun_id', $data['tahun_id'])->first();

        if ($existing) {
            $this->showDuplicateNotification(
                'Data statistik wajib pilih untuk tahun ini sudah ada!',
                'Data dengan tahun yang sama sudah tersimpan dalam database.',
                WajibPilihStatistikResource::getUrl('edit', ['record' => $existing]),
                WajibPilihStatistikResource::getUrl('view', ['record' => $existing])
            );

            $this->throwDuplicateValidationException(
                'tahun_id',
                'Data statistik wajib pilih untuk tahun yang dipilih sudah ada.'
            );
        }

        // Validate population consistency
        $this->validatePopulationData($data, 'wajib_pilih');

        // Show population summary for reference
        $this->showPopulationSummary($data['tahun_id']);

        return static::getModel()::create($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

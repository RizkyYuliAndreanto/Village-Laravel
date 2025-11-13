<?php

namespace App\Traits;

use Filament\Forms;
use Filament\Notifications\Notification;

trait HasLiveValidation
{
    /**
     * Send a warning notification for duplicate data
     */
    protected static function sendDuplicateWarning(string $message): void
    {
        Notification::make()
            ->warning()
            ->title('Perhatian!')
            ->body($message)
            ->duration(3000)
            ->send();
    }

    /**
     * Generate helper text for duplicate validation
     */
    protected static function getDuplicateHelperText(
        string $defaultMessage,
        bool $hasData,
        string $duplicateMessage,
        string $safeMessage
    ): string {
        if ($hasData === null) {
            return $defaultMessage;
        }

        if ($hasData) {
            return "⚠️ {$duplicateMessage}";
        }

        return "✅ {$safeMessage}";
    }

    /**
     * Create live validation for tahun_id field (single table)
     */
    protected static function createTahunLiveValidation(string $modelClass): array
    {
        return [
            'live' => true,
            'afterStateUpdated' => function ($state) use ($modelClass) {
                if ($state) {
                    $existing = $modelClass::where('tahun_id', $state)->exists();
                    if ($existing) {
                        $modelName = class_basename($modelClass);
                        static::sendDuplicateWarning("Tahun yang dipilih sudah memiliki data {$modelName}.");
                    }
                }
            },
            'helperText' => function ($state) use ($modelClass) {
                $modelName = strtolower(str_replace('_', ' ', \Illuminate\Support\Str::snake(class_basename($modelClass))));

                if (!$state) {
                    return "Pilih tahun untuk data {$modelName}. Sistem akan mengecek ketersediaan data.";
                }

                $existing = $modelClass::where('tahun_id', $state)->exists();
                return static::getDuplicateHelperText(
                    "Pilih tahun untuk data {$modelName}. Sistem akan mengecek ketersediaan data.",
                    $existing,
                    "Data {$modelName} untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.",
                    "Tahun ini belum memiliki data {$modelName}. Aman untuk membuat data baru."
                );
            }
        ];
    }

    /**
     * Create live validation for composite unique fields (tahun_id + another field)
     */
    protected static function createCompositeLiveValidation(
        string $modelClass,
        string $fieldName,
        string $getFieldFunction,
        string $fieldLabel
    ): array {
        return [
            'live' => true,
            'afterStateUpdated' => function ($state, Forms\Set $set, Forms\Get $get) use ($modelClass, $getFieldFunction, $fieldLabel) {
                $tahunId = $get('tahun_id');
                if ($state && $tahunId) {
                    $existing = $modelClass::where('tahun_id', $tahunId)
                        ->where($getFieldFunction, $state)
                        ->exists();
                    if ($existing) {
                        static::sendDuplicateWarning("{$fieldLabel} '{$state}' untuk tahun yang dipilih sudah ada.");
                    }
                }
            },
            'helperText' => function ($state, Forms\Get $get) use ($modelClass, $getFieldFunction, $fieldLabel) {
                $tahunId = $get('tahun_id');

                if (!$state || !$tahunId) {
                    return "Masukkan {$fieldLabel}. Sistem akan mengecek duplikasi.";
                }

                $existing = $modelClass::where('tahun_id', $tahunId)
                    ->where($getFieldFunction, $state)
                    ->exists();

                return static::getDuplicateHelperText(
                    "Masukkan {$fieldLabel}. Sistem akan mengecek duplikasi.",
                    $existing,
                    "{$fieldLabel} '{$state}' untuk tahun ini sudah ada. Jika Anda melanjutkan, akan ada error duplikasi.",
                    "{$fieldLabel} '{$state}' untuk tahun ini belum ada. Aman untuk membuat data baru."
                );
            }
        ];
    }

    /**
     * Create live validation for tahun_id with composite check
     */
    protected static function createTahunCompositeLiveValidation(
        string $modelClass,
        string $otherFieldName,
        string $otherFieldGetter,
        string $otherFieldLabel
    ): array {
        return [
            'live' => true,
            'afterStateUpdated' => function ($state, Forms\Set $set, Forms\Get $get) use ($modelClass, $otherFieldGetter, $otherFieldLabel) {
                $otherValue = $get($otherFieldGetter);
                if ($state && $otherValue) {
                    $existing = $modelClass::where('tahun_id', $state)
                        ->where($otherFieldGetter, $otherValue)
                        ->exists();
                    if ($existing) {
                        static::sendDuplicateWarning("{$otherFieldLabel} '{$otherValue}' untuk tahun yang dipilih sudah ada.");
                    }
                }
            }
        ];
    }
}

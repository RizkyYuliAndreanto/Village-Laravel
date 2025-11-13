<?php

namespace App\Helpers;

use App\Traits\HasLiveValidation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class FormBuilder
{
    use HasLiveValidation;

    /**
     * Create a tahun_id select field with live validation
     */
    public static function tahunSelect(string $modelClass, bool $isComposite = false, ?string $otherField = null): Select
    {
        $select = Select::make('tahun_id')
            ->label('Tahun Data')
            ->relationship('tahunData', 'tahun')
            ->required()
            ->searchable()
            ->preload();

        if ($isComposite && $otherField) {
            // For composite validation (tahun + another field)
            $validationConfig = static::createTahunCompositeLiveValidation(
                $modelClass,
                $otherField,
                $otherField,
                ucfirst(str_replace('_', ' ', $otherField))
            );
        } else {
            // For single tahun validation
            $validationConfig = static::createTahunLiveValidation($modelClass);
        }

        return $select
            ->live($validationConfig['live'])
            ->afterStateUpdated($validationConfig['afterStateUpdated'])
            ->helperText($validationConfig['helperText'] ?? 'Pilih tahun untuk data');
    }

    /**
     * Create a text input with live validation for composite unique constraint
     */
    public static function uniqueTextInput(
        string $fieldName,
        string $label,
        string $modelClass,
        ?string $placeholder = null,
        ?int $maxLength = null
    ): TextInput {
        $input = TextInput::make($fieldName)
            ->label($label)
            ->required();

        if ($placeholder) {
            $input->placeholder($placeholder);
        }

        if ($maxLength) {
            $input->maxLength($maxLength);
        }

        $validationConfig = static::createCompositeLiveValidation(
            $modelClass,
            $fieldName,
            $fieldName,
            $label
        );

        return $input
            ->live($validationConfig['live'])
            ->afterStateUpdated($validationConfig['afterStateUpdated'])
            ->helperText($validationConfig['helperText']);
    }

    /**
     * Create a select field with options and live validation
     */
    public static function uniqueSelect(
        string $fieldName,
        string $label,
        array $options,
        string $modelClass,
        ?string $placeholder = null
    ): Select {
        $select = Select::make($fieldName)
            ->label($label)
            ->options($options)
            ->required()
            ->searchable();

        if ($placeholder) {
            $select->placeholder($placeholder);
        }

        $validationConfig = static::createCompositeLiveValidation(
            $modelClass,
            $fieldName,
            $fieldName,
            $label
        );

        return $select
            ->live($validationConfig['live'])
            ->afterStateUpdated($validationConfig['afterStateUpdated'])
            ->helperText($validationConfig['helperText']);
    }
}

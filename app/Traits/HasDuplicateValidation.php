<?php

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

trait HasDuplicateValidation
{
    /**
     * Show user-friendly notification for duplicate data with action buttons
     */
    protected function showDuplicateNotification(
        string $title,
        string $message,
        string $editUrl,
        ?string $viewUrl = null
    ): void {
        $actions = [
            Action::make('edit')
                ->label('Edit Data yang Ada')
                ->button()
                ->url($editUrl)
                ->color('warning')
        ];

        if ($viewUrl) {
            $actions[] = Action::make('view')
                ->label('Lihat Data')
                ->url($viewUrl)
                ->color('gray');
        }

        Notification::make()
            ->danger()
            ->title($title)
            ->body($message)
            ->persistent()
            ->actions($actions)
            ->send();
    }

    /**
     * Throw validation exception with user-friendly message
     */
    protected function throwDuplicateValidationException(string $field, string $message): void
    {
        throw ValidationException::withMessages([
            $field => $message . " Gunakan tombol 'Edit Data yang Ada' di notifikasi untuk mengubah data."
        ]);
    }
}

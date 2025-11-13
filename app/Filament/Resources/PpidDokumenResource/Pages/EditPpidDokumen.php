<?php

namespace App\Filament\Resources\PpidDokumenResource\Pages;

use App\Filament\Resources\PpidDokumenResource;
use App\Services\MediaStorageService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPpidDokumen extends EditRecord
{
    protected static string $resource = PpidDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\Action::make('download')
                ->label('Download File')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn(): string => $this->record->file_url)
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle file upload using MediaStorageService
        if (isset($data['file_url']) && is_object($data['file_url'])) {
            $mediaService = app(MediaStorageService::class);

            // Delete old file if exists
            if ($this->record->file_url) {
                $mediaService->delete($this->record->file_url);
            }

            // Store new file
            $data['file_url'] = $mediaService->store($data['file_url'], 'ppid-dokumen');
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

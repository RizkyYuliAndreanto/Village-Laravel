<?php

namespace App\Filament\Resources\PpidDokumenResource\Pages;

use App\Filament\Resources\PpidDokumenResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPpidDokumen extends ViewRecord
{
    protected static string $resource = PpidDokumenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('download')
                ->label('Download File')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn(): string => $this->record->file_url)
                ->openUrlInNewTab(),
        ];
    }
}

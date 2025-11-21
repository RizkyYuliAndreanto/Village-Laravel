<?php

namespace App\Filament\Resources\BidangApbdes\Pages;

use App\Filament\Resources\BidangApbdesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBidangApbdes extends ListRecords
{
    protected static string $resource = BidangApbdesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

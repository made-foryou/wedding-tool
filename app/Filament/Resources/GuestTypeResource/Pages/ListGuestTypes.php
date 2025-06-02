<?php

namespace App\Filament\Resources\GuestTypeResource\Pages;

use App\Filament\Resources\GuestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuestTypes extends ListRecords
{
    protected static string $resource = GuestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

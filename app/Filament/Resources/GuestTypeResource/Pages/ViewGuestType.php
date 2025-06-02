<?php

namespace App\Filament\Resources\GuestTypeResource\Pages;

use App\Filament\Resources\GuestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGuestType extends ViewRecord
{
    protected static string $resource = GuestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

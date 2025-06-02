<?php

namespace App\Filament\Resources\GuestTypeResource\Pages;

use App\Filament\Resources\GuestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestType extends EditRecord
{
    protected static string $resource = GuestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}

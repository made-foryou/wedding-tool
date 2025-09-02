<?php

namespace App\Filament\Resources\GuestTypeResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use App\Filament\Resources\GuestTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestType extends EditRecord
{
    protected static string $resource = GuestTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

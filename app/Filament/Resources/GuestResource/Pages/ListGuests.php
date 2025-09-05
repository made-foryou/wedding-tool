<?php

namespace App\Filament\Resources\GuestResource\Pages;

use App\Domains\Guests\Models\Guest;
use App\Domains\Presence\Models\Event;
use Filament\Actions\CreateAction;
use App\Filament\Resources\GuestResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListGuests extends ListRecords
{
    protected static string $resource = GuestResource::class;

    public function getTabs(): array
    {
        $events = Event::all();

        $tabs = [
            'all' => Tab::make('Allemaal'),
        ];

        foreach ($events as $event) {
            $tabs[] = Tab::make($event->name)
                ->modifyQueryUsing(function (Builder $query) use ($event): void {
                    $query->whereHas('events', function (Builder $query) use ($event) {
                        $query->where('event_id', '=', $event->id);
                    });
                })
                ->badge(Guest::query()->whereHas('events', function (Builder $query) use ($event) {
                    $query->where('event_id', '=', $event->id);
                })->count());
        }

        return $tabs;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

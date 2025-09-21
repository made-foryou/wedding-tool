<?php

namespace App\Livewire;

use App\Domains\Guests\Models\Guest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PresenceOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            $this->getPresentParty(),
            $this->getPresentFriday(),
            $this->getPresentSunday(),
            $this->getPresentBrunch(),
        ];
    }

    protected function getPresentFriday(): Stat
    {
        $count = Guest::query()
            ->whereHas('events', function ($query) {
                $query->where('event_id', 2);
            })
            ->count();

        return Stat::make('Aanwezig vrijdag avond', $count.' gasten');
    }

    protected function getPresentBrunch(): Stat
    {
        $count = Guest::query()
            ->whereHas('events', function ($query) {
                $query->where('event_id', 3);
            })
            ->count();

        return Stat::make('Aanwezig brunch', $count.' gasten');
    }

    protected function getPresentParty(): Stat
    {
        $guests = Guest::query()
            ->where(function ($query) {
                $query->where('guest_type_id', 2)
                    ->where('present', true)
                    ->whereHas('events', function ($query) {
                        $query->where('event_id', 1);
                    });
            })
            ->orWhere(function ($query) {
                $query->where('guest_type_id', 1)
                    ->where('present', true);
            })
            ->count();

        return Stat::make('Aanwezig feest', $guests.' gasten');
    }

    protected function getPresentSunday(): Stat
    {
        $count = Guest::query()
            ->where(function ($query) {
                $query->where('guest_type_id', 2)
                    ->whereHas('events', function ($query) {
                        $query->where('event_id', 9);
                    });
            })
            ->orWhere(function ($query) {
                $query->where('guest_type_id', 1)
                    ->whereHas('events', function ($query) {
                        $query->where('event_id', 8);
                    });
            })
            ->count();

        return Stat::make('Aanwezig katerontbijt', $count.' gasten');
    }
}

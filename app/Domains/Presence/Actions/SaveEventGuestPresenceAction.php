<?php

namespace App\Domains\Presence\Actions;

use App\Domains\Presence\Data\EventGuestPresenceData;
use Illuminate\Support\Collection;

final readonly class SaveEventGuestPresenceAction
{
    /**
     * @param  Collection<EventGuestPresenceData>  $combinations
     */
    public static function execute(Collection $combinations): void
    {
        (new self)->run($combinations);
    }

    /**
     * @param  Collection<EventGuestPresenceData>  $combinations
     */
    public function run(Collection $combinations): void
    {
        $combinations->each(function (EventGuestPresenceData $combination): void {
            $combination->event->guests()->attach($combination->guest);
            $combination->event->save();
        });
    }
}

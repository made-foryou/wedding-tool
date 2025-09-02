<?php

namespace App\Domains\Presence\Actions;

use Illuminate\Support\Facades\DB;
use App\Domains\Guests\Models\Guest;
use App\Domains\Presence\Data\EventGuestPresenceData;
use Illuminate\Support\Collection;

final readonly class SaveEventGuestPresenceAction
{
    /**
     * @param  Collection<EventGuestPresenceData>  $combinations
     */
    public static function execute(Collection $combinations, \Illuminate\Database\Eloquent\Collection $guests): void
    {
        (new self)->run($combinations, $guests);
    }

    /**
     * @param  Collection<EventGuestPresenceData>  $combinations
     */
    public function run(Collection $combinations, \Illuminate\Database\Eloquent\Collection $guests): void
    {
        $guests->each(function (Guest $guest) {
            DB::table('guest_event')->where('guest_id', $guest->id)->delete();
        });

        $combinations->each(function (EventGuestPresenceData $combination): void {
            $combination->event->guests()->attach($combination->guest);
            $combination->event->save();

            $combination->guest->has_registered = true;
            $combination->guest->save();
        });
    }
}

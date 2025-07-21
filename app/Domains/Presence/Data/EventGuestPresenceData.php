<?php

namespace App\Domains\Presence\Data;

use App\Domains\Guests\Models\Guest;
use App\Domains\Presence\Models\Event;

final readonly class EventGuestPresenceData
{
    public function __construct(
        public Event $event,
        public Guest $guest,
    ) {}

    public static function fromString(
        string $string,
        string $separator = ':'
    ): self {
        [$eventGuid, $guestGuid] = explode($separator, $string);

        return new self(
            Event::query()->fromUuid($eventGuid)->firstOrFail(),
            Guest::query()->fromUuid($guestGuid)->firstOrFail()
        );
    }
}

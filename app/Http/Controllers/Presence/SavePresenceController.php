<?php

declare(strict_types=1);

namespace App\Http\Controllers\Presence;

use App\Domains\Guests\Models\Guest;
use App\Domains\Presence\Actions\SaveEventGuestPresenceAction;
use App\Domains\Presence\Data\EventGuestPresenceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavePresenceController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $guestIds = $request->get('guests', []);

        $data = collect(array_keys($request->except('guests')))
            ->map(fn (string $combination): EventGuestPresenceData => EventGuestPresenceData::fromString($combination));

        $guests = Guest::query()->whereIn('uuid', $guestIds)->get();

        SaveEventGuestPresenceAction::execute($data, $guests);

        $request->session()->put('guests', $guests->pluck('uuid')->unique());
        $request->session()->save();

        return response()->json([], 200);
    }
}

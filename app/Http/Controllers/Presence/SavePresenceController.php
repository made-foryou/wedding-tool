<?php

declare(strict_types=1);

namespace App\Http\Controllers\Presence;

use App\Domains\Presence\Actions\SaveEventGuestPresenceAction;
use App\Domains\Presence\Data\EventGuestPresenceData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SavePresenceController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = collect(array_keys($request->all()))
            ->map(fn (string $combination): EventGuestPresenceData => EventGuestPresenceData::fromString($combination));

        $alreadyKnown = $data->filter(fn (EventGuestPresenceData $data) => $data->guest->events->isNotEmpty());

        if ($alreadyKnown->isNotEmpty()) {
            return response()->json([
                'already_known' => $alreadyKnown->pluck('guest.name')
                    ->unique(),
            ], 400);
        }

        SaveEventGuestPresenceAction::execute($data);

        $request->session()->put('guests', $data->pluck('guest.uuid')->unique());
        $request->session()->save();

        return response()->json([], 200);
    }
}

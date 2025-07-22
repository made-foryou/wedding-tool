<?php

declare(strict_types=1);

namespace App\Http\Controllers\Invite;

use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\Actions\SessionPresenceIsKnownAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guests\GuestTypeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AbsentPageController extends Controller
{
    public function __invoke(Request $request, GuestType $guestType)
    {
        if (SessionPresenceIsKnownAction::execute($request)) {
            return redirect()->route('questions', ['guestType' => $guestType]);
        }

        $guestType->load('availableGuests', 'events');

        return Inertia::render('absent-page', [
            'guestType' => new GuestTypeResource($guestType),
        ]);
    }
}

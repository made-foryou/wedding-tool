<?php

declare(strict_types=1);

namespace App\Http\Controllers\Invite;

use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\Actions\SessionPresenceIsKnownAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guests\GuestTypeResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PresentPageController extends Controller
{
    public function __invoke(Request $request, GuestType $guestType): Response|RedirectResponse
    {
        if (SessionPresenceIsKnownAction::execute($request)) {
            return redirect()->route('questions', ['guestType' => $guestType]);
        }

        $guestType->load('availableGuests', 'guests', 'events');

        return Inertia::render('present-page', [
            'guestType' => new GuestTypeResource($guestType),
        ]);
    }
}

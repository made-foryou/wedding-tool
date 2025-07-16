<?php

declare(strict_types=1);

namespace App\Http\Controllers\Invite;

use App\Domains\Guests\Models\GuestType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Guests\GuestTypeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresentPageController extends Controller
{
    public function __invoke(Request $request, GuestType $guestType): \Inertia\Response
    {
        $guestType->load('guests');

        return Inertia::render('present-page', [
            'guestType' => new GuestTypeResource($guestType),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Invite;

use App\Domains\Guests\Models\Guest;
use App\Domains\Guests\Models\GuestType;
use App\Domains\Presence\Models\Event;
use App\Domains\Question\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\Guests\GuestResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuestionsPageController extends Controller
{
    public function __invoke(Request $request, GuestType $guestType): Response|RedirectResponse
    {
        if (empty($request->session()->get('guests'))) {
            return to_route('invite', ['guestType' => $guestType]);
        }

        $questions = Question::query()
            ->with(['questionType', 'event', 'guestType'])
            ->where(function ($query) use ($guestType) {
                $query->whereNull('guest_type_id')
                    ->orWhere('guest_type_id', $guestType->id);
            })
            ->orderBy('index')
            ->get();

        $selectedGuests = Guest::query()
            ->whereIn('uuid', $request->session()->get('guests'))
            ->get();

        return Inertia::render('questions-page', [
            'questions' => QuestionResource::collection($questions),
            'events' => EventResource::collection(Event::query()->get()),
            'guests' => GuestResource::collection($selectedGuests),
        ]);
    }
}

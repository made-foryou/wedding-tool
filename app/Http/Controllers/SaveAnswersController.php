<?php

namespace App\Http\Controllers;

use App\Domains\Guests\Models\Guest;
use App\Domains\Question\Models\Question;
use App\Mail\PresentConfirmationMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SaveAnswersController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|JsonResponse
    {
        if (empty($request->session()->get('guests'))) {
            return to_route('invite');
        }

        $guests = Guest::query()
            ->whereIn('uuid', $request->session()->get('guests'))
            ->get();

        /** @var Collection<Question> $questions */
        $questions = Question::query()->get();

        $guests->each(function (Guest $guest) use ($request, $questions) {

            if ($request->has($guest->uuid.':email')) {
                $guest->email = $request->get($guest->uuid.':email');
                $guest->save();
            }

            foreach ($questions as $question) {
                if (! $request->has($guest->uuid.':'.$question->uuid)) {
                    continue;
                }

                $answer = $request->get($guest->uuid.':'.$question->uuid);

                DB::table('guest_question_answers')->updateOrInsert(
                    ['guest_id' => $guest->id, 'question_id' => $question->id],
                    [
                        'answer' => is_array($answer) ? json_encode($answer) : $answer,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            Mail::to($guest->email)
                ->send(new PresentConfirmationMail($guest));
        });

        return response()->json([]);
    }
}

<?php

namespace App\Domains\Presence\Actions;

use App\Domains\Guests\Models\Guest;
use Illuminate\Http\Request;

final readonly class SessionPresenceIsKnownAction
{
    public static function execute(Request $request): bool
    {
        return (new self)->run($request);
    }

    public function run(Request $request): bool
    {
        if (empty($request->session()->get('guests'))) {
            return false;
        }

        $uuids = $request->session()->get('guests');
        $guests = Guest::query()
            ->whereIn('uuid', $uuids)
            ->whereHas('events')
            ->get();

        return count($uuids) === $guests->count();
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Invite;

use App\Domains\Guests\Models\GuestType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbsentPageController extends Controller
{
    public function __invoke(Request $request, GuestType $guestType)
    {
        dd('ABSENTIO');
    }
}

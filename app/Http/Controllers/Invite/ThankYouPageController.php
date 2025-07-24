<?php

namespace App\Http\Controllers\Invite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ThankYouPageController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('thank-you-page');
    }
}

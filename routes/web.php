<?php

use App\Http\Controllers\Invite;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::prefix('{guestType:name}')->group(function () {

    Route::get('/', Invite\InviteController::class)
        ->name('invite');

    Route::get('/present', Invite\PresentPageController::class)
        ->name('present');

    Route::get('/absent', Invite\AbsentPageController::class)
        ->name('absent');
});

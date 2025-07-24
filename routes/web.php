<?php

use App\Http\Controllers\Invite;
use App\Http\Controllers\Presence\SavePresenceController;
use App\Http\Controllers\SaveAnswersController;
use Illuminate\Support\Facades\Route;

Route::prefix('{guestType:name}')->group(function () {

    Route::get('/', Invite\InviteController::class)
        ->name('invite');

    Route::get('/bio', Invite\BioPageController::class)
        ->name('bio');

    Route::get('/present', Invite\PresentPageController::class)
        ->name('present');

    Route::get('/absent', Invite\AbsentPageController::class)
        ->name('absent');

    Route::get('/questions', Invite\QuestionsPageController::class)
        ->name('questions');

    Route::get('/thank-you', Invite\ThankYouPageController::class)
        ->name('thank-you');
});

Route::prefix('api')->group(function () {
    Route::post('save-presence', SavePresenceController::class);

    Route::post('save-answers', SaveAnswersController::class);
});

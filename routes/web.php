<?php

use App\Http\Controllers\OralController;
use App\Http\Controllers\PosterController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Reference\CriteriaController;
use App\Http\Controllers\Reference\JudgesController;
use App\Http\Controllers\Reference\ParticipantsController;
use App\Http\Controllers\Reference\RoundController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz');
    Route::get('/quiz/view-details', [QuizController::class, 'viewDetails'])->name('quiz.view-details');

    Route::get('/oral', [OralController::class, 'index'])->name('oral');
    Route::get('/poster', [PosterController::class, 'index'])->name('poster');

    /* -------------------------------- Reference ------------------------------- */
    Route::get('/reference/criteria', [CriteriaController::class, 'index'])->name('reference.criteria');
    Route::get('/reference/judges', [JudgesController::class, 'index'])->name('reference.judges');
    Route::get('/reference/participants', [ParticipantsController::class, 'index'])->name('reference.participants');
    Route::get('/reference/round', [RoundController::class, 'index'])->name('reference.round');
    /* -------------------------------- Reference ------------------------------- */
});

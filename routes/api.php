<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [ApiController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/upload-database', [ApiController::class, 'saveData']);
    Route::get('/get-reference', [ApiController::class, 'getReference']);
    Route::get('/download-database', [ApiController::class, 'downloadDatabase']);
});

<?php

use App\Domains\Auth\Controllers\LoginUserController;
use App\Domains\Auth\Controllers\RegisteredUserController;
use App\Domains\Photo\Controllers\ApiPhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', LoginUserController::class)->name('login');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1/photos',
], function () {
    Route::resource('/', ApiPhotoController::class)
        ->except(['index', 'show'])
        ->middleware('auth:sanctum');

    Route::get('/', [ApiPhotoController::class, 'index']);
    Route::get('/{id}', [ApiPhotoController::class, 'show']);
});

<?php

use App\Domains\Auth\Controllers\LoginUserController;
use App\Domains\Auth\Controllers\RegisteredUserController;
use App\Domains\LikePhoto\Controllers\LikePhotoController;
use App\Domains\Photo\Controllers\ApiPhotoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', LoginUserController::class)->name('login');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return new \App\Domains\User\Resources\UserResource($request->user());
});

Route::group([
    'prefix' => 'v1/photos',
], function () {
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function(){
        Route::resource('/', ApiPhotoController::class)
            ->parameter('', 'id')
            ->except(['index', 'show']);

        Route::post('{id}/like', [LikePhotoController::class, 'like']);
        Route::post('{id}/unlike', [LikePhotoController::class, 'unlike']);
    });

    Route::get('/', [ApiPhotoController::class, 'index']);
    Route::get('/{id}', [ApiPhotoController::class, 'show']);
});

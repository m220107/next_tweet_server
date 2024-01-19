<?php

use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RegistUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//ルーティングのURL：「/api/xxxx」
// TweetController
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tweet/get', [TweetController::class, 'get']);
    Route::post('/tweet/add', [TweetController::class, 'add']);
});

Route::post('/regist/store', [RegistUserController::class, 'store']);


// AuthController
Route::post('/auth', [AuthController::class, 'auth']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/posts', App\Http\Controllers\Api\PostController::class);

Route::apiResource('/editions', App\Http\Controllers\Api\EdtionController::class);

Route::apiResource('/bulletins', App\Http\Controllers\Api\BulletinController::class);

Route::apiResource('/events', App\Http\Controllers\Api\EventController::class);

Route::apiResource('/news', App\Http\Controllers\Api\NewsController::class);
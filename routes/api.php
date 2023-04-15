<?php

use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Frontsite\MusicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('music/search', [MusicController::class, 'search']);
Route::post('content', [ContentController::class, 'store']);
Route::put('content', [ContentController::class, 'update']);
Route::delete('content', [ContentController::class, 'destroy']);
Route::get('content/{id}', [ContentController::class, 'show']);

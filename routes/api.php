<?php

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

Route::prefix('auth')->group(static function() {
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
});

Route::prefix('repositories')->middleware('auth:api')->group(static function() {
    Route::get('/', [App\Http\Controllers\RepositoryController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\RepositoryController::class, 'show'])->whereNumber('id');
});

Route::prefix('tags')->middleware('auth:api')->group(static function() {
    Route::get('/', [App\Http\Controllers\TagController::class, 'index']);
    Route::post('/assign', [App\Http\Controllers\TagController::class, 'assign']);
    Route::delete('/remove', [App\Http\Controllers\TagController::class, 'remove']);
});

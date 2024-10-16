<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::any('latest', [PostController::class, 'index']);
        Route::post('search', [PostController::class, 'search']);
        Route::any('category/{id}', [PostController::class, 'getPostsByCategory']);
        Route::any('location/{id}', [PostController::class, 'getPostsByLocation']);
    });
    Route::prefix('posts')->group(function () {
        Route::any('latest', [PostController::class, 'index']);
        Route::post('search', [PostController::class, 'search']);
        Route::any('category/{id}', [PostController::class, 'getPostsByCategory']);
        Route::any('location/{id}', [PostController::class, 'getPostsByLocation']);
    });
});

<?php
use App\Http\Controllers\Api\UserSessionController;

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
Route::prefix('security')->group(function () {
    Route::post('/session-check/{userId}', [UserSessionController::class, 'handleLoginSecurity']);
    Route::get('/sessions/{userId}', [UserSessionController::class, 'getUserSessions']);
});
Route::middleware('auth:sanctum')->post('/session/store', [UserSessionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/sessions/{userId}', [UserSessionController::class, 'getSessions']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


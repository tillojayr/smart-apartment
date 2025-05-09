<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\SwitchController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChartDataController;
use App\Http\Middleware\EnsureApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1/room')->middleware([EnsureApiToken::class])->group(function () {
    Route::post('/save', [DataController::class, 'index']);
    Route::post('/switch', [SwitchController::class, 'index']);
    Route::get('/state', [SwitchController::class, 'state']);
    Route::post('/reminder-time', [DataController::class, 'reminderTime']);
    Route::get('/reminder-time/{id}', [DataController::class, 'getReminderTime']);
    Route::get('/all-state', [SwitchController::class, 'allState']);
});

Route::prefix('v1/user')->group(function () {
    Route::get('/owner', [UserController::class, 'owner']);
    Route::get('/tenant', [UserController::class, 'tenant']);
});

// Route::post('/test', [DataController::class, 'test']);
Route::get('/chart-data', [ChartDataController::class, 'getChartData']);

Route::middleware('auth:sanctum')->group(function () {
});

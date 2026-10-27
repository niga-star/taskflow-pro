<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'TaskFlow Pro API',
        'author' => 'niga-star',
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Authentication routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\MeController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\JournalController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class)->name('health');

Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');

Route::prefix('auth')->as('auth.')->group(function (): void {
    Route::post('/register', RegisterController::class)->middleware('throttle:10,1')->name('register');
    Route::post('/login', LoginController::class)->middleware('throttle:5,1')->name('login');
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum')->name('logout');
    Route::get('/me', MeController::class)->middleware('auth:sanctum')->name('me');
});

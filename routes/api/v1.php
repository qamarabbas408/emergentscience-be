<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\LogoutController;
use App\Http\Controllers\Api\V1\Auth\MeController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\ArticleTypeController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\JournalController;
use App\Http\Controllers\Api\V1\TopicController;
use App\Http\Controllers\Api\V1\DisciplineCategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/health', HealthController::class)->name('health');

Route::middleware('throttle:60,1')->group(function (): void {
    Route::get('/article-types', ArticleTypeController::class)->name('article-types.index');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

    Route::get('/discipline-categories', [DisciplineCategoryController::class, 'index'])->name('discipline-categories.index');
    Route::get('/discipline-categories/{category}', [DisciplineCategoryController::class, 'show'])->name('discipline-categories.show');
    Route::get('/discipline-categories/{category}/journals', [DisciplineCategoryController::class, 'journals'])->name('discipline-categories.journals');

    Route::get('/journals', [JournalController::class, 'index'])->name('journals.index');
    Route::get('/journals/{journal}', [JournalController::class, 'show'])->name('journals.show');
    Route::get('/journals/{journal}/articles', [ArticleController::class, 'byJournal'])->name('journals.articles.index');
    Route::get('/journals/{journal}/topics', [TopicController::class, 'index'])->name('journals.topics.index');
    Route::get('/journals/{journal}/topics/{topic}', [TopicController::class, 'show'])->name('journals.topics.show');

    Route::get('/topics', [TopicController::class, 'indexAll'])->name('topics.index');
    Route::get('/topics/{topic}', [TopicController::class, 'showBySlug'])->name('topics.show');
    Route::get('/topics/{topic}/articles', [ArticleController::class, 'byTopic'])->name('topics.articles.index');
});

Route::prefix('auth')->as('auth.')->group(function (): void {
    Route::post('/register', RegisterController::class)->middleware('throttle:10,1')->name('register');
    Route::post('/login', LoginController::class)->middleware('throttle:5,1')->name('login');
    Route::post('/logout', LogoutController::class)->middleware('auth:sanctum')->name('logout');
    Route::get('/me', MeController::class)->middleware('auth:sanctum')->name('me');
});

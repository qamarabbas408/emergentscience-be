<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('landing'));

if (app()->environment('local')) {
    Route::get('/docs/api/export', fn () => response()->file(public_path('docs/api-export/export.html')));
}

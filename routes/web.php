<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): JsonResponse => response()->json([
    'name' => 'Emerging Science API',
    'version' => app()->version(),
    'docs' => '/docs/api',
    'status' => 'ok',
]));

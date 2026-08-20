<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ArticleType;
use Illuminate\Http\JsonResponse;

class ArticleTypeController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function __invoke(): JsonResponse
    {
        $types = ArticleType::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['slug', 'name']);

        return $this->success($types);
    }
}

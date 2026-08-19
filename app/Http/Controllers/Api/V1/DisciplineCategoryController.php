<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DisciplineCategoryResource;
use App\Http\Resources\V1\JournalResource;
use App\Models\DisciplineCategory;
use Illuminate\Http\JsonResponse;

class DisciplineCategoryController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function index(): JsonResponse
    {
        $categories = DisciplineCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return $this->success(DisciplineCategoryResource::collection($categories));
    }

    public function show(DisciplineCategory $category): JsonResponse
    {
        abort_if(! $category->is_active, 404);

        return $this->success(new DisciplineCategoryResource($category));
    }

    public function journals(DisciplineCategory $category): JsonResponse
    {
        abort_if(! $category->is_active, 404);

        $journals = $category->journals()
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return $this->success(JournalResource::collection($journals));
    }
}

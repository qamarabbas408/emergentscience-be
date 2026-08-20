<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DisciplineCategoryResource;
use App\Http\Resources\V1\JournalResource;
use App\Models\DisciplineCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    public function journals(DisciplineCategory $category, Request $request): JsonResponse
    {
        abort_if(! $category->is_active, 404);

        $query = $category->journals()
            ->where('is_active', true)
            ->orderBy('title');

        $include = array_filter(explode(',', $request->input('include', '')));
        if (in_array('topics', $include)) {
            $query->with('topics');
        }

        $journals = $query->get();

        return $this->success(JournalResource::collection($journals));
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JournalResource;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Journal::query()
            ->with('disciplineCategories')
            ->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abbreviation', 'like', "%{$search}%")
                    ->orWhere('scope', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('disciplineCategories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $sort = $request->input('sort', 'title');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['title', 'created_at', 'updated_at'];
        if (in_array($column, $allowed)) {
            $query->orderBy($column, $direction);
        } else {
            $query->orderBy('title', 'asc');
        }

        $perPage = min((int) $request->input('per_page', 12), 50);
        $journals = $query->paginate($perPage);

        return $this->paginated(
            JournalResource::collection($journals->items()),
            [
                'current_page' => $journals->currentPage(),
                'last_page' => $journals->lastPage(),
                'per_page' => $journals->perPage(),
                'total' => $journals->total(),
            ],
        );
    }

    public function show(Journal $journal): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $journal->load('disciplineCategories');

        return $this->success(new JournalResource($journal));
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JournalResource;
        use App\Models\DisciplineCategory;
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
            ->withCount('articles', 'topics')
            ->where('is_active', true);

        $include = array_filter(explode(',', $request->input('include', '')));
        if (in_array('topics', $include)) {
            $query->with('topics');
        }

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

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $journals = $query->paginate($perPage);

        $facets = [
            'discipline_categories' => $this->buildDisciplineFacets($request),
        ];

        return $this->paginated(
            JournalResource::collection($journals->items()),
            [
                'current_page' => $journals->currentPage(),
                'last_page' => $journals->lastPage(),
                'per_page' => $journals->perPage(),
                'total' => $journals->total(),
            ],
            facets: $facets
        );
    }

    public function show(Journal $journal, Request $request): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $relations = ['disciplineCategories'];
        $include = array_filter(explode(',', $request->input('include', '')));
        if (in_array('topics', $include)) {
            $relations[] = 'topics';
        }
        $journal->load($relations);
        $journal->loadCount('articles', 'topics');

        return $this->success(new JournalResource($journal));
    }

    private function buildDisciplineFacets(Request $request): array
    {
        $categorySlug = $request->filled('category') ? $request->input('category') : null;

        $baseQuery = Journal::query()->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $baseQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abbreviation', 'like', "%{$search}%")
                    ->orWhere('scope', 'like', "%{$search}%");
            });
        }

        $allCategories = DisciplineCategory::query()->orderBy('name')->get();

        return $allCategories->map(function ($cat) use ($baseQuery) {
            $count = (clone $baseQuery)
                ->whereHas('disciplineCategories', fn ($q) => $q->where('slug', $cat->slug))
                ->count();

            return [
                'id' => $cat->id,
                'slug' => $cat->slug,
                'name' => $cat->name,
                'count' => $count,
            ];
        })->values()->all();
    }
}

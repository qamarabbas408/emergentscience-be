<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TopicResource;
use App\Models\DisciplineCategory;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function indexAll(Request $request): JsonResponse
    {
        $query = Topic::query()
            ->with('journals')
            ->withCount('articles')
            ->where('topics.is_active', true);

        $this->applyFilters($query, $request);

        $perPage = max(1, min((int) $request->input('per_page', 50), 100));
        $topics = $query->orderBy('topics.sort_order')
            ->orderBy('topics.title')
            ->paginate($perPage);

        $facets = $this->buildFacets($request);

        return $this->paginated(
            TopicResource::collection($topics->items()),
            [
                'current_page' => $topics->currentPage(),
                'last_page' => $topics->lastPage(),
                'per_page' => $topics->perPage(),
                'total' => $topics->total(),
            ],
            facets: $facets
        );
    }

    public function showBySlug(Topic $topic): JsonResponse
    {
        abort_if(! $topic->is_active, 404);

        $topic->load('journals');

        return $this->success(new TopicResource($topic));
    }

    public function index(Journal $journal): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $topics = Topic::query()
            ->whereHas('journals', fn ($q) => $q->where('journals.id', $journal->id))
            ->where('topics.is_active', true)
            ->orderBy('topics.sort_order')
            ->orderBy('topics.title')
            ->get();

        return $this->success(TopicResource::collection($topics));
    }

    public function show(Journal $journal, Topic $topic): JsonResponse
    {
        abort_if(! $journal->is_active, 404);
        abort_if(! $topic->is_active, 404);
        abort_if(! $topic->journals->contains('id', $journal->id), 404);

        return $this->success(new TopicResource($topic));
    }

    private function parseSlugs(?string $value): ?array
    {
        if (! $value) {
            return null;
        }

        $slugs = array_filter(array_map('trim', explode(',', $value)));

        return $slugs ?: null;
    }

    private function applyFilters(Builder $query, Request $request): void
    {
        if ($journalSlugs = $this->parseSlugs($request->input('journal'))) {
            $query->whereHas('journals', fn ($q) => $q->whereIn('slug', $journalSlugs));
        }

        if ($disciplineSlugs = $this->parseSlugs($request->input('discipline'))) {
            $query->whereHas('journals', fn ($q) => $q->whereHas(
                'disciplineCategories',
                fn ($dq) => $dq->whereIn('slug', $disciplineSlugs),
            ));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('topics.title', 'like', "%{$search}%")
                    ->orWhere('topics.description', 'like', "%{$search}%");
            });
        }
    }

    private function buildFacets(Request $request): array
    {
        $disciplineSlugs = $this->parseSlugs($request->input('discipline'));

        // Discipline facets: apply all filters EXCEPT discipline. Use LEFT JOIN so
        // disciplines with zero matching topics still appear with count: 0.
        // Active-topic + search conditions are in JOIN clauses to preserve LEFT JOIN semantics.
        $disciplineCounts = DisciplineCategory::query()
            ->leftJoin('discipline_category_journal', 'discipline_category_journal.discipline_category_id', '=', 'discipline_categories.id')
            ->leftJoin('journals', 'discipline_category_journal.journal_id', '=', 'journals.id')
            ->leftJoin('journal_topics', 'journals.id', '=', 'journal_topics.journal_id')
            ->leftJoin('topics', function ($join) use ($request) {
                $join->on('journal_topics.topic_id', '=', 'topics.id')
                    ->where('topics.is_active', true);

                if ($request->filled('search')) {
                    $search = $request->input('search');
                    $join->where(function ($sq) use ($search) {
                        $sq->where('topics.title', 'like', "%{$search}%")
                            ->orWhere('topics.description', 'like', "%{$search}%");
                    });
                }
            })
            ->when($this->parseSlugs($request->input('journal')), function ($q) use ($request) {
                $journalSlugs = $this->parseSlugs($request->input('journal'));
                $q->whereIn('journals.slug', $journalSlugs);
            })
            ->selectRaw('discipline_categories.id as id, discipline_categories.slug as slug, discipline_categories.name as dname, COUNT(DISTINCT topics.id) as count')
            ->groupBy('discipline_categories.id', 'discipline_categories.slug', 'discipline_categories.name')
            ->orderByDesc('count')
            ->get();

        $disciplines = $disciplineCounts->map(fn ($d) => [
            'id' => $d->id,
            'slug' => $d->slug,
            'name' => $d->dname,
            'count' => (int) $d->count,
        ])->sortByDesc('count')->values();

        return [
            'discipline_categories' => $disciplines,
        ];
    }
}

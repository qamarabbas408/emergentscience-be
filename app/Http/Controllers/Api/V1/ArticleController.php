<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ArticleResource;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function index(Request $request): JsonResponse
    {
        $query = Article::query()
            ->with(['journal', 'articleType', 'topics'])
            ->where('status', 'published');

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        $facets = $this->buildFacets($request);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
            facets: $facets,
        );
    }

    public function byJournal(Journal $journal, Request $request): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $query = Article::query()
            ->with(['articleType', 'topics'])
            ->where('journal_id', $journal->id)
            ->where('status', 'published');

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        $facets = $this->buildFacets($request, journalId: $journal->id);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
            facets: $facets,
        );
    }

    public function byTopic(Topic $topic, Request $request): JsonResponse
    {
        $query = Article::query()
            ->with(['journal', 'articleType', 'topics'])
            ->where('status', 'published')
            ->whereHas('topics', fn ($q) => $q->where('topics.id', $topic->id));

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        $facets = $this->buildFacets($request, topicId: $topic->id);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
            facets: $facets,
        );
    }

    public function show(Article $article): JsonResponse
    {
        abort_if($article->status !== 'published', 404);

        $article->load(['journal', 'articleType', 'topics', 'authors']);

        return $this->success(new ArticleResource($article));
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
            $query->whereHas('journal', fn ($q) => $q->whereIn('slug', $journalSlugs));
        }

        if ($request->filled('topic')) {
            $query->whereHas('topics', fn ($q) => $q->where('slug', $request->input('topic')));
        }

        if ($typeSlugs = $this->parseSlugs($request->input('type'))) {
            $query->whereHas('articleType', fn ($q) => $q->whereIn('slug', $typeSlugs));
        }

        if ($request->filled('published_from')) {
            $query->where('publication_date', '>=', $request->input('published_from'));
        }

        if ($request->filled('published_to')) {
            $query->where('publication_date', '<=', $request->input('published_to'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('abstract', 'like', "%{$search}%")
                    ->orWhere('doi', 'like', "%{$search}%");
            });
        }
    }

    private function applySort(Builder $query, Request $request): void
    {
        $sort = $request->input('sort', '-publication_date');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['title', 'publication_date', 'citation_count', 'view_count', 'created_at'];
        $query->orderBy(in_array($column, $allowed) ? $column : 'publication_date', $direction);
    }

    private function buildFacets(
        Request $request,
        ?int $journalId = null,
        ?int $topicId = null,
    ): array {
        $baseFilters = function (Builder $q) use ($request, $journalId, $topicId): void {
            $q->where('status', 'published');

            if ($journalId) {
                $q->where('journal_id', $journalId);
            }

            if ($topicId) {
                $q->whereHas('topics', fn ($tq) => $tq->where('topics.id', $topicId));
            }

            if ($request->filled('published_from')) {
                $q->where('publication_date', '>=', $request->input('published_from'));
            }

            if ($request->filled('published_to')) {
                $q->where('publication_date', '<=', $request->input('published_to'));
            }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $q->where(function ($sq) use ($search) {
                $sq->where('articles.title', 'like', "%{$search}%")
                    ->orWhere('articles.abstract', 'like', "%{$search}%")
                    ->orWhere('articles.doi', 'like', "%{$search}%");
            });
            }
        };

        $journalSlugs = $this->parseSlugs($request->input('journal'));
        $typeSlugs = $this->parseSlugs($request->input('type'));

        // Journal facets: apply all filters EXCEPT journal
        $journalCounts = Article::query()
            ->join('journals', 'articles.journal_id', '=', 'journals.id')
            ->where($baseFilters)
            ->when(! $journalId && ! $journalSlugs, function ($q) use ($request, $typeSlugs) {
                if ($request->filled('topic')) {
                    $q->whereHas('topics', fn ($tq) => $tq->where('slug', $request->input('topic')));
                }
                if ($typeSlugs) {
                    $q->whereHas('articleType', fn ($tq) => $tq->whereIn('slug', $typeSlugs));
                }
            })
            ->when($journalId, function ($q) use ($request, $typeSlugs) {
                if ($request->filled('topic')) {
                    $q->whereHas('topics', fn ($tq) => $tq->where('slug', $request->input('topic')));
                }
                if ($typeSlugs) {
                    $q->whereHas('articleType', fn ($tq) => $tq->whereIn('slug', $typeSlugs));
                }
            })
            ->selectRaw('journals.id as id, journals.slug as slug, journals.title as jtitle, COUNT(*) as count')
            ->groupBy('journals.id', 'journals.slug', 'journals.title')
            ->orderByDesc('count')
            ->get();

        $journals = $journalCounts->map(fn ($j) => [
            'id' => $j->id,
            'slug' => $j->slug,
            'title' => $j->jtitle,
            'count' => (int) $j->count,
        ])->sortByDesc('count')->values();

        // Article type facets: apply all filters EXCEPT type
        $typeCounts = Article::query()
            ->join('article_types', 'articles.article_type_id', '=', 'article_types.id')
            ->where($baseFilters)
            ->when(! $typeSlugs, function ($q) use ($request, $journalId, $journalSlugs) {
                if ($journalId) {
                    $q->where('articles.journal_id', $journalId);
                } elseif ($journalSlugs) {
                    $q->whereHas('journal', fn ($tq) => $tq->whereIn('slug', $journalSlugs));
                }
                if ($request->filled('topic')) {
                    $q->whereHas('topics', fn ($tq) => $tq->where('slug', $request->input('topic')));
                }
            })
            ->when($journalId, function ($q) use ($request) {
                if ($request->filled('topic')) {
                    $q->whereHas('topics', fn ($tq) => $tq->where('slug', $request->input('topic')));
                }
            })
            ->selectRaw('article_types.id as id, article_types.slug as slug, article_types.name as tname, COUNT(*) as count')
            ->groupBy('article_types.id', 'article_types.slug', 'article_types.name')
            ->orderByDesc('count')
            ->get();

        $articleTypes = $typeCounts->map(fn ($t) => [
            'id' => $t->id,
            'slug' => $t->slug,
            'name' => $t->tname,
            'count' => (int) $t->count,
        ])->sortByDesc('count')->values();

        return [
            'journals' => $journals,
            'article_types' => $articleTypes,
        ];
    }
}

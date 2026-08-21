<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ArticleResource;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Topic;
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

        if ($request->filled('journal')) {
            $query->whereHas('journal', fn ($q) => $q->where('slug', $request->input('journal')));
        }

        if ($request->filled('topic')) {
            $query->whereHas('topics', fn ($q) => $q->where('slug', $request->input('topic')));
        }

        if ($request->filled('type')) {
            $query->whereHas('articleType', fn ($q) => $q->where('slug', $request->input('type')));
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

        $sort = $request->input('sort', '-publication_date');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['title', 'publication_date', 'citation_count', 'view_count', 'created_at'];
        $query->orderBy(in_array($column, $allowed) ? $column : 'publication_date', $direction);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        );
    }

    public function byJournal(Journal $journal, Request $request): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $query = Article::query()
            ->with(['articleType', 'topics'])
            ->where('journal_id', $journal->id)
            ->where('status', 'published');

        if ($request->filled('topic')) {
            $query->whereHas('topics', fn ($q) => $q->where('slug', $request->input('topic')));
        }

        if ($request->filled('type')) {
            $query->whereHas('articleType', fn ($q) => $q->where('slug', $request->input('type')));
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
                    ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', '-publication_date');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['title', 'publication_date', 'citation_count', 'view_count', 'created_at'];
        $query->orderBy(in_array($column, $allowed) ? $column : 'publication_date', $direction);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        );
    }

    public function byTopic(Topic $topic, Request $request): JsonResponse
    {
        $query = Article::query()
            ->with(['journal', 'articleType', 'topics'])
            ->where('status', 'published')
            ->whereHas('topics', fn ($q) => $q->where('topics.id', $topic->id));

        if ($request->filled('type')) {
            $query->whereHas('articleType', fn ($q) => $q->where('slug', $request->input('type')));
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
                    ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        $sort = $request->input('sort', '-publication_date');
        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $allowed = ['title', 'publication_date', 'citation_count', 'view_count', 'created_at'];
        $query->orderBy(in_array($column, $allowed) ? $column : 'publication_date', $direction);

        $perPage = max(1, min((int) $request->input('per_page', 12), 50));
        $articles = $query->paginate($perPage);

        return $this->paginated(
            ArticleResource::collection($articles->items()),
            [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        );
    }

    public function show(Article $article): JsonResponse
    {
        abort_if($article->status !== 'published', 404);

        $article->load(['journal', 'articleType', 'topics', 'authors']);

        return $this->success(new ArticleResource($article));
    }
}

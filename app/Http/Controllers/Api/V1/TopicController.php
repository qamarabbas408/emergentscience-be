<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TopicResource;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function indexAll(Request $request): JsonResponse
    {
        $query = Topic::query()
            ->with('journal')
            ->where('is_active', true);

        if ($request->filled('journal')) {
            $query->whereHas('journal', fn ($q) => $q->where('slug', $request->input('journal')));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $topics = $query->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return $this->success(TopicResource::collection($topics));
    }

    public function showBySlug(Topic $topic): JsonResponse
    {
        abort_if(! $topic->is_active, 404);

        $topic->load('journal');

        return $this->success(new TopicResource($topic));
    }

    public function index(Journal $journal): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $topics = Topic::query()
            ->where('journal_id', $journal->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return $this->success(TopicResource::collection($topics));
    }

    public function show(Journal $journal, Topic $topic): JsonResponse
    {
        abort_if(! $journal->is_active, 404);
        abort_if($topic->journal_id !== $journal->id, 404);
        abort_if(! $topic->is_active, 404);

        return $this->success(new TopicResource($topic));
    }
}

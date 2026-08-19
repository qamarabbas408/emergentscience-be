<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TopicResource;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Http\JsonResponse;

class TopicController extends Controller
{
    public function index(Journal $journal): JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $topics = Topic::query()
            ->where('journal_id', $journal->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return response()->json([
            'data' => TopicResource::collection($topics),
        ]);
    }

    public function show(Journal $journal, Topic $topic): JsonResponse
    {
        abort_if(! $journal->is_active, 404);
        abort_if($topic->journal_id !== $journal->id, 404);
        abort_if(! $topic->is_active, 404);

        return response()->json([
            'data' => new TopicResource($topic),
        ]);
    }
}

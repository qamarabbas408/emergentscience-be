<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\JournalResource;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;

class JournalController extends Controller
{
    public function index(): JsonResponse
    {
        $journals = Journal::query()
            ->with('disciplineCategories')
            ->where('is_active', true)
            ->orderBy('title')
            ->get();

        return response()->json([
            'data' => JournalResource::collection($journals),
        ]);
    }

    public function show(Journal $journal): JournalResource|JsonResponse
    {
        abort_if(! $journal->is_active, 404);

        $journal->load('disciplineCategories');

        return new JournalResource($journal);
    }
}

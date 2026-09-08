<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateAuthorProfileRequest;
use App\Models\AuthorProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    use ApiResponse;

    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = AuthorProfile::firstOrCreate(['user_id' => $user->id]);

        return $this->success([
            'corresponding_email' => $profile->corresponding_email ?? $user->email,
            'department' => $profile->department,
            'research_interests' => $profile->research_interests ?? [],
            'funding_sources' => $profile->funding_sources ?? [],
            'co_author_history' => $profile->co_author_history ?? [],
        ]);
    }

    public function update(UpdateAuthorProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $profile = AuthorProfile::firstOrCreate(['user_id' => $user->id]);
        $profile->update($data);

        return $this->success([
            'corresponding_email' => $profile->corresponding_email ?? $user->email,
            'department' => $profile->department,
            'research_interests' => $profile->research_interests ?? [],
            'funding_sources' => $profile->funding_sources ?? [],
            'co_author_history' => $profile->co_author_history ?? [],
        ], 'Author profile updated successfully.');
    }
}

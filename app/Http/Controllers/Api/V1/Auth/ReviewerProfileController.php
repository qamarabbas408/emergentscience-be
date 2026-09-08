<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateReviewerProfileRequest;
use App\Models\ReviewerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewerProfileController extends Controller
{
    use ApiResponse;

    public function show(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = ReviewerProfile::where('user_id', $user->id)->first();

        if (! $profile) {
            return $this->error('Reviewer profile not found.', 404);
        }

        return $this->success([
            'reviewer_status' => $profile->reviewer_status,
            'metrics' => [
                'rating_score' => $profile->rating_score,
                'total_reviews_completed' => $profile->total_reviews_completed,
                'average_review_time_days' => $profile->average_review_time_days,
            ],
            'expertise_keywords' => $profile->expertise_keywords ?? [],
            'review_availability_status' => $profile->review_availability_status,
            'max_concurrent_reviews' => $profile->max_concurrent_reviews,
        ]);
    }

    public function update(UpdateReviewerProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $profile = ReviewerProfile::where('user_id', $user->id)->first();

        if (! $profile) {
            return $this->error('Reviewer profile not found.', 404);
        }

        $data = $request->validated();
        $profile->update($data);

        return $this->success([
            'reviewer_status' => $profile->reviewer_status,
            'metrics' => [
                'rating_score' => $profile->rating_score,
                'total_reviews_completed' => $profile->total_reviews_completed,
                'average_review_time_days' => $profile->average_review_time_days,
            ],
            'expertise_keywords' => $profile->expertise_keywords ?? [],
            'review_availability_status' => $profile->review_availability_status,
            'max_concurrent_reviews' => $profile->max_concurrent_reviews,
        ], 'Reviewer profile updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ReviewerProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RequestReviewerController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasRole('reviewer')) {
            return $this->error('You are already a reviewer.', 422);
        }

        $validated = $request->validate([
            'expertise_keywords' => ['required', 'array', 'min:1'],
            'expertise_keywords.*' => ['string', 'max:255'],
        ]);

        $profile = ReviewerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'expertise_keywords' => $validated['expertise_keywords'],
                'review_availability_status' => 'Available',
                'max_concurrent_reviews' => 5,
                'reviewer_status' => 'pending',
            ],
        );

        return $this->created([
            'message' => 'Reviewer request submitted. Pending admin approval.',
            'reviewer_status' => 'pending',
        ], 'Reviewer request submitted.');
    }
}

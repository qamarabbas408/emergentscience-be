<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ReviewerProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApproveReviewerController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, int $userId, string $action): JsonResponse
    {
        $admin = $request->user();

        if (! $admin->hasRole('admin')) {
            return $this->forbidden('Only admins can approve reviewer requests.');
        }

        if (! in_array($action, ['approve', 'reject'])) {
            return $this->error('Invalid action. Use "approve" or "reject".', 422);
        }

        $user = User::find($userId);

        if (! $user) {
            return $this->notFound('User not found.');
        }

        $profile = ReviewerProfile::where('user_id', $userId)->first();

        if (! $profile) {
            return $this->error('No reviewer request found for this user.', 422);
        }

        if ($profile->reviewer_status !== 'pending') {
            return $this->error('This request has already been processed.', 422);
        }

        $status = $action === 'approve' ? 'approved' : 'rejected';
        $profile->update(['reviewer_status' => $status]);

        if ($action === 'approve') {
            $user->addRole('reviewer');
        }

        return $this->success([
            'message' => "Reviewer request {$status}.",
            'reviewer_status' => $status,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;

class UpdateProfileController extends Controller
{
    use ApiResponse;

    public function __invoke(UpdateProfileRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if (isset($data['first_name']) || isset($data['last_name'])) {
            $firstName = $data['first_name'] ?? $user->first_name;
            $lastName = $data['last_name'] ?? $user->last_name;
            $data['name'] = trim($firstName . ' ' . ($lastName ?? ''));
        }

        $user->update($data);
        $user->refresh();

        return $this->success(new UserResource($user), 'Profile updated successfully.');
    }
}

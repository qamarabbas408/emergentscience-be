<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $user = User::create($request->validated());
        $user->refresh();

        $token = $user->createToken('app')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful.',
            'data' => new UserResource($user),
            'token' => $token,
        ], 201);
    }
}
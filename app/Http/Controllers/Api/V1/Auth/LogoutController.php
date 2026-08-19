<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    use ApiResponse;

    public function __invoke(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->noContent('Logged out successfully.');
    }
}

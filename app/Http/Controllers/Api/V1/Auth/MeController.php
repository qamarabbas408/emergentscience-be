<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    use ApiResponse;

    public function __invoke(): JsonResponse
    {
        return $this->success(new UserResource(auth()->user()));
    }
}

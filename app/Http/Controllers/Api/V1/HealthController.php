<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function __invoke(): JsonResponse
    {
        return $this->success([
            'status' => 'ok',
            'version' => 'v1',
        ]);
    }
}

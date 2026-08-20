<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ArticleTypeController extends Controller
{
    use \App\Http\Controllers\ApiResponse;

    public function __invoke(): JsonResponse
    {
        $types = [
            ['value' => 'research-article', 'label' => 'Research Article'],
            ['value' => 'review', 'label' => 'Review'],
            ['value' => 'systematic-review', 'label' => 'Systematic Review'],
            ['value' => 'meta-analysis', 'label' => 'Meta-Analysis'],
            ['value' => 'brief-report', 'label' => 'Brief Report'],
            ['value' => 'case-report', 'label' => 'Case Report'],
            ['value' => 'editorial', 'label' => 'Editorial'],
            ['value' => 'letter', 'label' => 'Letter'],
            ['value' => 'correction', 'label' => 'Correction'],
            ['value' => 'protocol', 'label' => 'Protocol'],
        ];

        return $this->success($types);
    }
}

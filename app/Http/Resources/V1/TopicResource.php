<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'submission_deadline' => $this->submission_deadline?->format('d F Y'),
            'article_count' => $this->whenCounted('articles'),
            'journals' => $this->whenLoaded('journals', fn () => $this->journals->map(fn ($j) => [
                'id' => $j->id,
                'slug' => $j->slug,
                'title' => $j->title,
                'abbreviation' => $j->abbreviation,
            ])),
        ];
    }
}

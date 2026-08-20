<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'abbreviation' => $this->abbreviation,
            'tagline' => $this->tagline,
            'category' => $this->whenLoaded('disciplineCategories', function () {
                return $this->disciplineCategories->first()?->name;
            }),
            'topics' => $this->whenLoaded('topics', function () {
                return $this->topics->map(fn ($topic) => [
                    'id' => $topic->id,
                    'slug' => $topic->slug,
                    'title' => $topic->title,
                    'description' => $topic->description,
                ]);
            }),
            'is_new' => false,
            'field_chief_editor' => null,
            'sections_count' => 0,
            'articles_count' => 0,
            'views' => 0,
            'citations' => 0,
            'impact_factor' => null,
            'citescore' => null,
        ];
    }
}

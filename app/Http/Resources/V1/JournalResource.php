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
            'issn' => $this->issn,
            'eissn' => $this->eissn,
            'doi_prefix' => $this->doi_prefix,
            'discipline_category_id' => $this->discipline_category_id,
            'discipline_category_name' => $this->whenLoaded('disciplineCategory', fn () => $this->disciplineCategory->name),
            'discipline' => $this->discipline,
            'license' => $this->license,
            'scope' => $this->scope,
            'is_active' => $this->is_active,
        ];
    }
}

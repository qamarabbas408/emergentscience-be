<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'keywords' => $this->keywords,
            'doi' => $this->doi,
            'status' => $this->status,
            'language' => $this->language,
            'volume' => $this->volume,
            'issue' => $this->issue,
            'page_start' => $this->page_start,
            'page_end' => $this->page_end,
            'publication_date' => $this->publication_date?->toDateString(),
            'date_submitted' => $this->date_submitted?->toDateString(),
            'date_accepted' => $this->date_accepted?->toDateString(),
            'view_count' => $this->view_count,
            'download_count' => $this->download_count,
            'citation_count' => $this->citation_count,
            'journal' => $this->whenLoaded('journal', fn () => [
                'id' => $this->journal->id,
                'slug' => $this->journal->slug,
                'title' => $this->journal->title,
                'abbreviation' => $this->journal->abbreviation,
            ]),
            'article_type' => $this->whenLoaded('articleType', fn () => [
                'slug' => $this->articleType->slug,
                'name' => $this->articleType->name,
                'max_word_count' => $this->articleType->max_word_count,
                'max_summary_words' => $this->articleType->max_summary_words,
                'max_figures_tables' => $this->articleType->max_figures_tables,
            ]),
            'topics' => $this->whenLoaded('topics', function () {
                return $this->topics->map(fn ($topic) => [
                    'id' => $topic->id,
                    'slug' => $topic->slug,
                    'title' => $topic->title,
                ]);
            }),
            'authors' => $this->whenLoaded('authors', function () {
                return $this->authors->sortBy('sort_order')->values()->map(fn ($author) => [
                    'name' => $author->name,
                    'email' => $author->email,
                    'orcid' => $author->orcid,
                    'affiliation' => $author->affiliation,
                    'is_corresponding' => $author->is_corresponding,
                ]);
            }),
        ];
    }
}

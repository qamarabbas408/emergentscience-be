<?php

namespace Database\Factories;

use App\Models\ArticleType;
use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(8);

        return [
            'journal_id' => Journal::factory(),
            'article_type_id' => ArticleType::factory(),
            'title' => $title,
            'abstract' => fake()->paragraphs(3, true),
            'keywords' => fake()->words(5),
            'doi' => null,
            'slug' => fake()->slug(),
            'status' => 'draft',
            'language' => 'en',
            'volume' => null,
            'issue' => null,
            'page_start' => null,
            'page_end' => null,
            'publication_date' => null,
            'date_submitted' => null,
            'date_accepted' => null,
            'view_count' => 0,
            'download_count' => 0,
            'citation_count' => 0,
        ];
    }
}

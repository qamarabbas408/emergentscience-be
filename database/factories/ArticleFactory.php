<?php

namespace Database\Factories;

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
            'title' => $title,
            'abstract' => fake()->paragraphs(3, true),
            'keywords' => fake()->words(5),
            'doi' => null,
            'slug' => fake()->slug(),
            'article_type' => fake()->randomElement([
                'research-article', 'review', 'systematic-review', 'meta-analysis',
                'brief-report', 'case-report', 'editorial', 'letter', 'protocol',
            ]),
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

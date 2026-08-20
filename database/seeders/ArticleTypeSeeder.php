<?php

namespace Database\Seeders;

use App\Models\ArticleType;
use Illuminate\Database\Seeder;

class ArticleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['slug' => 'research-article', 'name' => 'Research Article', 'sort_order' => 1],
            ['slug' => 'review', 'name' => 'Review', 'sort_order' => 2],
            ['slug' => 'systematic-review', 'name' => 'Systematic Review', 'sort_order' => 3],
            ['slug' => 'meta-analysis', 'name' => 'Meta-Analysis', 'sort_order' => 4],
            ['slug' => 'brief-report', 'name' => 'Brief Report', 'sort_order' => 5],
            ['slug' => 'case-report', 'name' => 'Case Report', 'sort_order' => 6],
            ['slug' => 'editorial', 'name' => 'Editorial', 'sort_order' => 7],
            ['slug' => 'letter', 'name' => 'Letter', 'sort_order' => 8],
            ['slug' => 'correction', 'name' => 'Correction', 'sort_order' => 9],
            ['slug' => 'protocol', 'name' => 'Protocol', 'sort_order' => 10],
        ];

        foreach ($types as $type) {
            ArticleType::updateOrCreate(
                ['slug' => $type['slug']],
                $type,
            );
        }
    }
}

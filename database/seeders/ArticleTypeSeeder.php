<?php

namespace Database\Seeders;

use App\Models\ArticleType;
use Illuminate\Database\Seeder;

class ArticleTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'slug' => 'research-article',
                'name' => 'Research Article',
                'description' => 'Original research manuscripts reporting scientifically sound experiments with substantial new information.',
                'sort_order' => 1,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 12,
            ],
            [
                'slug' => 'review',
                'name' => 'Review',
                'description' => 'Comprehensive analysis of existing literature, identifying gaps and providing recommendations.',
                'sort_order' => 2,
                'max_word_count' => 15000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
            ],
            [
                'slug' => 'systematic-review',
                'name' => 'Systematic Review',
                'description' => 'Structured review following PRISMA guidelines with explicit methodology.',
                'sort_order' => 3,
                'max_word_count' => 15000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
            ],
            [
                'slug' => 'meta-analysis',
                'name' => 'Meta-Analysis',
                'description' => 'Quantitative statistical analysis combining results from multiple studies.',
                'sort_order' => 4,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 12,
            ],
            [
                'slug' => 'brief-report',
                'name' => 'Brief Report',
                'description' => 'Short research communication presenting preliminary or confirmatory findings.',
                'sort_order' => 5,
                'max_word_count' => 4000,
                'max_summary_words' => 200,
                'max_figures_tables' => 4,
            ],
            [
                'slug' => 'case-report',
                'name' => 'Case Report',
                'description' => 'Detailed report of symptoms, signs, diagnosis, treatment, and follow-up of individual cases.',
                'sort_order' => 6,
                'max_word_count' => 4000,
                'max_summary_words' => 250,
                'max_figures_tables' => 6,
            ],
            [
                'slug' => 'editorial',
                'name' => 'Editorial',
                'description' => 'Opinion piece by editors or invited experts on topics of current interest.',
                'sort_order' => 7,
                'max_word_count' => 3000,
                'max_summary_words' => null,
                'max_figures_tables' => 2,
            ],
            [
                'slug' => 'letter',
                'name' => 'Letter',
                'description' => 'Brief commentary or discussion of recently published articles.',
                'sort_order' => 8,
                'max_word_count' => 2000,
                'max_summary_words' => null,
                'max_figures_tables' => 2,
            ],
            [
                'slug' => 'correction',
                'name' => 'Correction',
                'description' => 'Erratum or corrigendum to previously published articles.',
                'sort_order' => 9,
                'max_word_count' => 1000,
                'max_summary_words' => null,
                'max_figures_tables' => 2,
            ],
            [
                'slug' => 'protocol',
                'name' => 'Protocol',
                'description' => 'Detailed step-by-step description of a research method or study design.',
                'sort_order' => 10,
                'max_word_count' => 8000,
                'max_summary_words' => 350,
                'max_figures_tables' => 8,
            ],
        ];

        foreach ($types as $type) {
            ArticleType::updateOrCreate(
                ['slug' => $type['slug']],
                $type,
            );
        }
    }
}

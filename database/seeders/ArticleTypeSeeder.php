<?php

namespace Database\Seeders;

use App\Models\ArticleType;
use Illuminate\Database\Seeder;

class ArticleTypeSeeder extends Seeder
{
    private static array $fullFiles = [
        'manuscript' => ['enabled' => true, 'max_size_mb' => 50, 'extensions' => ['.doc', '.docx', '.zip', '.pdf']],
        'figures' => ['enabled' => true, 'max_size_mb' => 20, 'extensions' => ['.tif', '.tiff', '.jpg', '.jpeg', '.png', '.eps', '.pdf']],
        'supplementary' => ['enabled' => true, 'max_size_mb' => 200, 'extensions' => ['.pdf', '.xlsx', '.csv', '.docx', '.pptx', '.zip', '.mp4']],
        'reviewer_materials' => ['enabled' => true, 'max_size_mb' => 50, 'extensions' => ['.pdf', '.doc', '.docx']],
    ];

    private static array $noFiles = [
        'manuscript' => ['enabled' => false],
        'figures' => ['enabled' => false],
        'supplementary' => ['enabled' => false],
        'reviewer_materials' => ['enabled' => false],
    ];

    public function run(): void
    {
        $types = [
            [
                'slug' => 'ORIGINAL_RESEARCH',
                'name' => 'Original Research',
                'description' => 'Original Research articles report on primary research. They must present original, previously unpublished research that falls within the scope of the journal and adds significantly to the understanding of the subject.',
                'sort_order' => 1,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'SYSTEMATIC_REVIEW',
                'name' => 'Systematic Review',
                'description' => 'Systematic Review articles present a synthesis of research on a clearly defined primary question using explicit, reproducible methods to identify, critically appraise, and analyze relevant studies.',
                'sort_order' => 2,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'REVIEW',
                'name' => 'Review',
                'description' => 'Review articles cover topics of current interest and provide balanced, comprehensive overviews of recent developments, current hypotheses, and major controversies in a given field.',
                'sort_order' => 3,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'MINI_REVIEW',
                'name' => 'Mini Review',
                'description' => 'Mini Review articles are concise, focused overviews of a specific topic, offering a succinct summary of recent developments or emerging concepts within a rapidly advancing field.',
                'sort_order' => 4,
                'max_word_count' => 3000,
                'max_summary_words' => 350,
                'max_figures_tables' => 2,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'METHODS',
                'name' => 'Methods',
                'description' => 'Methods articles present new or substantially improved experimental, computational, or analytical techniques, protocols, or tools that enable novel research insights.',
                'sort_order' => 5,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'PERSPECTIVE',
                'name' => 'Perspective',
                'description' => 'Perspective articles provide personal view points or commentary on specific research topics, discussing recent advances, key challenges, and future directions for the field.',
                'sort_order' => 6,
                'max_word_count' => 3000,
                'max_summary_words' => 350,
                'max_figures_tables' => 2,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'DATA_REPORT',
                'name' => 'Data Report',
                'description' => 'Data Reports present descriptions of major research datasets, databases, or computational tools, emphasizing data structure, collection methodology, and potential reuse.',
                'sort_order' => 7,
                'max_word_count' => 3000,
                'max_summary_words' => 350,
                'max_figures_tables' => 2,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
            ],
            [
                'slug' => 'POLICY_PRACTICE_REVIEWS',
                'name' => 'Policy and Practice Reviews',
                'description' => 'Policy and Practice Reviews assess current policies, frameworks, and practical approaches within specific operational or regulatory domains, proposing evidence-based improvements.',
                'sort_order' => 8,
                'max_word_count' => 12000,
                'max_summary_words' => 350,
                'max_figures_tables' => 15,
                'is_active' => true,
                'file_requirements' => self::$fullFiles,
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

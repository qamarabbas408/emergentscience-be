<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleAuthor;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['accounting', 'ORIGINAL_RESEARCH', 'Blockchain Technology in Financial Reporting', 'This study examines the integration of blockchain technology in financial reporting processes across 150 firms.', 'blockchain-financial-reporting', 'financial-reporting', [['Sarah Mitchell', 'smitchell@london.edu', '0000-0001-1111-1111', 'London Business School', true, 1]], 1250, 45],
            ['accounting', 'REVIEW', 'AI-Powered Auditing: Current State and Future Directions', 'This review provides a comprehensive overview of AI applications in auditing and fraud detection.', 'ai-auditing-review', 'auditing-standards', [['Emma Johnson', 'ejohnson@wharton.edu', '0000-0002-2222-2222', 'Wharton School', true, 1]], 2100, 89],
            ['accounting', 'ORIGINAL_RESEARCH', 'Corporate Governance and ESG Disclosure Quality', 'We investigate the relationship between corporate governance mechanisms and ESG disclosure quality in 500 publicly listed companies.', 'governance-esg-disclosure', 'corporate-governance', [['Thomas Park', 'tpark@lse.ac.uk', '0000-0003-3333-3333', 'London School of Economics', true, 1], ['Ana Garcia', 'agarcia@esade.edu', '0000-0004-4444-4444', 'ESADE', false, 2]], 3400, 120],
            ['acoustics', 'ORIGINAL_RESEARCH', 'Deep Learning for Underwater Acoustic Signal Classification', 'We present a deep learning framework for classifying underwater acoustic signals with 97% accuracy.', 'dl-underwater-acoustics', 'sound-wave-propagation', [['Marco Rossi', 'mrossi@polimi.it', '0000-0005-5555-5555', 'Politecnico di Milano', true, 1]], 1800, 56],
            ['acoustics', 'METHODS', 'Novel Noise Control Metamaterials for Industrial Applications', 'This paper presents a new class of acoustic metamaterials achieving 35dB noise reduction in industrial environments.', 'noise-control-metamaterials', 'noise-control', [['Li Chen', 'lchen@sjtu.edu.cn', '0000-0006-6666-6666', 'Shanghai Jiao Tong University', true, 1]], 950, 28],
            ['ai', 'ORIGINAL_RESEARCH', 'Transformer Models for Multi-Lingual Scientific Text Mining', 'We develop a transformer-based model for extracting key findings from scientific papers across 12 languages.', 'transformer-multilingual-mining', 'natural-language-processing', [['Akiko Tanaka', 'atanaka@u-tokyo.jp', '0000-0007-7777-7777', 'University of Tokyo', true, 1], ['Pierre Dubois', 'pdubois@ens.fr', '0000-0008-8888-8888', 'ENS Paris', false, 2]], 4200, 167],
            ['ai', 'MINI_REVIEW', 'Federated Learning for Privacy-Preserving Healthcare AI', 'This mini review surveys recent advances in federated learning approaches for medical AI while preserving patient privacy.', 'federated-learning-healthcare', 'machine-learning-algorithms', [['Fatima Al-Rashid', 'falrashid@kaust.edu.sa', '0000-0009-9999-9999', 'KAUST', true, 1]], 2800, 78],
            ['acta-microbiologica-hellenica', 'ORIGINAL_RESEARCH', 'Antimicrobial Resistance Patterns in Hospital-Acquired Infections', 'We analyze antimicrobial resistance patterns across 12 hospitals over a 5-year period identifying emerging resistance trends.', 'amr-hospital-infections', 'antimicrobial-resistance', [['Dimitrios Papadopoulos', 'dpapadopoulos@med.uoa.gr', '0000-0010-1010-1010', 'University of Athens', true, 1]], 1600, 52],
            ['actuators', 'ORIGINAL_RESEARCH', 'Piezoelectric Actuators for Precision Manufacturing: Performance Optimization', 'This study optimizes piezoelectric actuator designs for sub-nanometer precision in manufacturing applications.', 'piezo-actuator-optimization', 'piezoelectric-actuators', [['Hans Weber', 'hweber@tum.de', '0000-0011-1111-1111', 'TU Munich', true, 1], ['Yuki Nakamura', 'ynakamura@todai.jp', '0000-0012-2222-2222', 'University of Tokyo', false, 2]], 780, 19],
            ['aerospace', 'ORIGINAL_RESEARCH', 'Autonomous Rendezvous and Docking Using Computer Vision', 'We demonstrate autonomous spacecraft rendezvous and docking using stereo vision and deep reinforcement learning.', 'autonomous-spacecraft-docking', 'orbital-mechanics', [['Viktor Petrov', 'vpetrov@msu.ru', '0000-0013-3333-3333', 'Moscow State University', true, 1]], 3100, 92],
            ['aerospace', 'REVIEW', 'Sustainable Aviation Fuels: A Comprehensive Technical Review', 'This review evaluates current sustainable aviation fuel technologies including production pathways, performance characteristics, and lifecycle emissions.', 'sustainable-aviation-fuels', 'aircraft-design', [['Jennifer Clarke', 'jclarke@mit.edu', '0000-0014-4444-4444', 'MIT', true, 1]], 5400, 134],
            ['aerobiology', 'ORIGINAL_RESEARCH', 'Climate Change Effects on Airborne Pollen Distribution in Europe', 'We model the impact of climate change on pollen distribution patterns across 25 European cities over the next 50 years.', 'climate-pollen-europe', 'airborne-pollen', [['Elena Kozlova', 'ekozlova@msu.ru', '0000-0015-5555-5555', 'Moscow State University', true, 1]], 1400, 31],
        ];

        $pubDate = now()->subDays(60);

        foreach ($data as $i => $row) {
            [$journalSlug, $typeSlug, $title, $abstract, $slug, $topicSlug, $authors, $views, $cites] = $row;

            $journal = \App\Models\Journal::where('slug', $journalSlug)->first();
            $type = \App\Models\ArticleType::where('slug', $typeSlug)->first();
            $topic = \App\Models\Topic::where('slug', $topicSlug)->first();

            if (! $journal || ! $type) {
                continue;
            }

            $keywords = explode(' ', strtolower(str_replace([':', ',', ';'], '', $title)));
            $keywords = array_slice($keywords, 0, 5);

            $article = Article::create([
                'journal_id' => $journal->id,
                'article_type_id' => $type->id,
                'title' => $title,
                'abstract' => $abstract,
                'keywords' => $keywords,
                'doi' => '10.1000/test.2026.' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'slug' => $slug,
                'status' => 'published',
                'language' => 'en',
                'volume' => '1',
                'issue' => '1',
                'page_start' => ($i * 10) + 1,
                'page_end' => ($i + 1) * 10,
                'publication_date' => $pubDate->copy()->addDays($i * 5),
                'date_submitted' => $pubDate->copy()->subDays(60)->addDays($i * 5),
                'date_accepted' => $pubDate->copy()->subDays(20)->addDays($i * 5),
                'view_count' => $views,
                'download_count' => (int) ($views * 0.3),
                'citation_count' => $cites,
            ]);

            foreach ($authors as [$name, $email, $orcid, $affil, $corresponding, $sort]) {
                ArticleAuthor::create([
                    'article_id' => $article->id,
                    'name' => $name,
                    'email' => $email,
                    'orcid' => $orcid,
                    'affiliation' => $affil,
                    'is_corresponding' => $corresponding,
                    'sort_order' => $sort,
                ]);
            }

            if ($topic) {
                $article->topics()->attach($topic->id);
            }
        }
    }
}

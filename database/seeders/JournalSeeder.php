<?php

namespace Database\Seeders;

use App\Models\DisciplineCategory;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $journals = [
            [
                'journal' => [
                    'title' => 'Accounting and Auditing',
                    'slug' => 'accounting',
                    'abbreviation' => 'Account. Audit.',
                    'doi_prefix' => '10.3390/accountaudit',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'A journal covering financial reporting, auditing standards, corporate governance, managerial accounting, and risk assessment.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'business-economics',
                'topics' => [
                    ['name' => 'Financial Reporting', 'slug' => 'financial-reporting', 'description' => 'Accounting standards, financial statement analysis, and disclosure practices.'],
                    ['name' => 'Auditing Standards', 'slug' => 'auditing-standards', 'description' => 'Audit methodologies, regulatory frameworks, and assurance practices.'],
                    ['name' => 'Corporate Governance', 'slug' => 'corporate-governance', 'description' => 'Board structures, shareholder rights, and governance mechanisms.'],
                    ['name' => 'Managerial Accounting', 'slug' => 'managerial-accounting', 'description' => 'Cost accounting, budgeting, and performance management.'],
                    ['name' => 'Risk Assessment', 'slug' => 'risk-assessment', 'description' => 'Financial risk modeling, credit risk, and enterprise risk management.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Acoustics',
                    'slug' => 'acoustics',
                    'abbreviation' => 'Acoustics',
                    'doi_prefix' => '10.3390/acoustics',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Research on sound wave propagation, noise control, structural acoustics, psychoacoustics, and bioacoustics.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'physics-engineering',
                'topics' => [
                    ['name' => 'Sound Wave Propagation', 'slug' => 'sound-wave-propagation', 'description' => 'Theoretical and experimental studies of acoustic wave behavior.'],
                    ['name' => 'Noise Control', 'slug' => 'noise-control', 'description' => 'Noise reduction techniques, acoustic barriers, and environmental noise mitigation.'],
                    ['name' => 'Structural Acoustics', 'slug' => 'structural-acoustics', 'description' => 'Vibration-acoustic coupling in structures and materials.'],
                    ['name' => 'Psychoacoustics', 'slug' => 'psychoacoustics', 'description' => 'Human perception of sound and auditory processing.'],
                    ['name' => 'Bioacoustics', 'slug' => 'bioacoustics', 'description' => 'Animal vocalizations, acoustic ecology, and biological sound production.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Acta Microbiologica Hellenica',
                    'slug' => 'acta-microbiologica-hellenica',
                    'abbreviation' => 'Acta Microbiol. Hell.',
                    'doi_prefix' => '10.3390/amh',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Clinical microbiology, infectious diseases, antimicrobial resistance, and diagnostic microbiology.',
                    'is_active' => true,
                    'apc_amount' => 1600.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'medicine-microbiology',
                'topics' => [
                    ['name' => 'Clinical Microbiology', 'slug' => 'clinical-microbiology', 'description' => 'Pathogen identification, laboratory diagnostics, and clinical correlations.'],
                    ['name' => 'Infectious Diseases', 'slug' => 'infectious-diseases', 'description' => 'Epidemiology, pathogenesis, and treatment of infectious conditions.'],
                    ['name' => 'Antimicrobial Resistance', 'slug' => 'antimicrobial-resistance', 'description' => 'Resistance mechanisms, surveillance, and novel antimicrobial strategies.'],
                    ['name' => 'Diagnostic Microbiology', 'slug' => 'diagnostic-microbiology', 'description' => 'Rapid diagnostic methods, molecular techniques, and point-of-care testing.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Actuators',
                    'slug' => 'actuators',
                    'abbreviation' => 'Actuators',
                    'doi_prefix' => '10.3390/actuators',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Piezoelectric actuators, micro/nano-actuators, mechatronics, smart materials, and robotic drives.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'engineering-technology',
                'topics' => [
                    ['name' => 'Piezoelectric Actuators', 'slug' => 'piezoelectric-actuators', 'description' => 'Design, modeling, and applications of piezoelectric actuation systems.'],
                    ['name' => 'Micro/Nano-Actuators', 'slug' => 'micro-nano-actuators', 'description' => 'Miniaturized actuation at micro and nanoscale dimensions.'],
                    ['name' => 'Mechatronics', 'slug' => 'mechatronics', 'description' => 'Integration of mechanical, electronic, and software engineering.'],
                    ['name' => 'Smart Materials', 'slug' => 'smart-materials', 'description' => 'Shape-memory alloys, electroactive polymers, and responsive materials.'],
                    ['name' => 'Robotic Drives', 'slug' => 'robotic-drives', 'description' => 'Motor systems, motion control, and actuator technologies for robotics.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Addiction & Prevention',
                    'slug' => 'addiction-prevention',
                    'abbreviation' => 'Addict. Prev.',
                    'doi_prefix' => '10.3390/addictprev',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Substance abuse, behavioral addictions, preventative interventions, public health policy, and harm reduction.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'psychology-public-health',
                'topics' => [
                    ['name' => 'Substance Abuse', 'slug' => 'substance-abuse', 'description' => 'Epidemiology, neurobiology, and treatment of substance use disorders.'],
                    ['name' => 'Behavioral Addictions', 'slug' => 'behavioral-addictions', 'description' => 'Gambling, gaming, and other non-substance addictive behaviors.'],
                    ['name' => 'Preventative Interventions', 'slug' => 'preventative-interventions', 'description' => 'Evidence-based prevention programs and early intervention strategies.'],
                    ['name' => 'Public Health Policy', 'slug' => 'public-health-policy', 'description' => 'Policy frameworks addressing addiction at population level.'],
                    ['name' => 'Harm Reduction', 'slug' => 'harm-reduction', 'description' => 'Strategies to minimize negative consequences of substance use.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Adhesives',
                    'slug' => 'adhesives',
                    'abbreviation' => 'Adhesives',
                    'doi_prefix' => '10.3390/adhesives',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Bio-based adhesives, interfacial bonding, structural mechanics, surface treatment, and polymer chemistry.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'materials-science-chemistry',
                'topics' => [
                    ['name' => 'Bio-based Adhesives', 'slug' => 'bio-based-adhesives', 'description' => 'Sustainable adhesive formulations from renewable resources.'],
                    ['name' => 'Interfacial Bonding', 'slug' => 'interfacial-bonding', 'description' => 'Adhesion mechanisms at material interfaces and surface interactions.'],
                    ['name' => 'Structural Mechanics', 'slug' => 'structural-mechanics', 'description' => 'Mechanical performance and failure analysis of bonded joints.'],
                    ['name' => 'Surface Treatment', 'slug' => 'surface-treatment', 'description' => 'Surface preparation techniques for improved adhesion performance.'],
                    ['name' => 'Polymer Chemistry', 'slug' => 'polymer-chemistry', 'description' => 'Polymer synthesis, formulation, and characterization for adhesive applications.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Administrative Sciences',
                    'slug' => 'administrative-sciences',
                    'abbreviation' => 'Admin. Sci.',
                    'doi_prefix' => '10.3390/admsci',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Strategic management, organizational behavior, public administration, leadership, and strategic planning.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'business-management',
                'topics' => [
                    ['name' => 'Strategic Management', 'slug' => 'strategic-management', 'description' => 'Competitive strategy, resource-based views, and strategic decision-making.'],
                    ['name' => 'Organizational Behavior', 'slug' => 'organizational-behavior', 'description' => 'Individual and group dynamics within organizations.'],
                    ['name' => 'Public Administration', 'slug' => 'public-administration', 'description' => 'Government management, policy implementation, and public sector governance.'],
                    ['name' => 'Leadership', 'slug' => 'leadership', 'description' => 'Leadership theory, styles, and organizational impact.'],
                    ['name' => 'Strategic Planning', 'slug' => 'strategic-planning', 'description' => 'Long-term planning processes and organizational goal alignment.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Adolescents',
                    'slug' => 'adolescents',
                    'abbreviation' => 'Adolescents',
                    'doi_prefix' => '10.3390/adolescents',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Youth development, adolescent psychology, peer relationships, juvenile health, and educational growth.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'social-behavioral-sciences',
                'topics' => [
                    ['name' => 'Youth Development', 'slug' => 'youth-development', 'description' => 'Developmental processes and outcomes during adolescence.'],
                    ['name' => 'Adolescent Psychology', 'slug' => 'adolescent-psychology', 'description' => 'Cognitive, emotional, and social development in teenagers.'],
                    ['name' => 'Peer Relationships', 'slug' => 'peer-relationships', 'description' => 'Social networks, peer influence, and interpersonal dynamics.'],
                    ['name' => 'Juvenile Health', 'slug' => 'juvenile-health', 'description' => 'Physical and mental health outcomes in adolescent populations.'],
                    ['name' => 'Educational Growth', 'slug' => 'educational-growth', 'description' => 'Academic achievement, learning strategies, and educational interventions.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Advances in Respiratory Medicine',
                    'slug' => 'advances-respiratory-medicine',
                    'abbreviation' => 'Adv. Respir. Med.',
                    'doi_prefix' => '10.3390/arm',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Pulmonology, lung diseases, critical care, respiratory physiology, and mechanical ventilation.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'medicine-healthcare',
                'topics' => [
                    ['name' => 'Pulmonology', 'slug' => 'pulmonology', 'description' => 'Research on lung diseases, respiratory disorders, and pulmonary function.'],
                    ['name' => 'Lung Diseases', 'slug' => 'lung-diseases', 'description' => 'COPD, asthma, fibrosis, and other pulmonary pathologies.'],
                    ['name' => 'Critical Care', 'slug' => 'critical-care', 'description' => 'Intensive care medicine, ventilator management, and acute respiratory failure.'],
                    ['name' => 'Respiratory Physiology', 'slug' => 'respiratory-physiology', 'description' => 'Mechanisms of breathing, gas exchange, and respiratory regulation.'],
                    ['name' => 'Mechanical Ventilation', 'slug' => 'mechanical-ventilation', 'description' => 'Ventilation strategies, weaning protocols, and respiratory support technologies.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Aerobiology',
                    'slug' => 'aerobiology',
                    'abbreviation' => 'Aerobiology',
                    'doi_prefix' => '10.3390/aerobiology',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Airborne pollen, fungal spores, bioaerosols, air allergen monitoring, and atmospheric microflora.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'environmental-science-biology',
                'topics' => [
                    ['name' => 'Airborne Pollen', 'slug' => 'airborne-pollen', 'description' => 'Pollen transport, seasonal patterns, and allergenic potential.'],
                    ['name' => 'Fungal Spores', 'slug' => 'fungal-spores', 'description' => 'Aerobiology of fungi, spore dispersal, and health impacts.'],
                    ['name' => 'Bioaerosols', 'slug' => 'bioaerosols', 'description' => 'Biological particles in the atmosphere and their environmental effects.'],
                    ['name' => 'Air Allergen Monitoring', 'slug' => 'air-allergen-monitoring', 'description' => 'Monitoring networks, forecasting models, and public health alerts.'],
                    ['name' => 'Atmospheric Microflora', 'slug' => 'atmospheric-microflora', 'description' => 'Microbial communities in the atmosphere and their ecological roles.'],
                ],
            ],
        ];

        foreach ($journals as $entry) {
            $journal = Journal::firstOrCreate(
                ['slug' => $entry['journal']['slug']],
                $entry['journal'],
            );

            $category = DisciplineCategory::where('slug', $entry['category'])->first();
            if ($category && ! $journal->disciplineCategories()->where('discipline_category_id', $category->id)->exists()) {
                $journal->disciplineCategories()->attach($category);
            }

            foreach ($entry['topics'] as $topicData) {
                Topic::firstOrCreate(
                    ['journal_id' => $journal->id, 'slug' => $topicData['slug']],
                    [
                        'title' => $topicData['name'],
                        'description' => $topicData['description'],
                        'is_active' => true,
                    ],
                );
            }
        }
    }
}

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
                    'tagline' => 'Open access research in accounting, auditing, and corporate governance',
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
                    'tagline' => 'Research on sound, vibration, and acoustic engineering',
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
                    'tagline' => 'Microbiology and infectious disease research',
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
                    'tagline' => 'Smart actuators, mechatronics, and robotic systems',
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
                    'tagline' => 'Understanding and preventing addiction through research',
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
                    'tagline' => 'Advances in adhesive science and bonding technology',
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
                    'tagline' => 'Research in management, governance, and organizational science',
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
                    'tagline' => 'Adolescent health, development, and wellbeing',
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
                    'tagline' => 'Advancing pulmonary and respiratory care',
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
                    'tagline' => 'Airborne biological particles and allergen research',
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
            [
                'journal' => [
                    'title' => 'Aeronautics',
                    'tagline' => 'Flight dynamics, propulsion, and avionics research',
                    'slug' => 'aeronautics',
                    'abbreviation' => 'Aeronautics',
                    'doi_prefix' => '10.3390/aeronautics',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Flight dynamics, aircraft design, propulsion systems, aerodynamics, and avionics.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'aerospace-mechanical-engineering',
                'topics' => [
                    ['name' => 'Flight Dynamics', 'slug' => 'flight-dynamics', 'description' => 'Aircraft motion, stability, and control in atmospheric flight.'],
                    ['name' => 'Aircraft Design', 'slug' => 'aircraft-design', 'description' => 'Aerodynamic configuration, structural layout, and systems integration.'],
                    ['name' => 'Propulsion Systems', 'slug' => 'propulsion-systems', 'description' => 'Jet engines, rocket motors, and hybrid propulsion technologies.'],
                    ['name' => 'Aerodynamics', 'slug' => 'aerodynamics', 'description' => 'Airflow behavior around bodies, lift, drag, and flow control.'],
                    ['name' => 'Avionics', 'slug' => 'avionics', 'description' => 'Airborne electronics, navigation, communication, and flight control systems.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Aerospace',
                    'tagline' => 'Spaceflight, satellites, and orbital mechanics',
                    'slug' => 'aerospace',
                    'abbreviation' => 'Aerospace',
                    'doi_prefix' => '10.3390/aerospace',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Spaceflight, satellite engineering, rocketry, space exploration, and orbital mechanics.',
                    'is_active' => true,
                    'apc_amount' => 2200.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'aerospace-engineering-space-sciences',
                'topics' => [
                    ['name' => 'Spaceflight', 'slug' => 'spaceflight', 'description' => 'Manned and unmanned space missions, launch vehicle design, and mission planning.'],
                    ['name' => 'Satellite Engineering', 'slug' => 'satellite-engineering', 'description' => 'Satellite design, payload integration, and ground segment operations.'],
                    ['name' => 'Rocketry', 'slug' => 'rocketry', 'description' => 'Solid and liquid rocket propulsion, launch systems, and recovery.'],
                    ['name' => 'Space Exploration', 'slug' => 'space-exploration', 'description' => 'Planetary science, deep space missions, and exploration technologies.'],
                    ['name' => 'Orbital Mechanics', 'slug' => 'orbital-mechanics', 'description' => 'Keplerian orbits, trajectory design, and orbital rendezvous.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Agriculture',
                    'tagline' => 'Crop production, farming, and agricultural economics',
                    'slug' => 'agriculture',
                    'abbreviation' => 'Agriculture',
                    'doi_prefix' => '10.3390/agriculture',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Crop production, sustainable farming, soil management, agricultural economics, and pest control.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'agricultural-environmental-sciences',
                'topics' => [
                    ['name' => 'Crop Production', 'slug' => 'crop-production', 'description' => 'Yield optimization, cropping systems, and production agronomy.'],
                    ['name' => 'Sustainable Farming', 'slug' => 'sustainable-farming', 'description' => 'Conservation agriculture, organic methods, and long-term sustainability.'],
                    ['name' => 'Soil Management', 'slug' => 'soil-management', 'description' => 'Tillage, mulching, cover cropping, and soil health maintenance.'],
                    ['name' => 'Agricultural Economics', 'slug' => 'agricultural-economics', 'description' => 'Farm economics, market analysis, and agricultural policy.'],
                    ['name' => 'Pest Control', 'slug' => 'pest-control', 'description' => 'Integrated pest management, biological control, and crop protection.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'AgriEngineering',
                    'tagline' => 'Agricultural machinery and precision farming tech',
                    'slug' => 'agriengineering',
                    'abbreviation' => 'AgriEng.',
                    'doi_prefix' => '10.3390/agriengineering',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Agricultural machinery, precision farming technologies, irrigation systems, and post-harvest engineering.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'agricultural-engineering-automation',
                'topics' => [
                    ['name' => 'Agricultural Machinery', 'slug' => 'agricultural-machinery', 'description' => 'Design, optimization, and automation of farm equipment.'],
                    ['name' => 'Precision Farming Technologies', 'slug' => 'precision-farming-technologies', 'description' => 'GPS-guided equipment, variable rate application, and field mapping.'],
                    ['name' => 'Irrigation Systems', 'slug' => 'irrigation-systems', 'description' => 'Drip, sprinkler, and deficit irrigation strategies and technologies.'],
                    ['name' => 'Post-Harvest Engineering', 'slug' => 'post-harvest-engineering', 'description' => 'Storage, processing, and transportation of agricultural products.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Agrochemicals',
                    'tagline' => 'Fertilizers, pesticides, and agrochemical research',
                    'slug' => 'agrochemicals',
                    'abbreviation' => 'Agrochemicals',
                    'doi_prefix' => '10.3390/agrochemicals',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Fertilizers, pesticides, plant growth regulators, agrochemical synthesis, and environmental toxicology.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'chemistry-agricultural-science',
                'topics' => [
                    ['name' => 'Fertilizers', 'slug' => 'fertilizers', 'description' => 'Nutrient formulations, slow-release technologies, and soil amendments.'],
                    ['name' => 'Pesticides', 'slug' => 'pesticides', 'description' => 'Herbicides, insecticides, fungicides, and resistance management.'],
                    ['name' => 'Plant Growth Regulators', 'slug' => 'plant-growth-regulators', 'description' => 'Hormone analogs, biostimulants, and growth modification techniques.'],
                    ['name' => 'Agrochemical Synthesis', 'slug' => 'agrochemical-synthesis', 'description' => 'Novel compound design, green chemistry, and formulation development.'],
                    ['name' => 'Environmental Toxicology', 'slug' => 'environmental-toxicology', 'description' => 'Fate, transport, and ecological impact of agrochemicals.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'Agronomy',
                    'tagline' => 'Crop ecology, soil fertility, and field management',
                    'slug' => 'agronomy',
                    'abbreviation' => 'Agronomy',
                    'doi_prefix' => '10.3390/agronomy',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Crop ecology, weed science, soil fertility, seed technology, and field crop management.',
                    'is_active' => true,
                    'apc_amount' => 1800.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'agronomy-plant-sciences',
                'topics' => [
                    ['name' => 'Crop Ecology', 'slug' => 'crop-ecology', 'description' => 'Plant-environment interactions, adaptation, and stress physiology.'],
                    ['name' => 'Weed Science', 'slug' => 'weed-science', 'description' => 'Weed biology, competition, and management strategies.'],
                    ['name' => 'Soil Fertility', 'slug' => 'soil-fertility', 'description' => 'Nutrient cycling, soil testing, and fertility management.'],
                    ['name' => 'Seed Technology', 'slug' => 'seed-technology', 'description' => 'Seed production, quality, treatment, and germination science.'],
                    ['name' => 'Field Crop Management', 'slug' => 'field-crop-management', 'description' => 'Planting density, irrigation scheduling, and harvest optimization.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'AI',
                    'tagline' => 'Machine learning, neural networks, and deep learning',
                    'slug' => 'ai',
                    'abbreviation' => 'AI',
                    'doi_prefix' => '10.3390/ai',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Machine learning algorithms, neural networks, computer vision, natural language processing, and deep learning.',
                    'is_active' => true,
                    'apc_amount' => 2200.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'computer-science-artificial-intelligence',
                'topics' => [
                    ['name' => 'Machine Learning Algorithms', 'slug' => 'machine-learning-algorithms', 'description' => 'Supervised, unsupervised, and reinforcement learning methods.'],
                    ['name' => 'Neural Networks', 'slug' => 'neural-networks', 'description' => 'Architecture design, training strategies, and network optimization.'],
                    ['name' => 'Computer Vision', 'slug' => 'computer-vision', 'description' => 'Image recognition, object detection, and visual understanding.'],
                    ['name' => 'Natural Language Processing', 'slug' => 'natural-language-processing', 'description' => 'Text analysis, language models, and conversational AI.'],
                    ['name' => 'Deep Learning', 'slug' => 'deep-learning', 'description' => 'Convolutional, recurrent, transformer, and generative architectures.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'AI and Precision Agriculture',
                    'tagline' => 'AI-driven smart farming and crop intelligence',
                    'slug' => 'ai-precision-agriculture',
                    'abbreviation' => 'AI Precis. Agric.',
                    'doi_prefix' => '10.3390/aiprecagric',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Smart farming algorithms, remote crop sensing, automated harvesting, and yield prediction AI.',
                    'is_active' => true,
                    'apc_amount' => 2000.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'computer-science-agriculture',
                'topics' => [
                    ['name' => 'Smart Farming Algorithms', 'slug' => 'smart-farming-algorithms', 'description' => 'Decision support systems and optimization for farm operations.'],
                    ['name' => 'Remote Crop Sensing', 'slug' => 'remote-crop-sensing', 'description' => 'Satellite imagery, drone-based monitoring, and spectral analysis.'],
                    ['name' => 'Automated Harvesting', 'slug' => 'automated-harvesting', 'description' => 'Robotic harvesters, selective picking, and yield estimation.'],
                    ['name' => 'Yield Prediction AI', 'slug' => 'yield-prediction-ai', 'description' => 'Predictive models for crop yield using machine learning.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'AI Chemistry',
                    'tagline' => 'AI for molecular prediction and drug discovery',
                    'slug' => 'ai-chemistry',
                    'abbreviation' => 'AI Chem.',
                    'doi_prefix' => '10.3390/aichemistry',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Molecular property prediction, automated chemical synthesis, drug discovery AI, and cheminformatics.',
                    'is_active' => true,
                    'apc_amount' => 2200.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'chemistry-computational-science',
                'topics' => [
                    ['name' => 'Molecular Property Prediction', 'slug' => 'molecular-property-prediction', 'description' => 'AI models for predicting chemical and physical properties of molecules.'],
                    ['name' => 'Automated Chemical Synthesis', 'slug' => 'automated-chemical-synthesis', 'description' => 'Robot-driven synthesis planning and reaction optimization.'],
                    ['name' => 'Drug Discovery AI', 'slug' => 'drug-discovery-ai', 'description' => 'Target identification, lead optimization, and clinical trial prediction.'],
                    ['name' => 'Cheminformatics', 'slug' => 'cheminformatics', 'description' => 'Chemical data management, molecular descriptors, and QSAR modeling.'],
                ],
            ],
            [
                'journal' => [
                    'title' => 'AI for Engineering',
                    'tagline' => 'Generative design, predictive maintenance, and physics-informed AI',
                    'slug' => 'ai-engineering',
                    'abbreviation' => 'AI Eng.',
                    'doi_prefix' => '10.3390/aiengineering',
                    'license' => 'CC-BY 4.0',
                    'scope' => 'Generative engineering design, structural health AI monitoring, predictive maintenance, and physics-informed AI.',
                    'is_active' => true,
                    'apc_amount' => 2200.00,
                    'apc_currency' => 'CHF',
                ],
                'category' => 'engineering-computer-science',
                'topics' => [
                    ['name' => 'Generative Engineering Design', 'slug' => 'generative-engineering-design', 'description' => 'AI-driven topology optimization and generative design.'],
                    ['name' => 'Structural Health AI Monitoring', 'slug' => 'structural-health-ai-monitoring', 'description' => 'Real-time structural assessment using AI and sensor data.'],
                    ['name' => 'Predictive Maintenance', 'slug' => 'predictive-maintenance', 'description' => 'Fault prediction and maintenance scheduling via machine learning.'],
                    ['name' => 'Physics-Informed AI', 'slug' => 'physics-informed-ai', 'description' => 'Neural networks constrained by physical laws and governing equations.'],
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

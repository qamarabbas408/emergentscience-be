<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        $title = $this->faker->randomElement([
            'Atmospheric Science',
            'Biogeoscience',
            'Geosciences',
            'Planetary Science',
            'Ecology',
            'Evolutionary Biology',
            'Genetics',
            'Neuroscience',
            'Immunology',
            'Pharmacology',
            'Materials Science',
            'Energy',
            'AI & Machine Learning',
            'Quantum Computing',
            'Climate Science',
            'Marine Biology',
        ]);

        return [
            'slug' => $this->faker->unique()->slug(),
            'title' => $title,
            'description' => $this->faker->sentence(12),
            'is_active' => $this->faker->boolean(85),
            'sort_order' => $this->faker->optional(60)->numberBetween(1, 50),
        ];
    }
}

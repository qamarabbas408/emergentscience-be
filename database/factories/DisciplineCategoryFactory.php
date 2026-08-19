<?php

namespace Database\Factories;

use App\Models\DisciplineCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DisciplineCategory>
 */
class DisciplineCategoryFactory extends Factory
{
    protected $model = DisciplineCategory::class;

    public function definition(): array
    {
        $name = $this->faker->randomElement([
            'Science',
            'Health',
            'Engineering',
            'Humanities and Social Sciences',
            'Sustainability',
        ]);

        return [
            'name' => $name,
            'slug' => $this->faker->unique()->slug(),
            'description' => $this->faker->sentence(10),
            'is_active' => $this->faker->boolean(90),
            'sort_order' => $this->faker->optional(60)->numberBetween(1, 10),
        ];
    }
}

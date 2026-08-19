<?php

namespace Database\Factories;

use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Journal>
 */
class JournalFactory extends Factory
{
    protected $model = Journal::class;

    public function definition(): array
    {
        $title = $this->faker->company() . ' ' . $this->faker->randomElement(['Science', 'Review', 'Studies', 'Quarterly', 'Journal']);

        return [
            'slug' => $this->faker->unique()->slug,
            'title' => $title,
            'abbreviation' => $this->faker->boolean(70) ? $this->faker->word() . ' Sci.' : null,
            'issn' => $this->faker->numerify('####-####') . ' ' . $this->faker->numerify('####-####'),
            'eissn' => $this->faker->numerify('####-####') . ' ' . $this->faker->numerify('####-####'),
            'doi_prefix' => '10.33' . $this->faker->numberBetween(100, 999),
            'discipline' => $this->faker->randomElement(['Earth Science', 'Life Sciences', 'Engineering', 'Medicine', 'Social Sciences', 'Humanities']),
            'license' => 'CC-BY 4.0',
            'scope' => $this->faker->sentence(18),
            'is_active' => $this->faker->boolean(85),
            'apc_amount' => $this->faker->boolean(60) ? $this->faker->randomFloat(2, 950, 4500) : null,
            'apc_currency' => $this->faker->boolean(60) ? $this->faker->currencyCode() : null,
        ];
    }
}

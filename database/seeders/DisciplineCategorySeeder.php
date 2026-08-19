<?php

namespace Database\Seeders;

use App\Models\DisciplineCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplineCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            ['name' => 'Science', 'slug' => 'science', 'sort_order' => 1],
            ['name' => 'Health', 'slug' => 'health', 'sort_order' => 2],
            ['name' => 'Engineering', 'slug' => 'engineering', 'sort_order' => 3],
            ['name' => 'Social Sciences', 'slug' => 'social-sciences', 'sort_order' => 4],
            ['name' => 'Humanities', 'slug' => 'humanities', 'sort_order' => 5],
            ['name' => 'Economics & Business', 'slug' => 'economics-business', 'sort_order' => 6],
            ['name' => 'Data & Information', 'slug' => 'data-information', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            DisciplineCategory::firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'is_active' => true,
                    'sort_order' => $category['sort_order'],
                ],
            );
        }
    }
}

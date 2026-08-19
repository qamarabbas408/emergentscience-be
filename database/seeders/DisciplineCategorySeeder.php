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
            ['name' => 'Business & Economics', 'slug' => 'business-economics', 'sort_order' => 1],
            ['name' => 'Physics & Engineering', 'slug' => 'physics-engineering', 'sort_order' => 2],
            ['name' => 'Medicine & Microbiology', 'slug' => 'medicine-microbiology', 'sort_order' => 3],
            ['name' => 'Engineering & Technology', 'slug' => 'engineering-technology', 'sort_order' => 4],
            ['name' => 'Psychology & Public Health', 'slug' => 'psychology-public-health', 'sort_order' => 5],
            ['name' => 'Materials Science & Chemistry', 'slug' => 'materials-science-chemistry', 'sort_order' => 6],
            ['name' => 'Business & Management', 'slug' => 'business-management', 'sort_order' => 7],
            ['name' => 'Social & Behavioral Sciences', 'slug' => 'social-behavioral-sciences', 'sort_order' => 8],
            ['name' => 'Medicine & Healthcare', 'slug' => 'medicine-healthcare', 'sort_order' => 9],
            ['name' => 'Environmental Science & Biology', 'slug' => 'environmental-science-biology', 'sort_order' => 10],
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

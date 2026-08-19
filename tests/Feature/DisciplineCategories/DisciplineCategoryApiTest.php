<?php

namespace Tests\Feature\DisciplineCategories;

use App\Models\DisciplineCategory;
use App\Models\Journal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisciplineCategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_categories_are_listed(): void
    {
        DisciplineCategory::factory()->create(['is_active' => true, 'name' => 'Science']);
        DisciplineCategory::factory()->create(['is_active' => false, 'name' => 'Hidden']);

        $response = $this->getJson('/api/v1/discipline-categories');

        $response->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name', 'slug', 'is_active']]])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Science');
    }

    public function test_inactive_categories_are_not_listed(): void
    {
        DisciplineCategory::factory()->create(['is_active' => false]);

        $this->getJson('/api/v1/discipline-categories')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_can_view_an_active_category(): void
    {
        $category = DisciplineCategory::factory()->create(['is_active' => true]);

        $this->getJson("/api/v1/discipline-categories/{$category->id}")
            ->assertOk()
            ->assertJsonStructure(['data' => ['id', 'name', 'slug', 'is_active']]);
    }

    public function test_cannot_view_an_inactive_category(): void
    {
        $category = DisciplineCategory::factory()->create(['is_active' => false]);

        $this->getJson("/api/v1/discipline-categories/{$category->id}")
            ->assertNotFound();
    }

    public function test_missing_category_returns_404(): void
    {
        $this->getJson('/api/v1/discipline-categories/9999')
            ->assertNotFound();
    }

    public function test_can_list_journals_for_a_category(): void
    {
        $category = DisciplineCategory::factory()->create(['is_active' => true]);
        Journal::factory()->create(['discipline_category_id' => $category->id, 'is_active' => true, 'title' => 'Journal A']);
        Journal::factory()->create(['discipline_category_id' => $category->id, 'is_active' => false, 'title' => 'Journal B']);
        Journal::factory()->create(['is_active' => true]); // different category

        $response = $this->getJson("/api/v1/discipline-categories/{$category->id}/journals");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Journal A');
    }

    public function test_journals_endpoint_returns_404_for_inactive_category(): void
    {
        $category = DisciplineCategory::factory()->create(['is_active' => false]);

        $this->getJson("/api/v1/discipline-categories/{$category->id}/journals")
            ->assertNotFound();
    }

    public function test_categories_are_sorted_by_sort_order_then_name(): void
    {
        DisciplineCategory::factory()->create(['name' => 'Z Category', 'sort_order' => 2, 'is_active' => true]);
        DisciplineCategory::factory()->create(['name' => 'A Category', 'sort_order' => 1, 'is_active' => true]);

        $response = $this->getJson('/api/v1/discipline-categories');

        $response->assertOk()
            ->assertJsonPath('data.0.name', 'A Category')
            ->assertJsonPath('data.1.name', 'Z Category');
    }
}

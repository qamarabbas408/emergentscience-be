<?php

namespace Tests\Feature\Journals;

use App\Models\DisciplineCategory;
use App\Models\Journal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_journals_are_listed(): void
    {
        Journal::factory()->create(['is_active' => true, 'title' => 'Visible Journal']);
        Journal::factory()->create(['is_active' => false, 'title' => 'Hidden Journal']);

        $response = $this->getJson('/api/v1/journals');

        $response->assertOk()
            ->assertJsonStructure(['data' => [['id', 'slug', 'title', 'tagline', 'category', 'is_new', 'sections_count', 'articles_count', 'views', 'citations', 'impact_factor', 'citescore']]])
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Visible Journal');
    }

    public function test_inactive_journals_are_not_listed(): void
    {
        Journal::factory()->create(['is_active' => false]);

        $this->getJson('/api/v1/journals')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_can_view_an_active_journal(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);

        $this->getJson("/api/v1/journals/{$journal->id}")
            ->assertOk()
            ->assertJsonStructure(['data' => ['id', 'slug', 'title', 'tagline', 'category', 'is_new', 'field_chief_editor', 'sections_count', 'articles_count', 'views', 'citations', 'impact_factor', 'citescore']]);
    }

    public function test_cannot_view_an_inactive_journal(): void
    {
        $journal = Journal::factory()->create(['is_active' => false]);

        $this->getJson("/api/v1/journals/{$journal->id}")
            ->assertNotFound();
    }

    public function test_missing_journal_returns_404(): void
    {
        $this->getJson('/api/v1/journals/9999')
            ->assertNotFound();
    }

    public function test_journal_resource_excludes_billing_fields(): void
    {
        $journal = Journal::factory()->create([
            'is_active' => true,
            'apc_amount' => 2500.00,
            'apc_currency' => 'USD',
        ]);

        $response = $this->getJson("/api/v1/journals/{$journal->id}")->assertOk();

        $response->assertJsonMissing(['apc_amount', 'apc_currency']);
    }

    public function test_journal_returns_first_category_name(): void
    {
        $category = DisciplineCategory::factory()->create(['name' => 'Physics & Engineering']);
        $journal = Journal::factory()->create(['is_active' => true]);
        $journal->disciplineCategories()->attach($category);

        $this->getJson("/api/v1/journals/{$journal->id}")
            ->assertOk()
            ->assertJsonPath('data.category', 'Physics & Engineering');
    }

    public function test_journal_returns_null_category_when_none(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);

        $this->getJson("/api/v1/journals/{$journal->id}")
            ->assertOk()
            ->assertJsonPath('data.category', null);
    }

    public function test_pagination_returns_meta(): void
    {
        Journal::factory()->count(15)->create(['is_active' => true]);

        $response = $this->getJson('/api/v1/journals?per_page=10');

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure(['meta' => ['current_page', 'last_page', 'per_page', 'total']])
            ->assertJsonPath('meta.total', 15)
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_search_filters_by_title(): void
    {
        Journal::factory()->create(['is_active' => true, 'title' => 'Journal of Acoustics']);
        Journal::factory()->create(['is_active' => true, 'title' => 'Journal of Chemistry']);

        $this->getJson('/api/v1/journals?search=acoustics')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Journal of Acoustics');
    }

    public function test_search_filters_by_abbreviation(): void
    {
        Journal::factory()->create(['is_active' => true, 'abbreviation' => 'J. Acoust.', 'title' => 'Journal of Acoustics']);
        Journal::factory()->create(['is_active' => true, 'abbreviation' => 'J. Chem.', 'title' => 'Journal of Chemistry']);

        $this->getJson('/api/v1/journals?search=acoust')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_category_filter(): void
    {
        $category = DisciplineCategory::factory()->create(['slug' => 'physics-engineering']);
        $j1 = Journal::factory()->create(['is_active' => true, 'title' => 'Acoustics']);
        $j1->disciplineCategories()->attach($category);
        $j2 = Journal::factory()->create(['is_active' => true, 'title' => 'Chemistry']);
        // no category attached

        $this->getJson('/api/v1/journals?category=physics-engineering')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Acoustics');
    }

    public function test_sort_by_title_descending(): void
    {
        Journal::factory()->create(['is_active' => true, 'title' => 'Zebra Journal']);
        Journal::factory()->create(['is_active' => true, 'title' => 'Alpha Journal']);

        $this->getJson('/api/v1/journals?sort=-title')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Zebra Journal');
    }

    public function test_per_page_max_is_50(): void
    {
        Journal::factory()->count(5)->create(['is_active' => true]);

        $response = $this->getJson('/api/v1/journals?per_page=100');

        $response->assertOk()
            ->assertJsonPath('meta.per_page', 50);
    }
}

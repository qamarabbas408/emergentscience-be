<?php

namespace Tests\Feature\Journals;

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
            ->assertJsonStructure(['data' => [['id', 'slug', 'title', 'doi_prefix', 'is_active']]])
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
            ->assertJsonStructure(['data' => ['id', 'slug', 'title', 'doi_prefix', 'is_active']]);
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
}
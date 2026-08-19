<?php

namespace Tests\Feature\Topics;

use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_topics_are_listed_for_a_journal(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => true, 'title' => 'Visible Topic']);
        Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => false, 'title' => 'Hidden Topic']);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics");

        $response->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => [['id', 'journal_id', 'slug', 'title', 'is_active']]])
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Visible Topic');
    }

    public function test_inactive_topics_are_not_listed(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => false]);

        $this->getJson("/api/v1/journals/{$journal->id}/topics")
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_topics_from_other_journals_are_not_listed(): void
    {
        $journalA = Journal::factory()->create(['is_active' => true]);
        $journalB = Journal::factory()->create(['is_active' => true]);
        Topic::factory()->create(['journal_id' => $journalA->id, 'is_active' => true]);
        Topic::factory()->create(['journal_id' => $journalB->id, 'is_active' => true]);

        $response = $this->getJson("/api/v1/journals/{$journalA->id}/topics");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.journal_id', $journalA->id);
    }

    public function test_inactive_journal_returns_404_for_topics(): void
    {
        $journal = Journal::factory()->create(['is_active' => false]);
        Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => true]);

        $this->getJson("/api/v1/journals/{$journal->id}/topics")
            ->assertNotFound();
    }

    public function test_can_view_an_active_topic(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => true]);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics/{$topic->id}");

        $response->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'journal_id', 'slug', 'title', 'is_active']]);
    }

    public function test_cannot_view_topic_from_different_journal(): void
    {
        $journalA = Journal::factory()->create(['is_active' => true]);
        $journalB = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['journal_id' => $journalB->id, 'is_active' => true]);

        $this->getJson("/api/v1/journals/{$journalA->id}/topics/{$topic->id}")
            ->assertNotFound();
    }

    public function test_cannot_view_inactive_topic(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['journal_id' => $journal->id, 'is_active' => false]);

        $this->getJson("/api/v1/journals/{$journal->id}/topics/{$topic->id}")
            ->assertNotFound();
    }

    public function test_missing_topic_returns_404(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);

        $this->getJson("/api/v1/journals/{$journal->id}/topics/9999")
            ->assertNotFound();
    }

    public function test_topics_are_sorted_by_sort_order_then_title(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        Topic::factory()->create(['journal_id' => $journal->id, 'title' => 'Z Topic', 'sort_order' => 2, 'is_active' => true]);
        Topic::factory()->create(['journal_id' => $journal->id, 'title' => 'A Topic', 'sort_order' => 1, 'is_active' => true]);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics");

        $response->assertOk()
            ->assertJsonPath('data.0.title', 'A Topic')
            ->assertJsonPath('data.1.title', 'Z Topic');
    }
}

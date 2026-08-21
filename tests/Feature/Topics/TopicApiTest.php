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
        $topic = Topic::factory()->create(['is_active' => true, 'title' => 'Visible Topic']);
        $topic->journals()->attach($journal);
        $hidden = Topic::factory()->create(['is_active' => false, 'title' => 'Hidden Topic']);
        $hidden->journals()->attach($journal);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics");

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Visible Topic');
    }

    public function test_inactive_topics_are_not_listed(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['is_active' => false]);
        $topic->journals()->attach($journal);

        $this->getJson("/api/v1/journals/{$journal->id}/topics")
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_topics_from_other_journals_are_not_listed(): void
    {
        $journalA = Journal::factory()->create(['is_active' => true]);
        $journalB = Journal::factory()->create(['is_active' => true]);
        $topicA = Topic::factory()->create(['is_active' => true]);
        $topicA->journals()->attach($journalA);
        $topicB = Topic::factory()->create(['is_active' => true]);
        $topicB->journals()->attach($journalB);

        $response = $this->getJson("/api/v1/journals/{$journalA->id}/topics");

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_inactive_journal_returns_404_for_topics(): void
    {
        $journal = Journal::factory()->create(['is_active' => false]);
        $topic = Topic::factory()->create(['is_active' => true]);
        $topic->journals()->attach($journal);

        $this->getJson("/api/v1/journals/{$journal->id}/topics")
            ->assertNotFound();
    }

    public function test_can_view_an_active_topic(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['is_active' => true]);
        $topic->journals()->attach($journal);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics/{$topic->slug}");

        $response->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'slug', 'title', 'is_active']]);
    }

    public function test_cannot_view_topic_from_different_journal(): void
    {
        $journalA = Journal::factory()->create(['is_active' => true]);
        $journalB = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['is_active' => true]);
        $topic->journals()->attach($journalB);

        $this->getJson("/api/v1/journals/{$journalA->id}/topics/{$topic->slug}")
            ->assertNotFound();
    }

    public function test_cannot_view_inactive_topic(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topic = Topic::factory()->create(['is_active' => false]);
        $topic->journals()->attach($journal);

        $this->getJson("/api/v1/journals/{$journal->id}/topics/{$topic->slug}")
            ->assertNotFound();
    }

    public function test_missing_topic_returns_404(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);

        $this->getJson("/api/v1/journals/{$journal->id}/topics/nonexistent-slug")
            ->assertNotFound();
    }

    public function test_topics_are_sorted_by_sort_order_then_title(): void
    {
        $journal = Journal::factory()->create(['is_active' => true]);
        $topicZ = Topic::factory()->create(['title' => 'Z Topic', 'sort_order' => 2, 'is_active' => true]);
        $topicZ->journals()->attach($journal);
        $topicA = Topic::factory()->create(['title' => 'A Topic', 'sort_order' => 1, 'is_active' => true]);
        $topicA->journals()->attach($journal);

        $response = $this->getJson("/api/v1/journals/{$journal->id}/topics");

        $response->assertOk()
            ->assertJsonPath('data.0.title', 'A Topic')
            ->assertJsonPath('data.1.title', 'Z Topic');
    }
}

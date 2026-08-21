<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use App\Models\ArticleAuthor;
use App\Models\ArticleType;
use App\Models\Journal;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    private ArticleType $type;
    private Journal $journal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->type = ArticleType::factory()->create(['slug' => 'ORIGINAL_RESEARCH']);
        $this->journal = Journal::factory()->create(['is_active' => true]);
    }

    private function createPublished(array $overrides = []): Article
    {
        return Article::factory()->create(array_merge([
            'journal_id' => $this->journal->id,
            'article_type_id' => $this->type->id,
            'status' => 'published',
        ], $overrides));
    }

    public function test_lists_published_articles(): void
    {
        $this->createPublished(['title' => 'Published Article']);
        Article::factory()->create([
            'journal_id' => $this->journal->id,
            'article_type_id' => $this->type->id,
            'status' => 'draft',
            'title' => 'Draft Article',
        ]);

        $response = $this->getJson('/api/v1/articles');

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Published Article')
            ->assertJsonStructure(['data' => [['id', 'slug', 'title', 'abstract', 'keywords', 'doi', 'status', 'journal', 'article_type', 'topics']], 'meta']);
    }

    public function test_shows_single_article(): void
    {
        $article = $this->createPublished([
            'title' => 'My Article',
            'abstract' => 'This is the abstract.',
            'keywords' => ['science', 'research'],
        ]);

        $response = $this->getJson("/api/v1/articles/{$article->slug}");

        $response->assertOk()
            ->assertJsonPath('data.title', 'My Article')
            ->assertJsonPath('data.abstract', 'This is the abstract.')
            ->assertJsonPath('data.keywords', ['science', 'research'])
            ->assertJsonPath('data.journal.slug', $this->journal->slug)
            ->assertJsonPath('data.article_type.slug', 'ORIGINAL_RESEARCH')
            ->assertJsonStructure(['data' => [...['authors', 'topics']]]);
    }

    public function test_does_not_show_draft_article(): void
    {
        $article = Article::factory()->create([
            'journal_id' => $this->journal->id,
            'article_type_id' => $this->type->id,
            'status' => 'draft',
        ]);

        $this->getJson("/api/v1/articles/{$article->slug}")
            ->assertNotFound();
    }

    public function test_article_includes_authors(): void
    {
        $article = $this->createPublished();
        ArticleAuthor::create([
            'article_id' => $article->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'orcid' => '0000-0001-2345-6789',
            'affiliation' => 'MIT',
            'sort_order' => 1,
            'is_corresponding' => true,
        ]);

        $response = $this->getJson("/api/v1/articles/{$article->slug}");

        $response->assertOk()
            ->assertJsonCount(1, 'data.authors')
            ->assertJsonPath('data.authors.0.name', 'Jane Doe')
            ->assertJsonPath('data.authors.0.orcid', '0000-0001-2345-6789')
            ->assertJsonPath('data.authors.0.is_corresponding', true);
    }

    public function test_article_includes_topics(): void
    {
        $article = $this->createPublished();
        $topic = Topic::create([
            'journal_id' => $this->journal->id,
            'slug' => 'quantum-physics',
            'title' => 'Quantum Physics',
            'description' => 'Study of quantum phenomena.',
        ]);
        $article->topics()->attach($topic);

        $response = $this->getJson("/api/v1/articles/{$article->slug}");

        $response->assertOk()
            ->assertJsonCount(1, 'data.topics')
            ->assertJsonPath('data.topics.0.slug', 'quantum-physics');
    }

    public function test_journal_articles_endpoint(): void
    {
        $this->createPublished(['title' => 'J1 Article']);
        $otherJournal = Journal::factory()->create(['is_active' => true]);
        Article::factory()->create([
            'journal_id' => $otherJournal->id,
            'article_type_id' => $this->type->id,
            'status' => 'published',
            'title' => 'Other Article',
        ]);

        $response = $this->getJson("/api/v1/journals/{$this->journal->id}/articles");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'J1 Article');
    }

    public function test_journal_articles_filters_by_type(): void
    {
        $reviewType = ArticleType::factory()->create(['slug' => 'REVIEW']);
        $this->createPublished(['title' => 'Research']);
        Article::factory()->create([
            'journal_id' => $this->journal->id,
            'article_type_id' => $reviewType->id,
            'status' => 'published',
            'title' => 'Review',
        ]);

        $this->getJson("/api/v1/journals/{$this->journal->id}/articles?type=ORIGINAL_RESEARCH")
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Research');
    }

    public function test_topic_articles_endpoint(): void
    {
        $topic = Topic::create([
            'journal_id' => $this->journal->id,
            'slug' => 'materials',
            'title' => 'Materials',
            'description' => 'Desc',
        ]);
        $article = $this->createPublished(['title' => 'Materials Paper']);
        $article->topics()->attach($topic);

        $this->createPublished(['title' => 'Other Paper']);

        $response = $this->getJson("/api/v1/topics/{$topic->id}/articles");

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Materials Paper');
    }

    public function test_search_filters_by_title(): void
    {
        $this->createPublished(['title' => 'Nanotech Applications']);
        $this->createPublished(['title' => 'Quantum Computing']);

        $this->getJson('/api/v1/articles?search=nanotech')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Nanotech Applications');
    }

    public function test_search_filters_by_abstract(): void
    {
        $this->createPublished(['abstract' => 'This study examines climate change effects.']);
        $this->createPublished(['abstract' => 'A review of semiconductor materials.']);

        $this->getJson('/api/v1/articles?search=climate')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_sort_by_citation_count(): void
    {
        $this->createPublished(['title' => 'High Citations', 'citation_count' => 150]);
        $this->createPublished(['title' => 'Low Citations', 'citation_count' => 5]);

        $this->getJson('/api/v1/articles?sort=-citation_count')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'High Citations');
    }

    public function test_per_page_max_is_50(): void
    {
        $this->createPublished();

        $this->getJson('/api/v1/articles?per_page=100')
            ->assertOk()
            ->assertJsonPath('meta.per_page', 50);
    }

    public function test_pagination_meta(): void
    {
        Article::factory()->count(15)->create([
            'journal_id' => $this->journal->id,
            'article_type_id' => $this->type->id,
            'status' => 'published',
        ]);

        $response = $this->getJson('/api/v1/articles?per_page=10');

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.total', 15)
            ->assertJsonPath('meta.last_page', 2);
    }

    public function test_inactive_journal_articles_returns_404(): void
    {
        $inactiveJournal = Journal::factory()->create(['is_active' => false]);

        $this->getJson("/api/v1/journals/{$inactiveJournal->id}/articles")
            ->assertNotFound();
    }

    public function test_missing_article_returns_404(): void
    {
        $this->getJson('/api/v1/articles/nonexistent-slug')
            ->assertNotFound();
    }
}

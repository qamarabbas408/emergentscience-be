<?php

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'article_type_id',
        'title',
        'abstract',
        'keywords',
        'doi',
        'slug',
        'status',
        'language',
        'volume',
        'issue',
        'page_start',
        'page_end',
        'publication_date',
        'date_submitted',
        'date_accepted',
        'view_count',
        'download_count',
        'citation_count',
    ];

    protected function casts(): array
    {
        return [
            'keywords' => 'array',
            'publication_date' => 'date',
            'date_submitted' => 'date',
            'date_accepted' => 'date',
            'view_count' => 'integer',
            'download_count' => 'integer',
            'citation_count' => 'integer',
        ];
    }

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    public function articleType(): BelongsTo
    {
        return $this->belongsTo(ArticleType::class);
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'article_topics');
    }

    public function authors(): HasMany
    {
        return $this->hasMany(ArticleAuthor::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ArticleFile::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

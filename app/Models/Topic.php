<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'is_active',
        'sort_order',
        'submission_deadline',
    ];

    public function journals(): BelongsToMany
    {
        return $this->belongsToMany(Journal::class, 'journal_topics');
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_topics');
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'submission_deadline' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}

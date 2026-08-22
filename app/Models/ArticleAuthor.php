<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleAuthor extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'name',
        'email',
        'orcid',
        'affiliation',
        'sort_order',
        'is_corresponding',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_corresponding' => 'boolean',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
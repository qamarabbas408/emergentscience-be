<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = [
        'article_id',
        'round',
        'status',
        'cover_letter',
        'submitted_at',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'round' => 'integer',
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(ArticleFile::class);
    }
}

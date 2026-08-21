<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleFile extends Model
{
    protected $fillable = [
        'submission_id',
        'file_type',
        'original_name',
        'storage_path',
        'file_name',
        'file_size',
        'mime_type',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function article(): BelongsTo
    {
        return $this->hasOneThrough(
            Article::class,
            Submission::class,
            'id',       // submissions.id
            'id',       // articles.id
            'submission_id', // article_files.submission_id
            'article_id'     // submissions.article_id
        );
    }
}

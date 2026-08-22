<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expertise_keywords',
        'review_availability_status',
        'max_concurrent_reviews',
        'total_reviews_completed',
        'average_review_time_days',
        'rating_score',
    ];

    protected $casts = [
        'expertise_keywords' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'corresponding_email',
        'department',
        'research_interests',
        'funding_sources',
        'co_author_history',
    ];

    protected $casts = [
        'research_interests' => 'array',
        'funding_sources' => 'array',
        'co_author_history' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
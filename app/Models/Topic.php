<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['journal_id', 'slug', 'title', 'description', 'is_active', 'sort_order'])]
class Topic extends Model
{
    use HasFactory;

    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}

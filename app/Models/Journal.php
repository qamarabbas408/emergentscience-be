<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'title', 'abbreviation', 'issn', 'eissn', 'doi_prefix', 'discipline_category_id', 'discipline', 'license', 'scope', 'is_active', 'apc_amount', 'apc_currency'])]
class Journal extends Model
{
    use HasFactory;

    public function disciplineCategory(): BelongsTo
    {
        return $this->belongsTo(DisciplineCategory::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'apc_amount' => 'decimal:2',
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'title', 'tagline', 'abbreviation', 'issn', 'eissn', 'doi_prefix', 'discipline', 'license', 'scope', 'is_active', 'apc_amount', 'apc_currency'])]
class Journal extends Model
{
    use HasFactory;

    public function disciplineCategories(): BelongsToMany
    {
        return $this->belongsToMany(DisciplineCategory::class)->withTimestamps();
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

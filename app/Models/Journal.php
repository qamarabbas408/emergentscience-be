<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'abbreviation', 'issn', 'eissn', 'doi_prefix', 'discipline', 'license', 'scope', 'is_active', 'apc_amount', 'apc_currency'])]
class Journal extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'apc_amount' => 'decimal:2',
        ];
    }
}

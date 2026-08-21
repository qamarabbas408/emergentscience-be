<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'name',
        'description',
        'sort_order',
        'is_active',
        'max_word_count',
        'max_summary_words',
        'max_figures_tables',
        'file_requirements',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'max_word_count' => 'integer',
            'max_summary_words' => 'integer',
            'max_figures_tables' => 'integer',
            'file_requirements' => 'array',
        ];
    }
}

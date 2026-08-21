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
        ];
    }

    public function setFileRequirementsAttribute($value): void
    {
        if (is_array($value) && array_is_list($value)) {
            $result = [];
            foreach ($value as $item) {
                $key = $item['key'] ?? null;
                if ($key) {
                    $result[$key] = [
                        'enabled' => (bool) ($item['enabled'] ?? false),
                        'max_size_mb' => (int) ($item['max_size_mb'] ?? 50),
                        'extensions' => $item['extensions'] ?? [],
                    ];
                }
            }
            $this->attributes['file_requirements'] = json_encode($result);
        } else {
            $this->attributes['file_requirements'] = is_string($value) ? $value : json_encode($value);
        }
    }

    public function getFileRequirementsAttribute($value): array
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return $value ?? [];
    }
}

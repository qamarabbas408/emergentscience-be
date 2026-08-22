<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EditorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'editor_type',
        'assigned_journal_id',
        'section_id',
        'decision_permission_level',
        'active_manuscript_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedJournal(): BelongsTo
    {
        return $this->belongsTo(Journal::class, 'assigned_journal_id');
    }
}
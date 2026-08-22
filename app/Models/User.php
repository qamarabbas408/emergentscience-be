<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'first_name', 'middle_name', 'last_name', 'title',
        'primary_affiliation', 'country', 'city', 'postal_code',
        'orcid_id', 'biography',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => \App\Enums\UserStatus::class,
        ];
    }

    public function authorProfile(): HasOne
    {
        return $this->hasOne(AuthorProfile::class);
    }

    public function reviewerProfile(): HasOne
    {
        return $this->hasOne(ReviewerProfile::class);
    }

    public function editorProfile(): HasOne
    {
        return $this->hasOne(EditorProfile::class);
    }

    public function isAuthor(): bool
    {
        return $this->authorProfile()->exists();
    }

    public function isReviewer(): bool
    {
        return $this->reviewerProfile()->exists();
    }

    public function isEditor(): bool
    {
        return $this->editorProfile()->exists();
    }

    public function getRoleNames(): array
    {
        $roles = [];
        if ($this->isAuthor()) $roles[] = 'author';
        if ($this->isReviewer()) $roles[] = 'reviewer';
        if ($this->isEditor()) $roles[] = 'editor';
        return $roles;
    }

    public function getFullName(): string
    {
        $parts = array_filter([$this->title, $this->first_name, $this->middle_name, $this->last_name]);
        return $parts ? implode(' ', $parts) : $this->name;
    }
}
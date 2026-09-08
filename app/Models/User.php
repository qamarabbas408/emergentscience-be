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
        'orcid_id', 'biography', 'roles',
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
            'roles' => 'array',
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
        return in_array('author', $this->roles ?? []);
    }

    public function isReviewer(): bool
    {
        return in_array('reviewer', $this->roles ?? []);
    }

    public function isEditor(): bool
    {
        return in_array('editor', $this->roles ?? []);
    }

    public function getRoleNames(): array
    {
        return $this->roles ?? ['author'];
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles ?? []);
    }

    public function addRole(string $role): void
    {
        $roles = $this->roles ?? [];
        if (! in_array($role, $roles)) {
            $roles[] = $role;
            $this->roles = $roles;
            $this->save();
        }
    }

    public function removeRole(string $role): void
    {
        $roles = array_diff($this->roles ?? [], [$role]);
        $this->roles = empty($roles) ? ['author'] : array_values($roles);
        $this->save();
    }

    public function getFullName(): string
    {
        $parts = array_filter([$this->title, $this->first_name, $this->middle_name, $this->last_name]);
        return $parts ? implode(' ', $parts) : $this->name;
    }
}
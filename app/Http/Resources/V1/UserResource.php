<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'roles' => $this->roles,
            'created_at' => $this->created_at,

            // Core Identity
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'title' => $this->title,
            'primary_affiliation' => $this->primary_affiliation,
            'country' => $this->country,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'orcid_id' => $this->orcid_id,
            'biography' => $this->biography,
            'email_verified_at' => $this->email_verified_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
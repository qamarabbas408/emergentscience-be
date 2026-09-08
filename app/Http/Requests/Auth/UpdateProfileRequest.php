<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'first_name' => ['sometimes', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:20'],
            'primary_affiliation' => ['nullable', 'string', 'max:500'],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'orcid_id' => ['nullable', 'string', 'max:19', 'unique:users,orcid_id,' . $userId],
            'biography' => ['nullable', 'string', 'max:5000'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
        ];
    }
}

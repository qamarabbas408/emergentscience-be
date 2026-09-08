<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorProfileRequest extends FormRequest
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
        return [
            'corresponding_email' => ['nullable', 'string', 'email', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'research_interests' => ['nullable', 'array', 'max:20'],
            'research_interests.*' => ['string', 'max:100'],
            'funding_sources' => ['nullable', 'array'],
            'funding_sources.*' => ['array'],
            'funding_sources.*.name' => ['required_with:funding_sources.*', 'string', 'max:255'],
            'funding_sources.*.source' => ['nullable', 'string', 'max:255'],
            'funding_sources.*.amount' => ['nullable', 'string', 'max:100'],
            'funding_sources.*.year' => ['nullable', 'string', 'max:4'],
            'co_author_history' => ['nullable', 'array', 'max:20'],
            'co_author_history.*' => ['string', 'max:200'],
        ];
    }
}

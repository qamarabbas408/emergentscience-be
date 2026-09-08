<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewerProfileRequest extends FormRequest
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
            'expertise_keywords' => ['nullable', 'array', 'max:20'],
            'expertise_keywords.*' => ['string', 'max:255'],
            'review_availability_status' => ['nullable', 'string', 'in:Available,On Leave,Max Capacity'],
            'max_concurrent_reviews' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }
}

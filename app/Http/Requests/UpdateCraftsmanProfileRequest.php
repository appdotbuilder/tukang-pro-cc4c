<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCraftsmanProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (
            auth()->user()->id === $this->route('craftsman')->user_id ||
            auth()->user()->role === 'admin'
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => 'required|string|max:1000',
            'years_experience' => 'required|integer|min:0|max:50',
            'hourly_rate' => 'required|numeric|min:0|max:999.99',
            'location' => 'required|string|max:255',
            'work_areas' => 'required|array|min:1',
            'work_areas.*' => 'string|max:255',
            'insurance_rate' => 'nullable|numeric|min:0|max:20',
            'is_available' => 'boolean',
            'skills' => 'nullable|array',
            'skills.*.skill_id' => 'required|exists:skills,id',
            'skills.*.certification_id' => 'nullable|exists:certifications,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'bio.required' => 'Please provide a bio describing your experience.',
            'years_experience.required' => 'Years of experience is required.',
            'hourly_rate.required' => 'Please specify your hourly rate.',
            'location.required' => 'Location is required.',
            'work_areas.required' => 'Please specify at least one work area.',
        ];
    }
}
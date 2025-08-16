<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skill_id' => 'required|exists:skills,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location' => 'required|string|max:255',
            'estimated_budget' => 'nullable|numeric|min:0|max:9999999.99',
            'preferred_date' => 'nullable|date|after:now',
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
            'skill_id.required' => 'Please select a skill category.',
            'title.required' => 'Service title is required.',
            'description.required' => 'Please provide a detailed description.',
            'location.required' => 'Location is required.',
            'preferred_date.after' => 'Preferred date must be in the future.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniversityUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'university_name' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'partner_type' => ['required', 'in:Partner,Non-Partner'],
            'programs' => ['required', 'integer'],
            'application_fee' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student' => ['required', 'string'],
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'course' => ['required', 'string'],
            'applied_university' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'application' => ['required', 'in:Approved,Pending,Under Review'],
            'counselor' => ['nullable', 'string'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
            ]
        ];
    }
}

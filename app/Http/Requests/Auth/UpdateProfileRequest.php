<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [

            'name' => ['sometimes', 'required', 'string', 'max:255'],

            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($userId),
            ],

            'faculty' => ['nullable', 'string', 'max:255'],

            'study_program' => ['nullable', 'string', 'max:255'],

            'gender' => ['nullable', 'in:L,P'],

            'address' => ['nullable', 'string', 'max:255'],

            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

        ];
    }
}

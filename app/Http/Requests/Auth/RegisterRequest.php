<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [

            'nim' => [
                'required',
                'string',
                'max:20',
                'unique:users,nim'
            ],

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
                'ends_with:@uin-alauddin.ac.id'
            ],

            'phone' => [
                'required',
                'string',
                'min:10',
                'max:20',
                'unique:users,phone'
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ]

        ];
    }

    /**
     * Custom error message.
     */
    public function messages(): array
    {
        return [

            'nim.required' => 'NIM wajib diisi.',

            'nim.unique' => 'NIM sudah digunakan.',

            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',

            'email.email' => 'Format email tidak valid.',

            'email.unique' => 'Email sudah digunakan.',

            'email.ends_with' => 'Gunakan email resmi UIN Alauddin.',

            'phone.required' => 'Nomor WhatsApp wajib diisi.',

            'phone.unique' => 'Nomor WhatsApp sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ];
    }
}
<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
{
    $this->merge([
        'is_anonymous' => filter_var(
            $this->is_anonymous,
            FILTER_VALIDATE_BOOLEAN
        ),
    ]);
}
    public function rules(): array
    {
        return [

            'category_id' => [
                'required',
                'exists:categories,id'
            ],

            'type' => [
                'required',
                'in:lost,found'
            ],

            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string'
            ],

            'location_name' => [
                'required',
                'string',
                'max:255'
            ],

            'address' => [
                'nullable',
                'string'
            ],

            'latitude' => [
                'nullable',
                'numeric'
            ],

            'longitude' => [
                'nullable',
                'numeric'
            ],

            'brand' => [
                'nullable',
                'string',
                'max:100'
            ],

            'color' => [
                'nullable',
                'string',
                'max:100'
            ],

            'incident_date' => [
                'required',
                'date'
            ],

            'contact_phone' => [
                'required',
                'string',
                'max:20'
            ],

            'is_anonymous' => [
                'required',
                'boolean'
            ],

            'images' => [
                'required',
                'array',
                'min:1',
                'max:5'
            ],

            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

        ];
    }
}
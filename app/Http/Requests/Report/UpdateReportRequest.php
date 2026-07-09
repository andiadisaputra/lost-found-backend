<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('is_anonymous')) {
            $this->merge([
                'is_anonymous' => filter_var(
                    $this->is_anonymous,
                    FILTER_VALIDATE_BOOLEAN
                ),
            ]);
        }
    }

    public function rules(): array
    {
        return [

            'category_id' => [
                'sometimes',
                'required',
                'exists:categories,id'
            ],

            'type' => [
                'sometimes',
                'required',
                'in:lost,found'
            ],

            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'sometimes',
                'required',
                'string'
            ],

            'location_name' => [
                'sometimes',
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
                'sometimes',
                'required',
                'date'
            ],

            'status' => [
                'sometimes',
                'required',
                'in:open,claimed,closed'
            ],

            'contact_phone' => [
                'sometimes',
                'required',
                'string',
                'max:20'
            ],

            'is_anonymous' => [
                'sometimes',
                'required',
                'boolean'
            ],

            'images' => [
                'nullable',
                'array',
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

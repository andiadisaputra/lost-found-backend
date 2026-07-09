<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'nim' => $this->nim,

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'photo' => $this->photo ? asset('storage/' . $this->photo) : null,

            'faculty' => $this->faculty,

            'study_program' => $this->study_program,

            'gender' => $this->gender,

            'address' => $this->address,

            'is_verified' => $this->is_verified,

            'created_at' => $this->created_at,
        ];
    }
}
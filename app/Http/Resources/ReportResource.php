<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'type' => $this->type,

            'title' => $this->title,

            'description' => $this->description,

            'location_name' => $this->location_name,

            'address' => $this->address,

            'latitude' => $this->latitude,

            'longitude' => $this->longitude,

            'brand' => $this->brand,

            'color' => $this->color,

            'incident_date' => $this->incident_date,

            'status' => $this->status,

            'contact_phone' => $this->contact_phone,

            'is_anonymous' => $this->is_anonymous,

            'category' => $this->category,

            'images' => $this->images->map(function ($image) {
                return asset('storage/' . $image->image);
            }),

            'is_owner' => $request->user()
                ? $request->user()->id === $this->user_id
                : false,

            'user' => $this->is_anonymous
                ? null
                : [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'phone' => $this->contact_phone ?? $this->user->phone,
                ],

            'created_at' => $this->created_at,
        ];
    }
}
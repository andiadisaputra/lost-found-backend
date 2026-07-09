<?php

namespace App\Services\Report;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
class ReportService
{
    public function store(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {

            $report = Report::create([
                'user_id' => $user->id,
                'category_id' => $data['category_id'],
                'type' => $data['type'],
                'title' => $data['title'],
                'description' => $data['description'],
                'location_name' => $data['location_name'],
                'address' => $data['address'] ?? null,
                'brand' => $data['brand'] ?? null,
                'color' => $data['color'] ?? null,
                'incident_date' => $data['incident_date'],
                'contact_phone' => $data['contact_phone'],
                'is_anonymous' => $data['is_anonymous'],
            ]);

            foreach ($data['images'] as $image) {

                $path = $image->store('reports', 'public');

                $report->images()->create([
                    'image' => $path
                ]);

            }

            return $report->load([
                'category',
                'images',
                'user'
            ]);

        });
    }
    public function index()
{
    return Report::with([
        'category',
        'images',
        'user'
    ])
    ->latest()
    ->paginate(10);
}
}
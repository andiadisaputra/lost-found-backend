<?php

namespace App\Services\Report;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
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

            return $report;
        });
    }

    public function update(Report $report, array $data)
    {
        return DB::transaction(function () use ($report, $data) {

            $report->update(array_filter([
                'category_id' => $data['category_id'] ?? null,
                'type' => $data['type'] ?? null,
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'location_name' => $data['location_name'] ?? null,
                'address' => $data['address'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'brand' => $data['brand'] ?? null,
                'color' => $data['color'] ?? null,
                'incident_date' => $data['incident_date'] ?? null,
                'status' => $data['status'] ?? null,
                'contact_phone' => $data['contact_phone'] ?? null,
                'is_anonymous' => $data['is_anonymous'] ?? null,
            ], fn ($value) => !is_null($value)));

            if (!empty($data['images'])) {

                // Hapus foto lama & ganti dengan yang baru
                foreach ($report->images as $old) {
                    Storage::disk('public')->delete($old->image);
                    $old->delete();
                }

                foreach ($data['images'] as $image) {
                    $path = $image->store('reports', 'public');

                    $report->images()->create([
                        'image' => $path
                    ]);
                }
            }

            return $report->fresh(['category', 'images', 'user']);
        });
    }

    public function delete(Report $report)
    {
        return DB::transaction(function () use ($report) {

            foreach ($report->images as $image) {
                Storage::disk('public')->delete($image->image);
            }

            return $report->delete();
        });
    }

    public function show(Report $report)
    {
        return $report->load([
            'category',
            'images',
            'user'
        ]);
    }

    public function index(array $filters = [])
    {
        return $this->baseQuery($filters)
            ->latest()
            ->paginate(10);
    }

    public function myReports($userId, array $filters = [])
    {
        return $this->baseQuery($filters)
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);
    }

    protected function baseQuery(array $filters = [])
    {
        $query = Report::with([
            'category',
            'images',
            'user'
        ]);

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location_name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query;
    }
}

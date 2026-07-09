<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'title',
        'description',
        'location_name',
        'address',
        'latitude',
        'longitude',
        'brand',
        'color',
        'incident_date',
        'status',
        'is_anonymous',
        'contact_phone',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'is_anonymous' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function claims()
    {
        return $this->hasMany(ClaimRequest::class);
    }
}
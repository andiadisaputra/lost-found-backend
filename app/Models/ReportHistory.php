<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'status',
        'description',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
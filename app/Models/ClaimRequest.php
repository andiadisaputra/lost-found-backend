<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimRequest extends Model
{
    protected $fillable = [
        'report_id',
        'claimer_id',
        'message',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function claimer()
    {
        return $this->belongsTo(User::class, 'claimer_id');
    }
}
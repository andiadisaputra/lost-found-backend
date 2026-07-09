<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nim',
        'name',
        'email',
        'phone',
        'photo',
        'faculty',
        'study_program',
        'gender',
        'address',
        'password',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function claimRequests()
    {
        return $this->hasMany(ClaimRequest::class);
    }
    public function claims()
{
    return $this->hasMany(ClaimRequest::class, 'claimer_id');
}
}
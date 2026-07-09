<?php

namespace App\Services\CampusLocation;

use App\Models\CampusLocation;

class CampusLocationService
{
    public function all()
    {
        return CampusLocation::orderBy('name')->get();
    }
}
<?php

namespace App\Http\Controllers\Api\CampusLocation;

use App\Http\Controllers\Controller;
use App\Http\Resources\CampusLocationResource;
use App\Services\CampusLocation\CampusLocationService;

class CampusLocationController extends Controller
{
    public function __construct(
        protected CampusLocationService $campusLocationService
    ){}

    public function index()
    {
        return CampusLocationResource::collection(
            $this->campusLocationService->all()
        );
    }
}
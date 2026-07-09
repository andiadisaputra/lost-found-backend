<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\CampusLocation\CampusLocationController;
use App\Http\Controllers\Api\Report\ReportController;
use App\Http\Controllers\Api\Profile\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

    Route::post('/login', [AuthController::class, 'login']);

});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::match(['put', 'post'], '/profile/update', [ProfileController::class, 'update']);

    // Master Data
    Route::get('/categories', [CategoryController::class, 'index']);

    Route::get('/campus-locations', [CampusLocationController::class, 'index']);

    // Reports
    Route::post('/reports', [ReportController::class, 'store']);

    Route::get('/reports', [ReportController::class, 'index']);

    Route::get('/reports/my', [ReportController::class, 'myReports']);

    Route::get('/reports/{report}', [ReportController::class, 'show']);

    // Pakai match PUT/POST agar upload foto (multipart) saat edit tetap berfungsi
    Route::match(['put', 'post'], '/reports/{report}/update', [ReportController::class, 'update']);

    Route::delete('/reports/{report}', [ReportController::class, 'destroy']);

});
<?php

use App\Http\Controllers\Api\ActivityCategoryController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\TripPlanController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\GalleryCityController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Admin controllers
use App\Http\Controllers\Admin\AdminCountryController;
use App\Http\Controllers\Admin\AdminGalleryCityController;
use App\Http\Controllers\Admin\AdminLocationController;
use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminActivityCategoryController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public Routes
Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{slug}', [CountryController::class, 'show']);
Route::get('/gallery-cities', [GalleryCityController::class, 'index']);
Route::get('/locations', [LocationController::class, 'index']);
Route::get('/activity-categories', [ActivityCategoryController::class, 'index']);
Route::get('/activities', [ActivityController::class, 'index']);
Route::get('/activities/{slug}', [ActivityController::class, 'show']);
Route::post('/trip-plans', [TripPlanController::class, 'store'])->name('trip-plans.store');
Route::post('/subscriptions', [SubscriptionController::class, 'store']);

// Admin Routes
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('countries', \App\Http\Controllers\Admin\AdminCountryController::class);
    Route::apiResource('gallery-cities', \App\Http\Controllers\Admin\AdminGalleryCityController::class);
    Route::apiResource('locations', \App\Http\Controllers\Admin\AdminLocationController::class);
    Route::apiResource('activities', \App\Http\Controllers\Admin\AdminActivityController::class);
    Route::apiResource('activity-categories', \App\Http\Controllers\Admin\AdminActivityCategoryController::class);
    Route::apiResource('trip-plans', \App\Http\Controllers\Admin\AdminTripPlanController::class);
    Route::get('subscriptions', [\App\Http\Controllers\Admin\SubscriptionController::class, 'index']);
    Route::get('dashboard', [DashboardController::class, 'index']);
});

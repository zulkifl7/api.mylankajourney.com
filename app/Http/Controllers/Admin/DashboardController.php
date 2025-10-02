<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use App\Http\Controllers\Controller;
use App\Models\TripPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalBookings = TripPlan::count();
            $totalCountries = TripPlan::distinct('country')->count('country');

            $bookingTrends = TripPlan::select(
                DB::raw('strftime("%b", created_at) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->get();

            $bookingsByCountry = TripPlan::select(
                'country as name',
                DB::raw('count(*) as value')
            )
            ->groupBy('name')
            ->get();

            $popularActivities = Activity::withCount('tripPlans')
                ->orderBy('trip_plans_count', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($activity) {
                    return [
                        'name' => $activity->title,
                        'value' => $activity->trip_plans_count,
                    ];
                });

            $recentBookings = TripPlan::latest()->limit(5)->get();

            return response()->json([
                'totalBookings' => $totalBookings,
                'totalCountries' => $totalCountries,
                'bookingTrends' => $bookingTrends,
                'bookingsByCountry' => $bookingsByCountry,
                'popularActivities' => $popularActivities,
                'recentBookings' => $recentBookings,
            ]);
        } catch (\Exception $e) {
            Log::channel('custom')->error($e->getMessage());
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }
}
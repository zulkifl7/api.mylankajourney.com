<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TripPlan;
use Illuminate\Http\Request;

class AdminTripPlanController extends Controller
{
    public function index()
    {
        return TripPlan::all();
    }

    public function show(TripPlan $tripPlan)
    {
        return $tripPlan->load('activities.location');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'no_of_adults' => 'sometimes|integer|min:1',
            'no_of_children' => 'sometimes|integer|min:0',
            'preferred_travel_date' => 'sometimes|date',
            'message' => 'nullable|string',
            'activities' => 'sometimes|json',
            'hotel_preference' => 'nullable|string',
            'food_preference' => 'nullable|string',
            'vehicle_preference' => 'nullable|string',
            'special_requests' => 'nullable|string',
        ]);

        try {
            $tripPlan = TripPlan::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Trip plan created successfully',
                'data' => $tripPlan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create trip plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, TripPlan $tripPlan)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'sometimes|string|max:255',
            'country' => 'sometimes|string|max:255',
            'no_of_adults' => 'sometimes|integer|min:1',
            'no_of_children' => 'sometimes|integer|min:0',
            'preferred_travel_date' => 'sometimes|date',
            'message' => 'nullable|string',
            'activities' => 'sometimes|json',
            'hotel_preference' => 'nullable|string',
            'food_preference' => 'nullable|string',
            'vehicle_preference' => 'nullable|string',
            'special_requests' => 'nullable|string',
        ]);

        try {
            $tripPlan->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Trip plan updated successfully',
                'data' => $tripPlan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update trip plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(TripPlan $tripPlan)
    {
        try {
            $tripPlan->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Trip plan deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete trip plan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
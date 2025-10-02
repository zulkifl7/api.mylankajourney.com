<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TripPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TripPlanController extends Controller
{
    public function index()
    {
        return TripPlan::all();
    }

    public function show(TripPlan $tripPlan)
    {
        return $tripPlan;
    }

    public function store(Request $request)
    {
        Log::info('Trip plan creation request received', ['request' => $request->all()]);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'preferred_travel_date' => 'required|date',
            'no_of_travelers' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
            'hotel_preferences' => 'required|string|max:255',
            'food_preferences' => 'required|string|max:255',
            'vehicle_preferences' => 'nullable|string|max:255',
            'activities' => 'required|array',
            'activities.*' => 'integer|exists:activities,id',
        ]);

        Log::info('Validation successful', ['validated_data' => $validated]);

        try {
            Log::info('Attempting to create TripPlan');
            $tripPlan = TripPlan::create($validated);
            Log::info('TripPlan created successfully', ['trip_plan_id' => $tripPlan->id]);

            Log::info('Attempting to attach activities', ['activities' => $validated['activities']]);
            $tripPlan->activities()->attach($validated['activities']);
            Log::info('Activities attached successfully');

            return response()->json([
                'success' => true,
                'message' => 'Trip plan created successfully',
                'data' => $tripPlan->load('activities')
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create trip plan', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
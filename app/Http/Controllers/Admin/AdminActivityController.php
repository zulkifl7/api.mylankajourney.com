<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class AdminActivityController extends Controller
{
    public function index()
    {
        return Activity::with(['location', 'activityCategory'])->get();
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:activities,slug',
                'description' => 'required|string',
                'duration' => 'required|string',
                'image' => 'nullable|string',
                'price' => 'required|numeric',
                'location_id' => 'required|integer|exists:locations,id',
                'activity_category_id' => 'required|integer|exists:activity_categories,id',
            ]);

            // Insert directly into the database
            $data = [
                'title' => $validated['title'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'duration' => $validated['duration'],
                'price' => $validated['price'],
                'location_id' => $validated['location_id'],
                'activity_category_id' => $validated['activity_category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Add image if provided
            if (isset($validated['image'])) {
                $data['image'] = $validated['image'];
            } else {
                $data['image'] = 'default-activity-image.jpg'; // Default image
            }

            $id = \DB::table('activities')->insertGetId($data);

            // Get the newly created activity
            $activity = Activity::with(['location', 'activityCategory'])->find($id);

            if (!$activity) {
                return response()->json(['error' => 'Failed to retrieve created activity'], 500);
            }

            return response()->json($activity, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create activity: ' . $e->getMessage()], 500);
        }
    }

    public function show(Activity $activity)
    {
        return $activity->load(['location', 'activityCategory']);
    }

    public function update(Request $request, Activity $activity)
    {
        try {
            // Log the incoming request data
            \Log::info('Activity update request data:', $request->all());

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'slug' => 'sometimes|required|string|max:255|unique:activities,slug,' . $activity->id,
                'description' => 'sometimes|required|string',
                'duration' => 'sometimes|required|string',
                'image' => 'sometimes|nullable|string',
                'price' => 'sometimes|required|numeric',
                'location_id' => 'sometimes|required|integer|exists:locations,id',
                'activity_category_id' => 'sometimes|required|integer|exists:activity_categories,id',
            ]);

            // Log validated data
            \Log::info('Validated activity update data:', $validated);

            // Update directly using DB to ensure it works
            \DB::table('activities')
                ->where('id', $activity->id)
                ->update(array_merge(
                    $validated,
                    ['updated_at' => now()]
                ));

            // Refresh the model
            $updatedActivity = Activity::with(['location', 'activityCategory'])->find($activity->id);

            \Log::info('Activity updated with ID: ' . $activity->id);

            return response()->json($updatedActivity, 200);
        } catch (\Exception $e) {
            \Log::error('Failed to update activity: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update activity: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return response()->json(null, 204);
    }
}
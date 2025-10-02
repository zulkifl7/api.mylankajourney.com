<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;

class AdminActivityCategoryController extends Controller
{
    public function index()
    {
        return ActivityCategory::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:activity_categories,slug',
            'image_url' => 'nullable|string|max:2048',
        ]);

        $activityCategory = ActivityCategory::create($validated);

        return response()->json($activityCategory, 201);
    }

    public function show(ActivityCategory $activityCategory)
    {
        return $activityCategory;
    }

    public function update(Request $request, ActivityCategory $activityCategory)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|max:255|unique:activity_categories,slug,' . $activityCategory->id,
            'image_url' => 'nullable|string|max:2048',
        ]);

        $activityCategory->update($validated);

        return response()->json($activityCategory);
    }

    public function destroy(ActivityCategory $activityCategory)
    {
        $activityCategory->delete();

        return response()->json(null, 204);
    }
}
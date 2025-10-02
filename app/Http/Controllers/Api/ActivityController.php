<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Activity::with(['location', 'activityCategory']);

        if ($request->has('location_id')) {
            $query->where('location_id', $request->input('location_id'));
        }

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function show(string $slug)
    {
        $activity = Activity::where('slug', $slug)->firstOrFail();
        $activity->load(['location', 'activityCategory']);
        return $activity;
    }

    /**
     * Update the specified resource in storage.
     */
}
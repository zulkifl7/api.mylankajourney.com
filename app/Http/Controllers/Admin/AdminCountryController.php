<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class AdminCountryController extends Controller
{
    public function index()
    {
        return Country::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:countries',
            'flag' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'poster_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'timezone' => 'nullable|string|max:255',
        ]);

        $country = Country::create($validated);

        return response()->json($country, 201);
    }

    public function show(Country $country)
    {
        return $country;
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:countries,slug,' . $country->id,
            'flag' => 'nullable|string',
            'currency' => 'nullable|string',
            'image' => 'nullable|string',
            'video_url' => 'nullable|string',
            'poster_url' => 'nullable|string',
            'description' => 'nullable|string',
            'timezone' => 'nullable|string',
            'isActive' => 'sometimes|boolean',
        ]);

        // Ensure description is never null
        if (!isset($validated['description']) || $validated['description'] === null) {
            $validated['description'] = '';
        }

        $country->update($validated);

        return response()->json($country);
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json(null, 204);
    }
}
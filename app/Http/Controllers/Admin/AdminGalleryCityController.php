<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryCity;
use Illuminate\Http\Request;

class AdminGalleryCityController extends Controller
{
    public function index()
    {
        return GalleryCity::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'alt' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $galleryCity = GalleryCity::create($validated);

        return response()->json($galleryCity, 201);
    }

    public function show(GalleryCity $galleryCity)
    {
        return $galleryCity;
    }

    public function update(Request $request, GalleryCity $galleryCity)
    {
        $validated = $request->validate([
            'city' => 'string|max:255',
            'image' => 'string|max:255',
            'alt' => 'string|max:255',
            'type' => 'string|max:255',
        ]);

        // Only update fields that are present in the request
        if (!empty($validated)) {
            $galleryCity->update($validated);
            // Refresh the model to get the updated data
            $galleryCity->refresh();
        }

        // Return the full updated gallery city object
        return $galleryCity;
    }

    public function destroy(GalleryCity $galleryCity)
    {
        $galleryCity->delete();

        return response()->json([
            'message' => 'Gallery city deleted successfully',
            'deleted' => true
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryCity;
use Illuminate\Http\Request;

class GalleryCityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GalleryCity::all();
    }
}

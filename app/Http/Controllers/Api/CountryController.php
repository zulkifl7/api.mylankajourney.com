<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        return Country::all();
    }

    public function show($slug)
    {
        return Country::where('slug', $slug)->firstOrFail();
    }
}

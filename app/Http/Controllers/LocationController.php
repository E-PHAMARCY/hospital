<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::where('is_active', true)->orderBy('sort_order')->get();
        return view('locations.index', compact('locations'));
    }

    public function show(string $slug): View
    {
        $location = Location::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('locations.show', compact('location'));
    }
}

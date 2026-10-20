<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Location::orderBy('sort_order');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_sw', 'like', "%{$search}%")
                  ->orWhere('address_en', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $locations = $query->paginate(12)->withQueryString();

        return view('admin.locations.index', compact('locations', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'address_en' => ['required', 'string', 'max:255'],
            'address_sw' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'opening_hours_en' => ['required', 'string', 'max:150'],
            'opening_hours_sw' => ['nullable', 'string', 'max:150'],
            'google_map_url' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'is_main' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Location::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'branch_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/locations'), $filename);
            $validated['image'] = 'uploads/locations/' . $filename;
        } else {
            $validated['image'] = 'images/branch_upanga_campus.jpg';
        }

        $validated['is_main'] = $request->boolean('is_main');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (Location::max('sort_order') ?? 0) + 1;

        Location::create($validated);

        return back()->with('success', "Hospital campus '{$validated['name_en']}' added successfully.");
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'address_en' => ['required', 'string', 'max:255'],
            'address_sw' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'opening_hours_en' => ['required', 'string', 'max:150'],
            'opening_hours_sw' => ['nullable', 'string', 'max:150'],
            'google_map_url' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'is_main' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'branch_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/locations'), $filename);
            $validated['image'] = 'uploads/locations/' . $filename;
        }

        $validated['is_main'] = $request->boolean('is_main');
        $validated['is_active'] = $request->boolean('is_active');

        $location->update($validated);

        return back()->with('success', "Campus '{$location->name_en}' updated successfully.");
    }

    public function toggleStatus(Location $location): RedirectResponse
    {
        $location->update(['is_active' => !$location->is_active]);
        $statusText = $location->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Campus '{$location->name_en}' has been {$statusText}.");
    }

    public function destroy(Location $location): RedirectResponse
    {
        $name = $location->name_en;
        $location->delete();

        return back()->with('success', "Campus '{$name}' removed successfully.");
    }
}

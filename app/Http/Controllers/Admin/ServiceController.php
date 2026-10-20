<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Service::with('department')->orderBy('sort_order');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_sw', 'like', "%{$search}%")
                  ->orWhere('summary_en', 'like', "%{$search}%");
            });
        }

        $services = $query->paginate(15)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.services.index', compact('services', 'departments', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'summary_en' => ['required', 'string', 'max:500'],
            'summary_sw' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'color' => ['required', 'string', 'in:teal,purple,orange,red,amber,navy,blue,emerald,pink,slate'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_emergency' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        // Ensure unique slug
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Service::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        $validated['is_emergency'] = $request->boolean('is_emergency');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (Service::max('sort_order') ?? 0) + 1;

        Service::create($validated);

        return back()->with('success', "Clinical Service '{$validated['name_en']}' posted successfully.");
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'summary_en' => ['required', 'string', 'max:500'],
            'summary_sw' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'color' => ['required', 'string', 'in:teal,purple,orange,red,amber,navy,blue,emerald,pink,slate'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_emergency' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_emergency'] = $request->boolean('is_emergency');
        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return back()->with('success', "Service '{$service->name_en}' updated successfully.");
    }

    public function toggleStatus(Service $service): RedirectResponse
    {
        $service->update(['is_active' => !$service->is_active]);
        $statusText = $service->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Service '{$service->name_en}' has been {$statusText}.");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $name = $service->name_en;
        $service->delete();

        return back()->with('success', "Service '{$name}' removed successfully.");
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $query = Department::withCount(['services', 'doctors'])->orderBy('sort_order');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_en', 'like', "%{$search}%")
                  ->orWhere('name_sw', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $departments = $query->paginate(12)->withQueryString();

        return view('admin.departments.index', compact('departments', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'summary_en' => ['nullable', 'string', 'max:500'],
            'summary_sw' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'icon' => ['nullable', 'string', 'max:50'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['name_sw'])) {
            $validated['name_sw'] = $validated['name_en'];
        }
        if (empty($validated['summary_sw']) && !empty($validated['summary_en'])) {
            $validated['summary_sw'] = $validated['summary_en'];
        }
        if (empty($validated['description_sw']) && !empty($validated['description_en'])) {
            $validated['description_sw'] = $validated['description_en'];
        }

        $validated['slug'] = Str::slug($validated['name_en']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Department::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        if ($request->hasFile('image_file')) {
            $dest = public_path('uploads/departments');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'dept_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['image'] = 'uploads/departments/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (Department::max('sort_order') ?? 0) + 1;

        Department::create($validated);

        return back()->with('success', "Clinical Department '{$validated['name_en']}' established successfully.");
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:150'],
            'name_sw' => ['nullable', 'string', 'max:150'],
            'summary_en' => ['nullable', 'string', 'max:500'],
            'summary_sw' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_sw' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'icon' => ['nullable', 'string', 'max:50'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if (empty($validated['name_sw'])) {
            $validated['name_sw'] = $validated['name_en'];
        }
        if (empty($validated['summary_sw']) && !empty($validated['summary_en'])) {
            $validated['summary_sw'] = $validated['summary_en'];
        }
        if (empty($validated['description_sw']) && !empty($validated['description_en'])) {
            $validated['description_sw'] = $validated['description_en'];
        }

        if ($request->hasFile('image_file')) {
            $dest = public_path('uploads/departments');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('image_file');
            $filename = 'dept_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['image'] = 'uploads/departments/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', $department->is_active);

        $department->update($validated);

        return back()->with('success', "Department '{$department->name_en}' updated successfully.");
    }

    public function toggleStatus(Department $department): RedirectResponse
    {
        $department->update(['is_active' => !$department->is_active]);
        $statusText = $department->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Department {$department->name_en} is now {$statusText}.");
    }

    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->name_en;
        $department->delete();

        return back()->with('success', "Department '{$name}' removed.");
    }
}

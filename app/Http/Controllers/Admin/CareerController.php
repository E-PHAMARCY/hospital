<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $deptId = $request->query('department');

        $query = Career::with('department')->latest('deadline');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_sw', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($deptId) {
            $query->where('department_id', $deptId);
        }

        $careers = $query->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.careers.index', compact('careers', 'departments', 'search', 'deptId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'employment_type' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:150'],
            'deadline' => ['required', 'date'],
            'application_email' => ['nullable', 'email', 'max:150'],
            'description_en' => ['required', 'string'],
            'description_sw' => ['nullable', 'string'],
            'requirements_en' => ['nullable', 'string'],
            'requirements_sw' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['description_sw'])) {
            $validated['description_sw'] = $validated['description_en'];
        }
        if (empty($validated['requirements_sw']) && !empty($validated['requirements_en'])) {
            $validated['requirements_sw'] = $validated['requirements_en'];
        }

        $validated['slug'] = Str::slug($validated['title_en']);
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Career::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        Career::create($validated);

        return back()->with('success', "Career opening '{$validated['title_en']}' posted successfully.");
    }

    public function update(Request $request, Career $career): RedirectResponse
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:200'],
            'title_sw' => ['nullable', 'string', 'max:200'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'employment_type' => ['required', 'string', 'max:50'],
            'location' => ['required', 'string', 'max:150'],
            'deadline' => ['required', 'date'],
            'application_email' => ['nullable', 'email', 'max:150'],
            'description_en' => ['required', 'string'],
            'description_sw' => ['nullable', 'string'],
            'requirements_en' => ['nullable', 'string'],
            'requirements_sw' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['title_sw'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['description_sw'])) {
            $validated['description_sw'] = $validated['description_en'];
        }
        if (empty($validated['requirements_sw']) && !empty($validated['requirements_en'])) {
            $validated['requirements_sw'] = $validated['requirements_en'];
        }

        $validated['is_active'] = $request->boolean('is_active', $career->is_active);

        $career->update($validated);

        return back()->with('success', "Vacancy '{$career->title_en}' updated successfully.");
    }

    public function toggleStatus(Career $career): RedirectResponse
    {
        $career->update(['is_active' => !$career->is_active]);
        $statusText = $career->is_active ? 'opened' : 'closed';

        return back()->with('success', "Vacancy '{$career->title_en}' is now {$statusText}.");
    }

    public function destroy(Career $career): RedirectResponse
    {
        $title = $career->title_en;
        $career->delete();

        return back()->with('success', "Vacancy '{$title}' removed.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::where('is_active', true)
            ->withCount(['services', 'doctors'])
            ->orderBy('sort_order')
            ->paginate(12);

        return view('departments.index', compact('departments'));
    }

    public function show(string $slug): View
    {
        $department = Department::where('slug', $slug)
            ->where('is_active', true)
            ->with(['services', 'doctors'])
            ->firstOrFail();

        return view('departments.show', compact('department'));
    }
}

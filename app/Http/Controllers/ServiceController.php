<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $deptId = $request->query('department');
        $query = Service::where('is_active', true)->with('department')->orderBy('sort_order');

        if ($deptId) {
            $query->where('department_id', $deptId);
        }

        $services = $query->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();

        return view('services.index', compact('services', 'departments', 'deptId'));
    }

    public function show(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->where('is_active', true)
            ->with(['department', 'department.doctors'])
            ->firstOrFail();

        return view('services.show', compact('service'));
    }
}

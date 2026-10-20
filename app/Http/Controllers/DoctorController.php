<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $deptId = $request->query('department');
        $query = Doctor::where('is_active', true)->with('department')->orderBy('sort_order');

        if ($deptId) {
            $query->where('department_id', $deptId);
        }

        $doctors = $query->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();

        return view('doctors.index', compact('doctors', 'departments', 'deptId'));
    }

    public function show(int $id): View
    {
        $doctor = Doctor::where('id', $id)
            ->where('is_active', true)
            ->with(['department', 'department.services'])
            ->firstOrFail();

        return view('doctors.show', compact('doctor'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $deptId = $request->query('department');

        $query = Doctor::with('department')->orderBy('sort_order');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('qualification_en', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%");
            });
        }

        if ($deptId) {
            $query->where('department_id', $deptId);
        }

        $doctors = $query->paginate(12)->withQueryString();
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();

        return view('admin.doctors.index', compact('doctors', 'departments', 'search', 'deptId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'department_id' => ['required', 'exists:departments,id'],
            'qualification_en' => ['required', 'string', 'max:255'],
            'qualification_sw' => ['nullable', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:150'],
            'title_sw' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'consultation_hours' => ['nullable', 'string', 'max:150'],
            'biography_en' => ['nullable', 'string'],
            'biography_sw' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['qualification_sw'])) {
            $validated['qualification_sw'] = $validated['qualification_en'];
        }
        if (empty($validated['title_sw']) && !empty($validated['title_en'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['biography_sw']) && !empty($validated['biography_en'])) {
            $validated['biography_sw'] = $validated['biography_en'];
        }

        if ($request->hasFile('photo_file')) {
            $dest = public_path('uploads/doctors');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('photo_file');
            $filename = 'doctor_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['photo'] = 'uploads/doctors/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (Doctor::max('sort_order') ?? 0) + 1;

        Doctor::create($validated);

        return back()->with('success', "Specialist Dr. {$validated['name']} registered successfully.");
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'department_id' => ['required', 'exists:departments,id'],
            'qualification_en' => ['required', 'string', 'max:255'],
            'qualification_sw' => ['nullable', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:150'],
            'title_sw' => ['nullable', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'consultation_hours' => ['nullable', 'string', 'max:150'],
            'biography_en' => ['nullable', 'string'],
            'biography_sw' => ['nullable', 'string'],
            'photo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if (empty($validated['qualification_sw'])) {
            $validated['qualification_sw'] = $validated['qualification_en'];
        }
        if (empty($validated['title_sw']) && !empty($validated['title_en'])) {
            $validated['title_sw'] = $validated['title_en'];
        }
        if (empty($validated['biography_sw']) && !empty($validated['biography_en'])) {
            $validated['biography_sw'] = $validated['biography_en'];
        }

        if ($request->hasFile('photo_file')) {
            $dest = public_path('uploads/doctors');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file = $request->file('photo_file');
            $filename = 'doctor_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dest, $filename);
            $validated['photo'] = 'uploads/doctors/' . $filename;
        }

        $validated['is_active'] = $request->boolean('is_active', $doctor->is_active);

        $doctor->update($validated);

        return back()->with('success', "Doctor Dr. {$doctor->name} updated successfully.");
    }

    public function toggleStatus(Doctor $doctor): RedirectResponse
    {
        $doctor->update(['is_active' => !$doctor->is_active]);
        $statusText = $doctor->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Doctor {$doctor->name} has been {$statusText}.");
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $name = $doctor->name;
        $doctor->delete();

        return back()->with('success', "Doctor Dr. {$name} removed successfully.");
    }
}

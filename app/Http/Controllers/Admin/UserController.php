<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $role = $request->query('role');

        $query = User::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->paginate(15)->withQueryString();

        $roles = [
            'super_admin' => 'Super Administrator',
            'admin' => 'System Administrator',
            'staff' => 'General Triage Staff',
            'dept_manager' => 'Clinical Department Manager',
            'appointment_officer' => 'Appointment Officer',
            'content_editor' => 'Communications & Content Editor',
            'doctor' => 'Attending Physician',
        ];

        return view('admin.users.index', compact('users', 'roles', 'search', 'role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'string', 'in:super_admin,admin,staff,dept_manager,appointment_officer,content_editor,doctor'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        User::create($validated);

        return back()->with('success', "Staff account for '{$validated['name']}' created successfully.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'string', 'in:super_admin,admin,staff,dept_manager,appointment_officer,content_editor,doctor'],
            'phone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', $user->is_active);

        // Prevent admin from deactivating themselves
        if (auth()->id() === $user->id) {
            $validated['is_active'] = true;
        }

        $user->update($validated);

        return back()->with('success', "User '{$user->name}' updated successfully.");
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot deactivate your own active session account.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $statusText = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->name} has been {$statusText}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "User account '{$name}' removed.");
    }
}

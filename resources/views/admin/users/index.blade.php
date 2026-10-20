@extends('layouts.admin')

@section('title', 'Staff & User Accounts Management')
@section('header', 'Hospital Staff Accounts & Security Privileges')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editUser: {
        id: '',
        name: '',
        email: '',
        role: 'staff',
        phone: '',
        is_active: true
    },
    openEdit(u) {
        this.editUser = {
            id: u.id,
            name: u.name || '',
            email: u.email || '',
            role: u.role || 'staff',
            phone: u.phone || '',
            is_active: !!u.is_active
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search name, email, phone..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-56"
                />
                <select name="role" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500">
                    <option value="">All Staff Roles</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ $role == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($search || $role)
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
                @endif
            </form>
        </div>

        <button 
            type="button" 
            @click="addModalOpen = true"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-semibold text-xs shadow-sm transition shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Create Staff Account</span>
        </button>
    </div>

    <!-- Users Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">User Profile</th>
                        <th class="px-6 py-3 font-semibold">System Privilege</th>
                        <th class="px-6 py-3 font-semibold">Contact Phone</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-2xs">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-tight flex items-center gap-2">
                                            <span>{{ $u->name }}</span>
                                            @if(auth()->id() === $u->id)
                                                <span class="px-1.5 py-0.2 rounded bg-hospital-100 text-hospital-800 font-semibold text-[10px]">You</span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-mono">{{ $u->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($u->role === 'super_admin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800 uppercase">Super Admin</span>
                                @elseif($u->role === 'admin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-hospital-100 text-hospital-800 uppercase">Admin</span>
                                @elseif($u->role === 'doctor')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-teal-100 text-teal-800 uppercase">Doctor</span>
                                @elseif($u->role === 'dept_manager')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800 uppercase">Dept Manager</span>
                                @elseif($u->role === 'appointment_officer')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 uppercase">Appt Officer</span>
                                @elseif($u->role === 'content_editor')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-100 text-sky-800 uppercase">Editor</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 uppercase">Staff</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-mono">
                                {{ $u->phone ?? 'Not set' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($u->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-500">
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($u) }})"
                                        class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    @if(auth()->id() !== $u->id)
                                        <form method="POST" action="{{ route('admin.users.status', $u->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="submit" 
                                                class="font-semibold px-2 py-0.5 rounded border transition {{ $u->is_active ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                            >
                                                {{ $u->is_active ? 'Suspend' : 'Activate' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" class="inline" onsubmit="return confirm('Permanently remove user {{ addslashes($u->name) }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 font-semibold hover:text-red-800 px-1">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                                No staff accounts found matching the criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add User Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Create Staff User Account</h3>
                        <p class="text-xs text-slate-500">Provide staff authentication credentials and system role privileges.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Staff Full Name *</label>
                        <x-input name="name" placeholder="e.g. Sarah J. Mwangi" required />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Official Email *</label>
                            <x-input type="email" name="email" placeholder="staff@hospital.org" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Contact Phone</label>
                            <x-input name="phone" placeholder="+255 700 000 000" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Role Privilege *</label>
                            <x-select name="role" required>
                                @foreach($roles as $key => $label)
                                    <option value="{{ $key }}" {{ $key === 'staff' ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Initial Password *</label>
                            <x-input type="password" name="password" placeholder="At least 6 characters" required />
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Create Account
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Staff Account</h3>
                        <p class="text-xs text-slate-500">Update account role or set a new password.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/users/' + editUser.id" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Staff Full Name *</label>
                        <input type="text" name="name" x-model="editUser.name" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Official Email *</label>
                            <input type="email" name="email" x-model="editUser.email" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Contact Phone</label>
                            <input type="text" name="phone" x-model="editUser.phone" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Role Privilege *</label>
                            <select name="role" x-model="editUser.role" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                @foreach($roles as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Reset Password (Optional)</label>
                            <input type="password" name="password" placeholder="Leave blank to keep" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Save Changes
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

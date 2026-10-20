@extends('layouts.admin')

@section('title', 'Careers & Vacancies Management')
@section('header', 'Hospital Human Resources & Medical Vacancies')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editCareer: {
        id: '',
        title_en: '',
        title_sw: '',
        department_id: '',
        employment_type: 'Full-Time',
        location: 'Main Campus',
        deadline: '',
        application_email: '',
        description_en: '',
        description_sw: '',
        requirements_en: '',
        requirements_sw: '',
        is_active: true
    },
    openEdit(c) {
        this.editCareer = {
            id: c.id,
            title_en: c.title_en || '',
            title_sw: c.title_sw || '',
            department_id: c.department_id || '',
            employment_type: c.employment_type || 'Full-Time',
            location: c.location || 'Main Campus',
            deadline: c.deadline ? c.deadline.substring(0, 10) : '',
            application_email: c.application_email || '',
            description_en: c.description_en || '',
            description_sw: c.description_sw || '',
            requirements_en: c.requirements_en || '',
            requirements_sw: c.requirements_sw || '',
            is_active: !!c.is_active
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.careers.index') }}" class="flex flex-wrap items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search position or location..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-56"
                />
                <select name="department" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $deptId == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
                @if($search || $deptId)
                    <a href="{{ route('admin.careers.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
                @endif
            </form>
        </div>

        <button 
            type="button" 
            @click="addModalOpen = true"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-semibold text-xs shadow-sm transition shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Post New Vacancy</span>
        </button>
    </div>

    <!-- Careers Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Position & Location</th>
                        <th class="px-6 py-3 font-semibold">Department</th>
                        <th class="px-6 py-3 font-semibold">Contract</th>
                        <th class="px-6 py-3 font-semibold">Deadline</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($careers as $job)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-tight">{{ $job->title_en }}</div>
                                @if($job->title_sw && $job->title_sw !== $job->title_en)
                                    <div class="text-[11px] text-slate-400">SW: {{ $job->title_sw }}</div>
                                @endif
                                <div class="text-[11px] text-slate-500 mt-0.5">{{ $job->location }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $job->department->name ?? 'General Medical' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 font-semibold text-slate-700 text-[11px]">
                                    {{ $job->employment_type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="font-semibold">{{ $job->deadline ? $job->deadline->format('M d, Y') : 'No deadline' }}</div>
                                @if($job->deadline && $job->deadline->isPast())
                                    <span class="text-[10px] text-red-600 font-bold uppercase">Expired</span>
                                @else
                                    <span class="text-[10px] text-emerald-600 font-bold uppercase">Accepting Apps</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($job->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Open
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-500">
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('careers.show', $job->slug) }}" target="_blank" class="text-hospital-700 font-semibold hover:underline">
                                        View
                                    </a>

                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($job) }})"
                                        class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.careers.status', $job->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="font-semibold px-2 py-0.5 rounded border transition {{ $job->is_active ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            {{ $job->is_active ? 'Close' : 'Reopen' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.careers.destroy', $job->id) }}" class="inline" onsubmit="return confirm('Permanently remove vacancy {{ addslashes($job->title_en) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 font-semibold hover:text-red-800 px-1">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                                No job vacancies found matching the criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($careers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $careers->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add Career Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Post Career Vacancy</h3>
                        <p class="text-xs text-slate-500">Recruit medical specialists, nurses, or administrative staff.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.careers.store') }}" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Job Title (English) *</label>
                            <x-input name="title_en" placeholder="e.g. Senior ICU Specialist Nurse" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Job Title (Swahili - Optional)</label>
                            <x-input name="title_sw" placeholder="e.g. Muuguzi Mwandamizi wa ICU" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Department</label>
                            <x-select name="department_id">
                                <option value="">Select Department (Optional)</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Contract Type *</label>
                            <x-select name="employment_type" required>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Locum">Locum</option>
                                <option value="Contract">Fixed Contract</option>
                                <option value="Fellowship">Fellowship / Residency</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Location Campus *</label>
                            <x-input name="location" value="Main Campus" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Application Deadline *</label>
                            <input type="date" name="deadline" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Applications Receiving Email</label>
                            <x-input type="email" name="application_email" placeholder="hr@hospital.org" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Role Description & Responsibilities (English) *</label>
                        <x-textarea name="description_en" rows="4" placeholder="Detail clinical duties, department leadership, reporting hierarchy..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Role Description (Swahili - Optional)</label>
                        <x-textarea name="description_sw" rows="4" placeholder="Maelezo ya majukumu..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Requirements & Qualifications (English)</label>
                        <x-textarea name="requirements_en" rows="3" placeholder="Required degrees, medical board registration, years of experience..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Requirements (Swahili - Optional)</label>
                        <x-textarea name="requirements_sw" rows="3" placeholder="Sifa na vigezo vinavyohitajika..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Publish Vacancy
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Career Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Vacancy</h3>
                        <p class="text-xs text-slate-500">Update deadline, requirements, or application email.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/careers/' + editCareer.id" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Job Title (English) *</label>
                            <input type="text" name="title_en" x-model="editCareer.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Job Title (Swahili)</label>
                            <input type="text" name="title_sw" x-model="editCareer.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Department</label>
                            <select name="department_id" x-model="editCareer.department_id" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500">
                                <option value="">No Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Contract Type *</label>
                            <select name="employment_type" x-model="editCareer.employment_type" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Locum">Locum</option>
                                <option value="Contract">Fixed Contract</option>
                                <option value="Fellowship">Fellowship / Residency</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Location Campus *</label>
                            <input type="text" name="location" x-model="editCareer.location" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deadline *</label>
                            <input type="date" name="deadline" x-model="editCareer.deadline" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Application Email</label>
                            <input type="email" name="application_email" x-model="editCareer.application_email" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Responsibilities (English) *</label>
                        <textarea name="description_en" x-model="editCareer.description_en" rows="4" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Responsibilities (Swahili)</label>
                        <textarea name="description_sw" x-model="editCareer.description_sw" rows="4" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Requirements (English)</label>
                        <textarea name="requirements_en" x-model="editCareer.requirements_en" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Requirements (Swahili)</label>
                        <textarea name="requirements_sw" x-model="editCareer.requirements_sw" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
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

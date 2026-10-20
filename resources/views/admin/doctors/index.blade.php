@extends('layouts.admin')

@section('title', 'Specialist Doctors Management')
@section('header', 'Medical Specialists & Faculty')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editDoctor: {
        id: '',
        name: '',
        department_id: '',
        title_en: '',
        title_sw: '',
        qualification_en: '',
        qualification_sw: '',
        email: '',
        phone: '',
        consultation_hours: '',
        biography_en: '',
        biography_sw: '',
        photo_url: '',
        is_active: true
    },
    openEdit(doc) {
        this.editDoctor = {
            id: doc.id,
            name: doc.name || '',
            department_id: doc.department_id || '',
            title_en: doc.title_en || '',
            title_sw: doc.title_sw || '',
            qualification_en: doc.qualification_en || '',
            qualification_sw: doc.qualification_sw || '',
            email: doc.email || '',
            phone: doc.phone || '',
            consultation_hours: doc.consultation_hours || '',
            biography_en: doc.biography_en || '',
            biography_sw: doc.biography_sw || '',
            photo_url: doc.photo ? ('/' + doc.photo) : '',
            is_active: !!doc.is_active
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.doctors.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search doctor, specialty, title..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-full xs:w-48 sm:w-64"
                />
                <select name="department" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500">
                    <option value="">All Clinical Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $deptId == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @if($search || $deptId)
                    <a href="{{ route('admin.doctors.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Register New Specialist</span>
        </button>
    </div>

    <!-- Doctors Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Specialist Doctor</th>
                        <th class="px-6 py-3 font-semibold">Department</th>
                        <th class="px-6 py-3 font-semibold">Qualifications & Title</th>
                        <th class="px-6 py-3 font-semibold">Schedule & Contact</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($doctors as $doc)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($doc->photo)
                                        <img src="{{ asset($doc->photo) }}" alt="{{ $doc->name }}" class="h-11 w-11 rounded-full object-cover border border-slate-200 shadow-2xs shrink-0" />
                                    @else
                                        <div class="h-11 w-11 rounded-full bg-gradient-to-tr from-hospital-700 to-hospital-500 text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-2xs">
                                            {{ substr($doc->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 leading-tight">{{ $doc->name }}</div>
                                        <div class="text-[11px] text-hospital-700 font-semibold">{{ $doc->title ?? 'Specialist Consultant' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $doc->department->name ?? 'Unassigned' }}
                            </td>
                            <td class="px-6 py-4 text-xs max-w-xs">
                                <div class="font-semibold text-slate-800 truncate">{{ $doc->qualification }}</div>
                                @if($doc->qualification_sw && $doc->qualification_sw !== $doc->qualification_en)
                                    <div class="text-[11px] text-slate-400 truncate">SW: {{ $doc->qualification_sw }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600">
                                <div class="font-medium text-slate-800">{{ $doc->consultation_hours ?? 'Mon - Fri' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $doc->phone ?? $doc->email ?? 'Clinic Line' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($doc->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($doc) }})"
                                        class="text-xs font-semibold px-2.5 py-1 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.doctors.status', $doc->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="text-xs font-semibold px-2.5 py-1 rounded-lg border transition {{ $doc->is_active ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            {{ $doc->is_active ? 'Suspend' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.doctors.destroy', $doc->id) }}" class="inline" onsubmit="return confirm('Permanently remove specialist Dr. {{ addslashes($doc->name) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="text-xs font-semibold px-2 py-1 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                No specialists found matching the criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doctors->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $doctors->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add Doctor Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Register Medical Specialist</h3>
                        <p class="text-xs text-slate-500">Add a consultant doctor to the public portal and outpatient roster.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.doctors.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Doctor Full Name *</label>
                            <x-input name="name" placeholder="e.g. Dr. Jane Mwamburi" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Department *</label>
                            <x-select name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Title / Designation (EN)</label>
                            <x-input name="title_en" placeholder="e.g. Lead Cardiologist" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Title / Designation (SW - Optional)</label>
                            <x-input name="title_sw" placeholder="e.g. Daktari Bingwa wa Moyo" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Qualifications (EN) *</label>
                            <x-input name="qualification_en" placeholder="e.g. MD, MMed (Cardiology), FESC" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Qualifications (SW - Optional)</label>
                            <x-input name="qualification_sw" placeholder="e.g. MD, MMed (Cardiology)" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Consultation Schedule</label>
                            <x-input name="consultation_hours" placeholder="e.g. Mon - Thu: 09:00 - 13:00" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Direct Phone</label>
                            <x-input name="phone" placeholder="e.g. +255 700 123 456" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Institutional Email</label>
                            <x-input type="email" name="email" placeholder="doctor@hospital.org" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Doctor Photo (JPG, PNG or WebP)</label>
                        <input type="file" name="photo_file" accept="image/*" class="text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Biography (English)</label>
                        <x-textarea name="biography_en" rows="3" placeholder="Physician fellowship history, clinical achievements, and interests..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Biography (Swahili - Optional)</label>
                        <x-textarea name="biography_sw" rows="3" placeholder="Maelezo ya taaluma na historia ya daktari..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Register Specialist
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Doctor Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Update Specialist Profile</h3>
                        <p class="text-xs text-slate-500">Edit qualifications, consultation hours, and profile details.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/doctors/' + editDoctor.id" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Doctor Full Name *</label>
                            <input type="text" name="name" x-model="editDoctor.name" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Department *</label>
                            <select name="department_id" x-model="editDoctor.department_id" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Title / Designation (EN)</label>
                            <input type="text" name="title_en" x-model="editDoctor.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Title / Designation (SW)</label>
                            <input type="text" name="title_sw" x-model="editDoctor.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Qualifications (EN) *</label>
                            <input type="text" name="qualification_en" x-model="editDoctor.qualification_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Qualifications (SW)</label>
                            <input type="text" name="qualification_sw" x-model="editDoctor.qualification_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Consultation Schedule</label>
                            <input type="text" name="consultation_hours" x-model="editDoctor.consultation_hours" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Direct Phone</label>
                            <input type="text" name="phone" x-model="editDoctor.phone" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" x-model="editDoctor.email" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Doctor Photo</label>
                        <template x-if="editDoctor.photo_url">
                            <div class="mb-2 flex items-center gap-3">
                                <img :src="editDoctor.photo_url" class="h-10 w-10 rounded-full object-cover border border-slate-200" />
                                <span class="text-xs text-slate-500">Current photo uploaded</span>
                            </div>
                        </template>
                        <input type="file" name="photo_file" accept="image/*" class="text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Biography (English)</label>
                        <textarea name="biography_en" x-model="editDoctor.biography_en" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Biography (Swahili)</label>
                        <textarea name="biography_sw" x-model="editDoctor.biography_sw" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
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

@extends('layouts.admin')

@section('title', 'Clinical Departments Management')
@section('header', 'Hospital Clinical Departments & Divisions')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editDept: {
        id: '',
        name_en: '',
        name_sw: '',
        location: '',
        phone: '',
        email: '',
        summary_en: '',
        summary_sw: '',
        description_en: '',
        description_sw: '',
        image_url: '',
        is_active: true
    },
    openEdit(dept) {
        this.editDept = {
            id: dept.id,
            name_en: dept.name_en || '',
            name_sw: dept.name_sw || '',
            location: dept.location || '',
            phone: dept.phone || '',
            email: dept.email || '',
            summary_en: dept.summary_en || '',
            summary_sw: dept.summary_sw || '',
            description_en: dept.description_en || '',
            description_sw: dept.description_sw || '',
            image_url: dept.image ? ('/' + dept.image) : '',
            is_active: !!dept.is_active
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.departments.index') }}" class="flex items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search department, wing, contact..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-64"
                />
                @if($search)
                    <a href="{{ route('admin.departments.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Add Clinical Department</span>
        </button>
    </div>

    <!-- Departments Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Department & Wing</th>
                        <th class="px-6 py-3 font-semibold">Contact & Extension</th>
                        <th class="px-6 py-3 font-semibold text-center">Specialists</th>
                        <th class="px-6 py-3 font-semibold text-center">Services</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($departments as $dept)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($dept->image)
                                        <img src="{{ asset($dept->image) }}" alt="" class="h-10 w-12 rounded-lg object-cover border border-slate-200 shrink-0" />
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-hospital-100 text-hospital-700 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ substr($dept->name_en, 0, 2) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 leading-tight">{{ $dept->name_en }}</div>
                                        @if($dept->name_sw && $dept->name_sw !== $dept->name_en)
                                            <div class="text-[11px] text-slate-400">SW: {{ $dept->name_sw }}</div>
                                        @endif
                                        <div class="text-[11px] text-hospital-800 font-semibold mt-0.5">{{ $dept->location ?? 'Main Clinical Wing' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-800 font-medium">{{ $dept->phone ?? 'Main Line' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $dept->email ?? 'clinical@hospital.org' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold font-mono text-slate-800">
                                {{ $dept->doctors_count }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold font-mono text-slate-800">
                                {{ $dept->services_count }}
                            </td>
                            <td class="px-6 py-4">
                                @if($dept->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Operational
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-500">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('departments.show', $dept->slug) }}" target="_blank" class="text-hospital-700 font-semibold hover:underline">
                                        View
                                    </a>

                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($dept) }})"
                                        class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.departments.status', $dept->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="font-semibold px-2 py-0.5 rounded border transition {{ $dept->is_active ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            {{ $dept->is_active ? 'Suspend' : 'Activate' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.departments.destroy', $dept->id) }}" class="inline" onsubmit="return confirm('Permanently remove department {{ addslashes($dept->name_en) }}?');">
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
                                No clinical departments found matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($departments->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $departments->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add Department Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Establish Clinical Department</h3>
                        <p class="text-xs text-slate-500">Configure department name, physical wing location, and clinical overview.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.departments.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Department Name (English) *</label>
                            <x-input name="name_en" placeholder="e.g. Cardiology & Vascular Center" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Department Name (Swahili - Optional)</label>
                            <x-input name="name_sw" placeholder="e.g. Idara ya Magonjwa ya Moyo" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Location / Building Wing</label>
                            <x-input name="location" placeholder="e.g. 2nd Floor, Tower A" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Direct Phone</label>
                            <x-input name="phone" placeholder="e.g. +255 700 334 112" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Direct Email</label>
                            <x-input type="email" name="email" placeholder="cardio@hospital.org" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Department Banner / Image (JPG, PNG or WebP)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Brief Summary (English)</label>
                        <x-textarea name="summary_en" rows="2" placeholder="Brief 1-2 sentence overview for cards..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Brief Summary (Swahili - Optional)</label>
                        <x-textarea name="summary_sw" rows="2" placeholder="Muhtasari mfupi..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Comprehensive Description (English)</label>
                        <x-textarea name="description_en" rows="4" placeholder="Detailed clinical capabilities, surgical procedures, and facility info..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Comprehensive Description (Swahili - Optional)</label>
                        <x-textarea name="description_sw" rows="4" placeholder="Maelezo ya kina ya idara..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Establish Department
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Department Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Clinical Department</h3>
                        <p class="text-xs text-slate-500">Update wing location, contact info, and clinical description.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/departments/' + editDept.id" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Department Name (English) *</label>
                            <input type="text" name="name_en" x-model="editDept.name_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Department Name (Swahili)</label>
                            <input type="text" name="name_sw" x-model="editDept.name_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Location / Building Wing</label>
                            <input type="text" name="location" x-model="editDept.location" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Phone</label>
                            <input type="text" name="phone" x-model="editDept.phone" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" x-model="editDept.email" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Image</label>
                        <template x-if="editDept.image_url">
                            <div class="mb-2 flex items-center gap-2">
                                <img :src="editDept.image_url" class="h-10 w-14 rounded object-cover border border-slate-200" />
                                <span class="text-xs text-slate-500">Current header image</span>
                            </div>
                        </template>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Brief Summary (English)</label>
                        <textarea name="summary_en" x-model="editDept.summary_en" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Brief Summary (Swahili)</label>
                        <textarea name="summary_sw" x-model="editDept.summary_sw" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Comprehensive Description (English)</label>
                        <textarea name="description_en" x-model="editDept.description_en" rows="4" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Comprehensive Description (Swahili)</label>
                        <textarea name="description_sw" x-model="editDept.description_sw" rows="4" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
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

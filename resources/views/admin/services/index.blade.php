@extends('layouts.admin')

@section('title', 'Clinical Services Management')
@section('header', 'Clinical & Diagnostic Services')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false,
    editModalOpen: false,
    editService: {
        id: '',
        name_en: '',
        name_sw: '',
        department_id: '',
        summary_en: '',
        summary_sw: '',
        color: 'teal',
        icon: 'smile',
        is_emergency: false,
        is_active: true,
        sort_order: 1
    },
    openEdit(srv) {
        this.editService = Object.assign({}, srv);
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.services.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search clinical service..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-full xs:w-48 sm:w-64"
                />
                @if($search)
                    <a href="{{ route('admin.services.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Add Clinical Service</span>
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-2xs">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Services Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[750px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Service Name</th>
                        <th class="px-6 py-3 font-semibold">Department</th>
                        <th class="px-6 py-3 font-semibold">Card Color</th>
                        <th class="px-6 py-3 font-semibold">Summary</th>
                        <th class="px-6 py-3 font-semibold">Order</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($services as $srv)
                        @php
                            $colorMap = [
                                'teal' => 'bg-teal-100 text-teal-800 border-teal-300',
                                'purple' => 'bg-purple-100 text-purple-800 border-purple-300',
                                'orange' => 'bg-orange-100 text-orange-800 border-orange-300',
                                'red' => 'bg-red-100 text-red-800 border-red-300',
                                'amber' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'navy' => 'bg-blue-100 text-blue-900 border-blue-300',
                                'blue' => 'bg-sky-100 text-sky-800 border-sky-300',
                                'emerald' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            ];
                            $badgeClass = $colorMap[$srv->color ?? 'teal'] ?? 'bg-slate-100 text-slate-800 border-slate-300';
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">{{ $srv->name_en }}</div>
                                @if($srv->name_sw)
                                    <div class="text-[11px] text-slate-400 italic">{{ $srv->name_sw }}</div>
                                @endif
                                @if($srv->is_emergency)
                                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-red-100 text-red-700 uppercase">Emergency Unit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-700">
                                {{ $srv->department->name ?? 'General Medical' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border capitalize {{ $badgeClass }}">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    <span>{{ $srv->color ?? 'teal' }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">
                                {{ $srv->summary_en }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-400">
                                #{{ $srv->sort_order }}
                            </td>
                            <td class="px-6 py-4">
                                @if($srv->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Live
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">
                                        Hidden
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($srv) }})" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold text-hospital-700 bg-hospital-50 hover:bg-hospital-100 transition"
                                    >
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.services.status', $srv->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $srv->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }} transition"
                                        >
                                            {{ $srv->is_active ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.services.destroy', $srv->id) }}" class="inline" onsubmit="return confirm('Delete this clinical service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400">
                                No clinical services found. Click "Add Clinical Service" to post one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $services->links() }}
            </div>
        @endif
    </x-card>

    <!-- =========================================================================
         ADD SERVICE MODAL
         ========================================================================= -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="addModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="addModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Add New Clinical Service</h3>
                    <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Service Name (English)</label>
                            <input type="text" name="name_en" required placeholder="e.g. Paediatric and Child Care" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Service Name (Swahili)</label>
                            <input type="text" name="name_sw" placeholder="e.g. Huduma za Watoto na Afya ya Mtoto" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Department</label>
                            <select name="department_id" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800">
                                <option value="">-- General Hospital Service --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Homepage Card Color Accent</label>
                            <select name="color" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-bold text-slate-800">
                                <option value="teal" selected>Teal Green</option>
                                <option value="purple">Purple</option>
                                <option value="orange">Orange</option>
                                <option value="red">Red</option>
                                <option value="amber">Amber Gold</option>
                                <option value="navy">Navy Blue</option>
                                <option value="blue">Sky Blue</option>
                                <option value="emerald">Emerald</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Card Summary (Shown on Homepage Card)</label>
                        <textarea name="summary_en" rows="3" required placeholder="Brief clinical service description..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Icon Type</label>
                        <select name="icon" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800">
                            <option value="smile">Smile / Pediatric</option>
                            <option value="briefcase">Medical Briefcase</option>
                            <option value="heart-pulse">Heart Pulse Monitor</option>
                            <option value="brain">Brain / Neurology</option>
                            <option value="cross">Medical Cross</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_emergency" value="1" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-red-700">24/7 Emergency Service</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Publish Immediately</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         EDIT SERVICE MODAL
         ========================================================================= -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="editModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="editModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Edit Clinical Service</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form :action="'{{ url('admin/services') }}/' + editService.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Service Name (English)</label>
                            <input type="text" name="name_en" x-model="editService.name_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Service Name (Swahili)</label>
                            <input type="text" name="name_sw" x-model="editService.name_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Department</label>
                            <select name="department_id" x-model="editService.department_id" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800">
                                <option value="">-- General Hospital Service --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Card Color Accent</label>
                            <select name="color" x-model="editService.color" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-bold text-slate-800">
                                <option value="teal">Teal Green</option>
                                <option value="purple">Purple</option>
                                <option value="orange">Orange</option>
                                <option value="red">Red</option>
                                <option value="amber">Amber Gold</option>
                                <option value="navy">Navy Blue</option>
                                <option value="blue">Sky Blue</option>
                                <option value="emerald">Emerald</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Card Summary (Shown on Homepage Card)</label>
                        <textarea name="summary_en" rows="3" x-model="editService.summary_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Icon Type</label>
                            <select name="icon" x-model="editService.icon" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800">
                                <option value="smile">Smile / Pediatric</option>
                                <option value="briefcase">Medical Briefcase</option>
                                <option value="heart-pulse">Heart Pulse Monitor</option>
                                <option value="brain">Brain / Neurology</option>
                                <option value="cross">Medical Cross</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sort Order #</label>
                            <input type="number" name="sort_order" x-model="editService.sort_order" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_emergency" value="1" :checked="editService.is_emergency" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-red-700">24/7 Emergency Service</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="editService.is_active" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Active / Live</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Update Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

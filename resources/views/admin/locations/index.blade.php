@extends('layouts.admin')

@section('title', 'Hospital Campuses & Locations')
@section('header', 'Campuses & Referral Branches')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false,
    editModalOpen: false,
    editLoc: {
        id: '',
        name_en: '',
        name_sw: '',
        address_en: '',
        address_sw: '',
        phone: '+255742448965',
        email: '',
        opening_hours_en: 'Emergency 24/7',
        opening_hours_sw: '',
        google_map_url: '',
        is_main: false,
        is_active: true,
        sort_order: 1
    },
    openEdit(item) {
        this.editLoc = Object.assign({}, item);
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.locations.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search campus or address..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-full xs:w-48 sm:w-64"
                />
                @if($search)
                    <a href="{{ route('admin.locations.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Add New Campus</span>
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-2xs">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Locations Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Campus Name</th>
                        <th class="px-6 py-3 font-semibold">Type Badge</th>
                        <th class="px-6 py-3 font-semibold">Address</th>
                        <th class="px-6 py-3 font-semibold">Emergency Phone</th>
                        <th class="px-6 py-3 font-semibold">Hours</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($locations as $loc)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-snug">{{ $loc->name_en }}</div>
                                @if($loc->name_sw)
                                    <div class="text-[11px] text-slate-400 italic mt-0.5">{{ $loc->name_sw }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($loc->is_main)
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-hospital-600 text-white uppercase">
                                        Main Campus
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-navy-800 text-white uppercase">
                                        Specialty Wing
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-600 max-w-xs truncate">
                                {{ $loc->address_en }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-800">
                                {{ $loc->phone }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $loc->opening_hours_en }}
                            </td>
                            <td class="px-6 py-4">
                                @if($loc->is_active)
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
                                        @click="openEdit({{ json_encode($loc) }})" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold text-hospital-700 bg-hospital-50 hover:bg-hospital-100 transition"
                                    >
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.locations.status', $loc->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $loc->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }} transition"
                                        >
                                            {{ $loc->is_active ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.locations.destroy', $loc->id) }}" class="inline" onsubmit="return confirm('Delete this campus location?');">
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
                                No locations found. Click "Add New Campus" to register one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($locations->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $locations->links() }}
            </div>
        @endif
    </x-card>

    <!-- =========================================================================
         ADD LOCATION MODAL
         ========================================================================= -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="addModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="addModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Add Campus Location</h3>
                    <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.locations.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Campus Name (English)</label>
                            <input type="text" name="name_en" required placeholder="e.g. Upanga Main Hospital" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Campus Name (Swahili)</label>
                            <input type="text" name="name_sw" placeholder="Swahili name..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Physical Address</label>
                        <input type="text" name="address_en" required placeholder="e.g. Medical Avenue, Upanga, Dar es Salaam" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" required value="+255742448965" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-mono font-bold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Opening Hours</label>
                            <input type="text" name="opening_hours_en" required value="Emergency 24/7 | OPD 07:30 - 20:00" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Campus Banner Image</label>
                        <input 
                            type="file" 
                            name="image_file" 
                            accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100 cursor-pointer"
                        />
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_main" value="1" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-hospital-800">Is Main Campus</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Display on Homepage</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Save Campus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         EDIT LOCATION MODAL
         ========================================================================= -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="editModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="editModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Edit Campus Location</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form :action="'{{ url('admin/locations') }}/' + editLoc.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Campus Name (English)</label>
                            <input type="text" name="name_en" x-model="editLoc.name_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Campus Name (Swahili)</label>
                            <input type="text" name="name_sw" x-model="editLoc.name_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Physical Address</label>
                        <input type="text" name="address_en" x-model="editLoc.address_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                            <input type="text" name="phone" x-model="editLoc.phone" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-mono font-bold text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Opening Hours</label>
                            <input type="text" name="opening_hours_en" x-model="editLoc.opening_hours_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Update Banner Image (Optional)</label>
                        <input 
                            type="file" 
                            name="image_file" 
                            accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100 cursor-pointer"
                        />
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_main" value="1" :checked="editLoc.is_main" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-hospital-800">Is Main Campus</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="editLoc.is_active" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Display on Homepage</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Update Campus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

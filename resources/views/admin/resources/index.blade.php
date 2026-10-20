@extends('layouts.admin')

@section('title', 'Institutional Resources Management')
@section('header', 'Downloadable Patient Resources & Documents')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editRes: {
        id: '',
        title_en: '',
        title_sw: '',
        category: '',
        description_en: '',
        description_sw: '',
        external_url: '',
        file_type: '',
        file_size: '',
        file_path: '',
        is_active: true
    },
    openEdit(res) {
        this.editRes = {
            id: res.id,
            title_en: res.title_en || '',
            title_sw: res.title_sw || '',
            category: res.category || 'Patient Guide',
            description_en: res.description_en || '',
            description_sw: res.description_sw || '',
            external_url: res.external_url || '',
            file_type: res.file_type || 'PDF',
            file_size: res.file_size || '',
            file_path: res.file_path || '',
            is_active: !!res.is_active
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.resources.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($category) ? 'bg-hospital-700 text-white shadow-2xs' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200' }}">
                All Categories
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('admin.resources.index', ['category' => $cat]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $category === $cat ? 'bg-hospital-700 text-white shadow-2xs' : 'bg-white text-slate-600 hover:text-slate-900 border border-slate-200' }}">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <button 
            type="button" 
            @click="addModalOpen = true"
            class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-semibold text-xs shadow-sm transition shrink-0"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Publish New Resource</span>
        </button>
    </div>

    <!-- Resources Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Publication Title</th>
                        <th class="px-6 py-3 font-semibold">Category</th>
                        <th class="px-6 py-3 font-semibold">Format & Size</th>
                        <th class="px-6 py-3 font-semibold">Downloads</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($resources as $res)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-tight">{{ $res->title_en }}</div>
                                @if($res->title_sw && $res->title_sw !== $res->title_en)
                                    <div class="text-[11px] text-slate-400 italic">SW: {{ $res->title_sw }}</div>
                                @endif
                                <div class="text-xs text-slate-500 line-clamp-1 max-w-md mt-0.5">{{ $res->description_en }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $res->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 mr-1.5">
                                    {{ $res->file_type ?? 'PDF' }}
                                </span>
                                {{ $res->file_size ?? '1.5 MB' }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs font-bold text-hospital-800">
                                {{ number_format($res->download_count) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($res->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-600">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="{{ route('resources.download', $res->id) }}" 
                                        class="text-xs font-semibold text-hospital-700 hover:text-hospital-900 px-2 py-1"
                                        target="_blank"
                                        title="Download document"
                                    >
                                        Download
                                    </a>

                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($res) }})"
                                        class="text-xs font-semibold px-2 py-1 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.resources.status', $res->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="text-xs font-semibold px-2 py-1 rounded-lg border transition {{ $res->is_active ? 'border-slate-200 text-slate-600 hover:bg-slate-100' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            {{ $res->is_active ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.resources.destroy', $res->id) }}" class="inline" onsubmit="return confirm('Permanently remove this publication?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800 px-2 py-1">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                No downloadable resources found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($resources->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $resources->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add Resource Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Publish New Patient Document</h3>
                        <p class="text-xs text-slate-500">Upload hospital forms, guidelines, or clinical reports.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.resources.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Title (English) *</label>
                        <x-input name="title_en" placeholder="e.g. Inpatient Admission Rights & Financial Guide" required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Title (Swahili - Optional)</label>
                        <x-input name="title_sw" placeholder="e.g. Mwongozo wa Kulazwa na Haki za Mgonjwa" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Category *</label>
                        <x-select name="category" required>
                            <option value="Patient Guides">Patient Guides</option>
                            <option value="Clinical Charters">Clinical Charters</option>
                            <option value="Quality Reports">Quality Reports</option>
                            <option value="Insurance Forms">Insurance Forms</option>
                            <option value="Pre-Surgery Checklists">Pre-Surgery Checklists</option>
                            <option value="Infection Control">Infection Control</option>
                        </x-select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Upload Document File (PDF, Word, Excel, ZIP)</label>
                        <input type="file" name="document_file" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                        <p class="text-[11px] text-slate-400 mt-1">Maximum upload size: 15MB</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">External Resource URL (Optional)</label>
                        <x-input type="url" name="external_url" placeholder="https://example.org/doc.pdf" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Summary / Instructions (English) *</label>
                        <x-textarea name="description_en" rows="3" placeholder="Provide instructions on what this document contains..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Summary (Swahili - Optional)</label>
                        <x-textarea name="description_sw" rows="3" placeholder="Maelezo kuhusu hati hii na matumizi yake..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Publish Resource
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Resource Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Patient Document</h3>
                        <p class="text-xs text-slate-500">Update title, category, description or upload a new revision.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/resources/' + editRes.id" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Title (English) *</label>
                        <input type="text" name="title_en" x-model="editRes.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Title (Swahili)</label>
                        <input type="text" name="title_sw" x-model="editRes.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Document Category *</label>
                        <select name="category" x-model="editRes.category" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                            <option value="Patient Guides">Patient Guides</option>
                            <option value="Clinical Charters">Clinical Charters</option>
                            <option value="Quality Reports">Quality Reports</option>
                            <option value="Insurance Forms">Insurance Forms</option>
                            <option value="Pre-Surgery Checklists">Pre-Surgery Checklists</option>
                            <option value="Infection Control">Infection Control</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Document File</label>
                        <template x-if="editRes.file_path">
                            <div class="mb-2 text-xs text-slate-500 flex items-center gap-1 font-mono">
                                <span>Current:</span>
                                <span class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-700" x-text="editRes.file_path"></span>
                            </div>
                        </template>
                        <input type="file" name="document_file" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">External Resource URL</label>
                        <input type="url" name="external_url" x-model="editRes.external_url" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Summary (English) *</label>
                        <textarea name="description_en" x-model="editRes.description_en" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Clinical Summary (Swahili)</label>
                        <textarea name="description_sw" x-model="editRes.description_sw" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
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

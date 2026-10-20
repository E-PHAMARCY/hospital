@extends('layouts.admin')

@section('title', 'Health Education & Wellness Articles')
@section('header', 'Health Education & Community Wellness Hub')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false, 
    editModalOpen: false,
    editArticle: {
        id: '',
        title_en: '',
        title_sw: '',
        category: 'General Wellness',
        author_name: 'Clinical Medical Staff',
        excerpt_en: '',
        excerpt_sw: '',
        content_en: '',
        content_sw: '',
        disclaimer_en: '',
        disclaimer_sw: '',
        image_url: '',
        is_published: true
    },
    openEdit(art) {
        this.editArticle = {
            id: art.id,
            title_en: art.title_en || '',
            title_sw: art.title_sw || '',
            category: art.category || 'General Wellness',
            author_name: art.author_name || 'Clinical Medical Staff',
            excerpt_en: art.excerpt_en || '',
            excerpt_sw: art.excerpt_sw || '',
            content_en: art.content_en || '',
            content_sw: art.content_sw || '',
            disclaimer_en: art.disclaimer_en || '',
            disclaimer_sw: art.disclaimer_sw || '',
            image_url: art.featured_image ? ('/' + art.featured_image) : '',
            is_published: !!art.is_published
        };
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.health-education.index') }}" class="flex flex-wrap items-center gap-2">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search health article..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-56"
                />
                <select name="category" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                @if($search || $category)
                    <a href="{{ route('admin.health-education.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Publish Health Guide</span>
        </button>
    </div>

    <!-- Health Articles Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Article Title & Author</th>
                        <th class="px-6 py-3 font-semibold">Category</th>
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold text-center">Reads</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($articles as $art)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($art->featured_image)
                                        <img src="{{ asset($art->featured_image) }}" alt="" class="h-10 w-14 rounded-lg object-cover border border-slate-200 shrink-0" />
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xs shrink-0">
                                            DOC
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 leading-tight">{{ $art->title_en }}</div>
                                        @if($art->title_sw && $art->title_sw !== $art->title_en)
                                            <div class="text-[11px] text-slate-400">SW: {{ $art->title_sw }}</div>
                                        @endif
                                        <div class="text-[11px] text-hospital-700 mt-0.5">By {{ $art->author_name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px]">
                                    {{ $art->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $art->published_at ? $art->published_at->format('M d, Y') : $art->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-center font-mono font-bold text-slate-800">
                                {{ number_format($art->views_count) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($art->is_published)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-500">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('health-education.show', $art->slug) }}" target="_blank" class="text-hospital-700 font-semibold hover:underline">
                                        View
                                    </a>

                                    <button 
                                        type="button" 
                                        @click="openEdit({{ json_encode($art) }})"
                                        class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                    >
                                        Edit
                                    </button>

                                    <form method="POST" action="{{ route('admin.health-education.status', $art->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="font-semibold px-2 py-0.5 rounded border transition {{ $art->is_published ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                        >
                                            {{ $art->is_published ? 'Unpublish' : 'Publish' }}
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.health-education.destroy', $art->id) }}" class="inline" onsubmit="return confirm('Permanently remove health guide {{ addslashes($art->title_en) }}?');">
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
                                No health education guides found matching the filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $articles->links() }}
            </div>
        @endif
    </x-card>

    <!-- Add Article Modal -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Publish Health Education Guide</h3>
                        <p class="text-xs text-slate-500">Provide medical advice, patient prevention tips, or wellness guides.</p>
                    </div>
                    <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.health-education.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Guide Title (English) *</label>
                            <x-input name="title_en" placeholder="e.g. Managing Hypertension: Daily Diet & Exercise" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Guide Title (Swahili - Optional)</label>
                            <x-input name="title_sw" placeholder="e.g. Kudhibiti Shinikizo la Juu la Damu" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Category *</label>
                            <x-select name="category" required>
                                <option value="Cardiovascular Health">Cardiovascular Health</option>
                                <option value="Maternal & Child Health">Maternal & Child Health</option>
                                <option value="Nutrition & Diet">Nutrition & Diet</option>
                                <option value="Infectious Diseases">Infectious Diseases</option>
                                <option value="Mental Wellness">Mental Wellness</option>
                                <option value="General Wellness">General Wellness</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Author / Reviewer Name</label>
                            <x-input name="author_name" placeholder="e.g. Dr. Jane Mwamburi, Cardiologist" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Banner Image (JPG, PNG or WebP)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Quick Excerpt (English) *</label>
                        <x-textarea name="excerpt_en" rows="2" placeholder="1-2 sentences summarizing clinical key takeaway..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Quick Excerpt (Swahili - Optional)</label>
                        <x-textarea name="excerpt_sw" rows="2" placeholder="Muhtasari mfupi..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article / Educational Content (English) *</label>
                        <x-textarea name="content_en" rows="5" placeholder="Comprehensive health guide with symptoms, prevention tips, and medical instructions..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article (Swahili - Optional)</label>
                        <x-textarea name="content_sw" rows="5" placeholder="Maudhui kamili kwa Kiswahili..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Publish Guide
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Health Guide</h3>
                        <p class="text-xs text-slate-500">Update medical copy, reviewer credits, or replace image.</p>
                    </div>
                    <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/health-education/' + editArticle.id" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Guide Title (English) *</label>
                            <input type="text" name="title_en" x-model="editArticle.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Guide Title (Swahili)</label>
                            <input type="text" name="title_sw" x-model="editArticle.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Category *</label>
                            <select name="category" x-model="editArticle.category" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                <option value="Cardiovascular Health">Cardiovascular Health</option>
                                <option value="Maternal & Child Health">Maternal & Child Health</option>
                                <option value="Nutrition & Diet">Nutrition & Diet</option>
                                <option value="Infectious Diseases">Infectious Diseases</option>
                                <option value="Mental Wellness">Mental Wellness</option>
                                <option value="General Wellness">General Wellness</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Author / Reviewer Name</label>
                            <input type="text" name="author_name" x-model="editArticle.author_name" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Image</label>
                        <template x-if="editArticle.image_url">
                            <div class="mb-2 flex items-center gap-2">
                                <img :src="editArticle.image_url" class="h-10 w-14 rounded object-cover border border-slate-200" />
                                <span class="text-xs text-slate-500">Current header image</span>
                            </div>
                        </template>
                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Quick Excerpt (English) *</label>
                        <textarea name="excerpt_en" x-model="editArticle.excerpt_en" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Quick Excerpt (Swahili)</label>
                        <textarea name="excerpt_sw" x-model="editArticle.excerpt_sw" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article / Educational Content (English) *</label>
                        <textarea name="content_en" x-model="editArticle.content_en" rows="5" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article (Swahili)</label>
                        <textarea name="content_sw" x-model="editArticle.content_sw" rows="5" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
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

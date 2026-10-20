@extends('layouts.admin')

@section('title', 'FAQs & Knowledge Base Management')
@section('header', 'Frequently Asked Questions (How do i?)')

@section('content')
<div class="space-y-6" x-data="{ 
    addModalOpen: false,
    editModalOpen: false,
    editFaq: {
        id: '',
        question_en: '',
        question_sw: '',
        answer_en: '',
        answer_sw: '',
        category: 'service',
        is_active: true,
        sort_order: 1
    },
    openEdit(item) {
        this.editFaq = Object.assign({}, item);
        this.editModalOpen = true;
    }
}">

    <!-- Top Action Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.faqs.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search }}" 
                    placeholder="Search question or keyword..." 
                    class="text-xs rounded-xl border-slate-300 py-2 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500 w-full xs:w-48 sm:w-64"
                />
                @if($search)
                    <a href="{{ route('admin.faqs.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
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
            <span>Add New FAQ</span>
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-2xs">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- FAQs Table Card -->
    <x-card padding="p-0">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Question</th>
                        <th class="px-6 py-3 font-semibold">Category Badge</th>
                        <th class="px-6 py-3 font-semibold">Answer Preview</th>
                        <th class="px-6 py-3 font-semibold">Order</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 leading-snug">{{ $faq->question_en }}</div>
                                @if($faq->question_sw)
                                    <div class="text-[11px] text-slate-400 italic mt-0.5">{{ $faq->question_sw }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-hospital-100 text-hospital-800 uppercase">
                                    {{ $faq->category }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-sm truncate">
                                {{ $faq->answer_en }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono font-bold text-slate-400">
                                #{{ $faq->sort_order }}
                            </td>
                            <td class="px-6 py-4">
                                @if($faq->is_active)
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
                                        @click="openEdit({{ json_encode($faq) }})" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold text-hospital-700 bg-hospital-50 hover:bg-hospital-100 transition"
                                    >
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.faqs.status', $faq->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button 
                                            type="submit" 
                                            class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $faq->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-emerald-700 bg-emerald-50 hover:bg-emerald-100' }} transition"
                                        >
                                            {{ $faq->is_active ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq->id) }}" class="inline" onsubmit="return confirm('Delete this FAQ?');">
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
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                No FAQs found. Click "Add New FAQ" to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $faqs->links() }}
            </div>
        @endif
    </x-card>

    <!-- =========================================================================
         ADD FAQ MODAL
         ========================================================================= -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="addModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="addModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Add FAQ Question</h3>
                    <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Question (English)</label>
                        <input type="text" name="question_en" required placeholder="e.g. Does Ephamarcy Hospital treat international patients?" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Question (Swahili)</label>
                        <input type="text" name="question_sw" placeholder="Swahili translation..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Category Badge</label>
                        <input type="text" name="category" required value="service" placeholder="service, General, Visiting Rules, Billing..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Answer (English)</label>
                        <textarea name="answer_en" rows="4" required placeholder="Detailed answer..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Answer (Swahili)</label>
                        <textarea name="answer_sw" rows="3" placeholder="Swahili answer..." class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Display on Homepage</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Save FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         EDIT FAQ MODAL
         ========================================================================= -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" @keydown.escape.window="editModalOpen = false">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="editModalOpen = false"></div>
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-xl w-full p-6 space-y-4" @click.stop>
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-lg text-navy-950">Edit FAQ Question</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form :action="'{{ url('admin/faqs') }}/' + editFaq.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Question (English)</label>
                        <input type="text" name="question_en" x-model="editFaq.question_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Question (Swahili)</label>
                        <input type="text" name="question_sw" x-model="editFaq.question_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Category Badge</label>
                            <input type="text" name="category" x-model="editFaq.category" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sort Order #</label>
                            <input type="number" name="sort_order" x-model="editFaq.sort_order" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Answer (English)</label>
                        <textarea name="answer_en" rows="4" x-model="editFaq.answer_en" required class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Answer (Swahili)</label>
                        <textarea name="answer_sw" rows="3" x-model="editFaq.answer_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"></textarea>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" :checked="editFaq.is_active" class="rounded border-slate-300 text-hospital-600 focus:ring-hospital-500">
                            <span class="text-xs font-bold text-slate-700">Display on Homepage</span>
                        </label>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 text-xs font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

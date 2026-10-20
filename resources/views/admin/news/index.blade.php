@extends('layouts.admin')

@section('title', 'News & Bulletins Management')
@section('header', 'Hospital Bulletins & Operational Announcements')

@section('content')
<div class="space-y-8" x-data="{ 
    addNewsOpen: false, 
    editNewsOpen: false,
    addAnnouncementOpen: false,
    editAnnouncementOpen: false,
    editNewsData: {
        id: '',
        title_en: '',
        title_sw: '',
        category: '',
        excerpt_en: '',
        excerpt_sw: '',
        content_en: '',
        content_sw: '',
        featured_image: '',
        is_published: true
    },
    editAnnData: {
        id: '',
        title_en: '',
        title_sw: '',
        type: 'info',
        message_en: '',
        message_sw: '',
        action_url: '',
        action_text_en: '',
        action_text_sw: '',
        expires_at: '',
        is_active: true
    },
    openEditNews(item) {
        this.editNewsData = {
            id: item.id,
            title_en: item.title_en || '',
            title_sw: item.title_sw || '',
            category: item.category || 'Hospital Updates',
            excerpt_en: item.excerpt_en || '',
            excerpt_sw: item.excerpt_sw || '',
            content_en: item.content_en || '',
            content_sw: item.content_sw || '',
            featured_image: item.featured_image || '',
            is_published: !!item.is_published
        };
        this.editNewsOpen = true;
    },
    openEditAnn(item) {
        this.editAnnData = {
            id: item.id,
            title_en: item.title_en || '',
            title_sw: item.title_sw || '',
            type: item.type || 'info',
            message_en: item.message_en || '',
            message_sw: item.message_sw || '',
            action_url: item.action_url || '',
            action_text_en: item.action_text_en || '',
            action_text_sw: item.action_text_sw || '',
            expires_at: item.expires_at ? item.expires_at.substring(0, 10) : '',
            is_active: !!item.is_active
        };
        this.editAnnouncementOpen = true;
    }
}">

    <!-- Active Operational Announcements Section -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-heading font-bold text-slate-900">Hospital Operational Banners</h3>
                <p class="text-xs text-slate-500">Live alerts displayed across the top ticker of the public website.</p>
            </div>
            <button 
                type="button" 
                @click="addAnnouncementOpen = true"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emergency-600 hover:bg-emergency-700 text-white font-semibold text-xs shadow-2xs transition"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>New Announcement</span>
            </button>
        </div>

        <x-card padding="p-0">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Priority</th>
                            <th class="px-6 py-3 font-semibold">Announcement Title</th>
                            <th class="px-6 py-3 font-semibold">Broadcast Message</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($announcements as $ann)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-3">
                                    @if($ann->type === 'urgent')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-600 text-white uppercase">Urgent</span>
                                    @elseif($ann->type === 'alert')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white uppercase">Alert</span>
                                    @elseif($ann->type === 'notice')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-hospital-700 text-white uppercase">Notice</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-sky-600 text-white uppercase">Info</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 font-bold text-slate-900">
                                    {{ $ann->title_en }}
                                    @if($ann->title_sw && $ann->title_sw !== $ann->title_en)
                                        <div class="text-[11px] text-slate-400 font-normal">SW: {{ $ann->title_sw }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-slate-600 max-w-sm">
                                    <div class="line-clamp-1">{{ $ann->message_en }}</div>
                                </td>
                                <td class="px-6 py-3">
                                    @if($ann->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500">
                                            Muted
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            type="button" 
                                            @click="openEditAnn({{ json_encode($ann) }})"
                                            class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                        >
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.news.announcements.status', $ann->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="submit" 
                                                class="font-semibold px-2 py-0.5 rounded border transition {{ $ann->is_active ? 'border-amber-200 text-amber-700 hover:bg-amber-50' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                            >
                                                {{ $ann->is_active ? 'Mute' : 'Activate' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.news.announcements.destroy', $ann->id) }}" class="inline" onsubmit="return confirm('Permanently remove this announcement?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-semibold px-2 py-0.5 text-red-600 hover:text-red-800 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-slate-400">
                                    No announcements active.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <!-- Hospital News Bulletins & Articles -->
    <div class="space-y-4 pt-4 border-t border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-base font-heading font-bold text-slate-900">Hospital News Articles & Press Releases</h3>
                <p class="text-xs text-slate-500">Editorial bulletins, medical advisories, and community outreach news.</p>
            </div>
            <button 
                type="button" 
                @click="addNewsOpen = true"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-semibold text-xs shadow-2xs transition"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Write News Article</span>
            </button>
        </div>

        <x-card padding="p-0">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[720px] text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Article Headline</th>
                            <th class="px-6 py-3 font-semibold">Category</th>
                            <th class="px-6 py-3 font-semibold">Published</th>
                            <th class="px-6 py-3 font-semibold">Views</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($news as $article)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($article->featured_image)
                                            <img src="{{ asset($article->featured_image) }}" alt="" class="h-10 w-14 rounded-lg object-cover border border-slate-200 shrink-0" />
                                        @endif
                                        <div>
                                            <div class="font-bold text-slate-900 leading-tight">{{ $article->title_en }}</div>
                                            @if($article->title_sw && $article->title_sw !== $article->title_en)
                                                <div class="text-[11px] text-slate-400">SW: {{ $article->title_sw }}</div>
                                            @endif
                                            <div class="text-[11px] text-slate-500 line-clamp-1 max-w-md mt-0.5">{{ $article->excerpt_en }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-hospital-800">
                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px]">
                                        {{ $article->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-slate-800">
                                    {{ number_format($article->views_count) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($article->is_published)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('news.show', $article->slug) }}" target="_blank" class="text-hospital-700 font-semibold hover:underline">
                                            View
                                        </a>

                                        <button 
                                            type="button" 
                                            @click="openEditNews({{ json_encode($article) }})"
                                            class="font-semibold px-2 py-0.5 rounded border border-slate-200 text-slate-700 hover:bg-slate-100 transition"
                                        >
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.news.status', $article->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button 
                                                type="submit" 
                                                class="font-semibold px-2 py-0.5 rounded border transition {{ $article->is_published ? 'border-slate-200 text-slate-600 hover:bg-slate-100' : 'border-emerald-200 text-emerald-700 hover:bg-emerald-50' }}"
                                            >
                                                {{ $article->is_published ? 'Unpublish' : 'Publish' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.news.destroy', $article->id) }}" class="inline" onsubmit="return confirm('Permanently remove this article?');">
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
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                    No news articles published yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($news->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $news->links() }}
                </div>
            @endif
        </x-card>
    </div>

    <!-- Write News Modal -->
    <div x-show="addNewsOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addNewsOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Write Hospital News Bulletin</h3>
                        <p class="text-xs text-slate-500">Draft a press release, health advisory, or institutional update.</p>
                    </div>
                    <button @click="addNewsOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Headline Title (English) *</label>
                            <x-input name="title_en" placeholder="e.g. Hospital Launches Next-Gen 3T MRI Suite" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Headline Title (Swahili - Optional)</label>
                            <x-input name="title_sw" placeholder="e.g. Hospitali Yazindua Mashine ya Kisasa ya MRI" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Category *</label>
                            <x-select name="category" required>
                                <option value="Clinical Technology">Clinical Technology</option>
                                <option value="Hospital Updates">Hospital Updates</option>
                                <option value="Public Health">Public Health</option>
                                <option value="Specialist Accreditations">Specialist Accreditations</option>
                                <option value="Community Outreach">Community Outreach</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Featured Photo (JPG, PNG or WebP)</label>
                            <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Summary Excerpt (English) *</label>
                        <x-textarea name="excerpt_en" rows="2" placeholder="Brief 1-2 sentence lead for index card previews..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Summary Excerpt (Swahili - Optional)</label>
                        <x-textarea name="excerpt_sw" rows="2" placeholder="Muhtasari mfupi wa habari..." />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article Body (English) *</label>
                        <x-textarea name="content_en" rows="5" placeholder="Full medical news article content..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article Body (Swahili - Optional)</label>
                        <x-textarea name="content_sw" rows="5" placeholder="Mwili kamili wa habari..." />
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addNewsOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Publish Article
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit News Modal -->
    <div x-show="editNewsOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editNewsOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-2xl w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit News Article</h3>
                        <p class="text-xs text-slate-500">Update story copy, category, or replace header image.</p>
                    </div>
                    <button @click="editNewsOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/news/' + editNewsData.id" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Headline Title (English) *</label>
                            <input type="text" name="title_en" x-model="editNewsData.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Headline Title (Swahili)</label>
                            <input type="text" name="title_sw" x-model="editNewsData.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Category *</label>
                            <select name="category" x-model="editNewsData.category" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                <option value="Clinical Technology">Clinical Technology</option>
                                <option value="Hospital Updates">Hospital Updates</option>
                                <option value="Public Health">Public Health</option>
                                <option value="Specialist Accreditations">Specialist Accreditations</option>
                                <option value="Community Outreach">Community Outreach</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Replace Image</label>
                            <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Summary Excerpt (English) *</label>
                        <textarea name="excerpt_en" x-model="editNewsData.excerpt_en" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Summary Excerpt (Swahili)</label>
                        <textarea name="excerpt_sw" x-model="editNewsData.excerpt_sw" rows="2" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article Body (English) *</label>
                        <textarea name="content_en" x-model="editNewsData.content_en" rows="5" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Full Article Body (Swahili)</label>
                        <textarea name="content_sw" x-model="editNewsData.content_sw" rows="5" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="editNewsOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
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

    <!-- Create Announcement Modal -->
    <div x-show="addAnnouncementOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addAnnouncementOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Broadcast Hospital Notice</h3>
                        <p class="text-xs text-slate-500">Create an urgent bulletin or public advisory for header ticker.</p>
                    </div>
                    <button @click="addAnnouncementOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.news.announcements.store') }}" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Notice Header (English) *</label>
                            <x-input name="title_en" placeholder="e.g. Seasonal Blood Donation Drive" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Notice Header (Swahili - Optional)</label>
                            <x-input name="title_sw" placeholder="e.g. Zoezi la Uchangiaji Damu" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Classification *</label>
                            <x-select name="type" required>
                                <option value="notice">Standard Notice (Teal)</option>
                                <option value="urgent">Urgent Warning (Red Alert)</option>
                                <option value="alert">General Alert (Amber)</option>
                                <option value="info">General Info (Blue)</option>
                            </x-select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Expiry Date (Optional)</label>
                            <input type="date" name="expires_at" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alert Message (English) *</label>
                        <x-textarea name="message_en" rows="3" placeholder="Brief broadcast text shown in top strip..." required />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alert Message (Swahili - Optional)</label>
                        <x-textarea name="message_sw" rows="3" placeholder="Ujumbe wa tahadhari au tangazo..." />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Action Link URL (Optional)</label>
                            <x-input name="action_url" placeholder="/appointment or /contact" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Action Button Text</label>
                            <x-input name="action_text_en" placeholder="e.g. Learn More →" />
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="addAnnouncementOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
                            Cancel
                        </button>
                        <x-button type="submit" variant="primary">
                            Broadcast Alert
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Announcement Modal -->
    <div x-show="editAnnouncementOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editAnnouncementOpen = false"></div>
        <div class="relative min-h-screen flex items-center justify-center p-3 sm:p-4">
            <div class="relative bg-white rounded-2xl max-w-lg w-full max-h-[92vh] overflow-y-auto p-5 sm:p-7 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5 sticky top-0 bg-white z-10">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">Edit Hospital Notice</h3>
                        <p class="text-xs text-slate-500">Update broadcast text, priority level, or expiry schedule.</p>
                    </div>
                    <button @click="editAnnouncementOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" :action="'/admin/news/announcements/' + editAnnData.id" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Notice Header (English) *</label>
                            <input type="text" name="title_en" x-model="editAnnData.title_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Notice Header (Swahili)</label>
                            <input type="text" name="title_sw" x-model="editAnnData.title_sw" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Classification *</label>
                            <select name="type" x-model="editAnnData.type" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required>
                                <option value="notice">Standard Notice (Teal)</option>
                                <option value="urgent">Urgent Warning (Red Alert)</option>
                                <option value="alert">General Alert (Amber)</option>
                                <option value="info">General Info (Blue)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Expiry Date</label>
                            <input type="date" name="expires_at" x-model="editAnnData.expires_at" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alert Message (English) *</label>
                        <textarea name="message_en" x-model="editAnnData.message_en" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" required></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Alert Message (Swahili)</label>
                        <textarea name="message_sw" x-model="editAnnData.message_sw" rows="3" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Action Link URL</label>
                            <input type="text" name="action_url" x-model="editAnnData.action_url" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Action Button Text</label>
                            <input type="text" name="action_text_en" x-model="editAnnData.action_text_en" class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:border-hospital-500 focus:ring-hospital-500" />
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" @click="editAnnouncementOpen = false" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">
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

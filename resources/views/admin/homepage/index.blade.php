@extends('layouts.admin')

@section('title', 'Homepage Material Control Center')
@section('header', 'Homepage Material & Content')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'hero' }">

    <!-- Top Alert Notification / Instructions -->
    <div class="bg-gradient-to-r from-navy-900 to-hospital-800 rounded-2xl p-6 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider text-white mb-2">
                Dynamic CMS Live Editor
            </span>
            <h2 class="text-xl sm:text-2xl font-heading font-black tracking-tight text-white mb-1">
                Hospital Homepage Management Center
            </h2>
            <p class="text-xs sm:text-sm text-slate-200 leading-relaxed font-light">
                All sections and materials displayed on the public homepage can be edited, updated, or re-posted from here. Changes reflect immediately on the live website.
            </p>
        </div>
        <div class="absolute right-0 top-0 bottom-0 w-80 bg-radial from-white/10 to-transparent pointer-events-none"></div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-xs underline text-emerald-700 hover:text-emerald-900 font-bold">
                View On Homepage &rarr;
            </a>
        </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 overflow-x-auto pb-1 scrollbar-none">
        <button 
            type="button" 
            @click="activeTab = 'hero'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'hero' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            1. Hero Slider
        </button>
        <button 
            type="button" 
            @click="activeTab = 'director'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'director' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            2. Executive Director Statement
        </button>
        <button 
            type="button" 
            @click="activeTab = 'videos'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'videos' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            3. Featured Media & Videos
        </button>
        <button 
            type="button" 
            @click="activeTab = 'ticker'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'ticker' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            4. Live Highlights Ticker
        </button>
        <button 
            type="button" 
            @click="activeTab = 'stats'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'stats' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            5. Hospital Statistics
        </button>
        <button 
            type="button" 
            @click="activeTab = 'values'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'values' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            6. Core Values
        </button>
        <button 
            type="button" 
            @click="activeTab = 'insurance'"
            class="px-4 py-2.5 rounded-t-xl font-heading font-bold text-xs uppercase tracking-wider transition whitespace-nowrap"
            :class="activeTab === 'insurance' ? 'bg-white border-t-2 border-x border-slate-200 text-hospital-700 shadow-2xs' : 'text-slate-500 hover:text-navy-950'"
        >
            7. Insurance & Partners
        </button>
    </div>

    <!-- =========================================================================
         TAB 1: HERO ARCHITECTURAL SLIDER
         ========================================================================= -->
    <div x-show="activeTab === 'hero'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.hero') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($heroSlides as $i => $slide)
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h3 class="font-heading font-bold text-base text-navy-950">
                                Slide #{{ $i + 1 }}
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-hospital-100 text-hospital-800 uppercase">
                                Active Slide
                            </span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Slide Title / Headline</label>
                            <input 
                                type="text" 
                                name="slides[{{ $i }}][title]" 
                                value="{{ old("slides.{$i}.title", $slide['title'] ?? '') }}" 
                                class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800 focus:border-hospital-500 focus:ring-hospital-500"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Slide Subtitle / Description</label>
                            <textarea 
                                name="slides[{{ $i }}][sub]" 
                                rows="3"
                                class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-700 focus:border-hospital-500 focus:ring-hospital-500"
                            >{{ old("slides.{$i}.sub", $slide['sub'] ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 1 Label</label>
                                <input 
                                    type="text" 
                                    name="slides[{{ $i }}][btn1_text]" 
                                    value="{{ old("slides.{$i}.btn1_text", $slide['btn1_text'] ?? 'Book Appointment') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 1 URL</label>
                                <input 
                                    type="text" 
                                    name="slides[{{ $i }}][btn1_link]" 
                                    value="{{ old("slides.{$i}.btn1_link", $slide['btn1_link'] ?? '/appointment') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 2 Label</label>
                                <input 
                                    type="text" 
                                    name="slides[{{ $i }}][btn2_text]" 
                                    value="{{ old("slides.{$i}.btn2_text", $slide['btn2_text'] ?? 'Explore Services →') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 2 URL</label>
                                <input 
                                    type="text" 
                                    name="slides[{{ $i }}][btn2_link]" 
                                    value="{{ old("slides.{$i}.btn2_link", $slide['btn2_link'] ?? '/services') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800"
                                />
                            </div>
                        </div>

                        <div class="pt-2 border-t border-slate-100">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Background Image</label>
                            <input type="hidden" name="slides[{{ $i }}][image_existing]" value="{{ $slide['image'] ?? '' }}"/>
                            <div class="flex items-center gap-3">
                                <div class="h-14 w-24 rounded-lg bg-slate-900 overflow-hidden shrink-0 border border-slate-200">
                                    <img src="{{ asset($slide['image'] ?? 'images/hero_hospital_facade.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <input 
                                        type="file" 
                                        name="slides[{{ $i }}][image_file]" 
                                        accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100 cursor-pointer"
                                    />
                                    <span class="block text-[10px] text-slate-400 mt-1 truncate">Current: {{ $slide['image'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                    Save Hero Architectural Slides
                </button>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 2: EXECUTIVE DIRECTOR'S STATEMENT
         ========================================================================= -->
    <div x-show="activeTab === 'director'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.director') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-6">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-base text-navy-950">
                        Executive Director Statement & Portrait
                    </h3>
                    <p class="text-xs text-slate-500">
                        Matches the dedicated leadership statement section with studio portrait and action buttons.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                    
                    <!-- Director Photo Preview & Upload -->
                    <div class="md:col-span-4 space-y-3">
                        <label class="block text-xs font-bold text-slate-700">Director Studio Portrait</label>
                        <div class="aspect-[4/5] rounded-2xl bg-sky-500 overflow-hidden border border-slate-200 relative shadow-xs max-w-xs mx-auto md:max-w-none">
                            <img src="{{ asset($director['photo'] ?? 'images/director_dr_delilah.jpg') }}" alt="Director Preview" class="w-full h-full object-cover object-top">
                        </div>
                        <input 
                            type="file" 
                            name="photo_file" 
                            accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100 cursor-pointer"
                        />
                        <span class="block text-[10px] text-slate-400">Current file: {{ $director['photo'] ?? 'images/director_dr_delilah.jpg' }}</span>
                    </div>

                    <!-- Fields -->
                    <div class="md:col-span-8 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Director Full Name</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    value="{{ old('name', $director['name'] ?? 'Dr. Delilah Charles Kimambo') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Executive Title</label>
                                <input 
                                    type="text" 
                                    name="title" 
                                    value="{{ old('title', $director['title'] ?? 'Executive Director') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800"
                                    required
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Institution Label</label>
                                <input 
                                    type="text" 
                                    name="hospital" 
                                    value="{{ old('hospital', $director['hospital'] ?? 'Ephamarcy Hospital') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800"
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Section Heading Title</label>
                                <input 
                                    type="text" 
                                    name="statement_title" 
                                    value="{{ old('statement_title', $director['statement_title'] ?? "Executive Director's Statement") }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800"
                                    required
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Statement Lead Text (Always Visible)</label>
                            <textarea 
                                name="lead" 
                                rows="4" 
                                class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"
                                required
                            >{{ old('lead', $director['lead'] ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Extended Bio / Statement (Revealed on 'See more' click)</label>
                            <textarea 
                                name="extended" 
                                rows="3" 
                                class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 text-slate-800 leading-relaxed"
                            >{{ old('extended', $director['extended'] ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 1 Label (Navy Solid)</label>
                                <input 
                                    type="text" 
                                    name="btn1_text" 
                                    value="{{ old('btn1_text', $director['btn1_text'] ?? 'DISCOVER OUR MISSION') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800 font-bold"
                                />
                                <input 
                                    type="text" 
                                    name="btn1_link" 
                                    value="{{ old('btn1_link', $director['btn1_link'] ?? '/about/mission-vision') }}" 
                                    placeholder="URL" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-600 mt-1 font-mono"
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600 mb-1">Button 2 Label (Red Outline)</label>
                                <input 
                                    type="text" 
                                    name="btn2_text" 
                                    value="{{ old('btn2_text', $director['btn2_text'] ?? 'MEET OUR TEAM') }}" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800 font-bold"
                                />
                                <input 
                                    type="text" 
                                    name="btn2_link" 
                                    value="{{ old('btn2_link', $director['btn2_link'] ?? '/doctors') }}" 
                                    placeholder="URL" 
                                    class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-600 mt-1 font-mono"
                                />
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                        Update Director Statement & Profile
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 3: FEATURED MEDIA & VIDEOS
         ========================================================================= -->
    <div x-show="activeTab === 'videos'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.videos') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($videos as $vi => $vid)
                    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                            <span class="font-heading font-bold text-xs text-navy-950 uppercase">Video Card #{{ $vi + 1 }}</span>
                            <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded">YouTube Style</span>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Video Title</label>
                            <input 
                                type="text" 
                                name="videos[{{ $vi }}][title]" 
                                value="{{ old("videos.{$vi}.title", $vid['title'] ?? '') }}" 
                                class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 font-semibold text-slate-800"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Channel / Badge Label</label>
                            <input 
                                type="text" 
                                name="videos[{{ $vi }}][channel]" 
                                value="{{ old("videos.{$vi}.channel", $vid['channel'] ?? 'Hospital TV') }}" 
                                class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-800"
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Video / YouTube URL</label>
                            <input 
                                type="text" 
                                name="videos[{{ $vi }}][url]" 
                                value="{{ old("videos.{$vi}.url", $vid['url'] ?? 'https://www.youtube.com') }}" 
                                class="w-full text-xs rounded-xl border-slate-300 py-1.5 px-3 text-slate-600 font-mono"
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Thumbnail Image</label>
                            <input type="hidden" name="videos[{{ $vi }}][image_existing]" value="{{ $vid['image'] ?? '' }}"/>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="h-12 w-20 rounded-lg bg-slate-900 overflow-hidden shrink-0 border border-slate-200">
                                    <img src="{{ asset($vid['image'] ?? 'images/media_doctor_interview.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <span class="text-[10px] text-slate-400 truncate">{{ $vid['image'] ?? '' }}</span>
                            </div>
                            <input 
                                type="file" 
                                name="videos[{{ $vi }}][image_file]" 
                                accept="image/*"
                                class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100 cursor-pointer"
                            />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                    Save Video Cards
                </button>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 4: LIVE HIGHLIGHTS TICKER
         ========================================================================= -->
    <div x-show="activeTab === 'ticker'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.ticker') }}">
            @csrf
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-6">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-base text-navy-950">
                        Operational Highlights Marquee Ticker
                    </h3>
                    <p class="text-xs text-slate-500">
                        Right-to-left automatic swipe strip located directly beneath the executive director statement.
                    </p>
                </div>

                <div class="max-w-md">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ticker Left Badge Text</label>
                    <input 
                        type="text" 
                        name="badge" 
                        value="{{ old('badge', $ticker['badge'] ?? 'HIGHLIGHTS') }}" 
                        class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-bold uppercase tracking-wider text-slate-800"
                        required
                    />
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Ticker Feed Items</label>
                    
                    @php
                        $items = $ticker['items'] ?? [];
                        // Ensure at least 4 items for display
                        while(count($items) < 4) {
                            $items[] = ['tag' => 'NEWS', 'text' => ''];
                        }
                    @endphp

                    @foreach($items as $ti => $item)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                            <span class="text-xs font-bold text-slate-400 w-6 text-center">#{{ $ti + 1 }}</span>
                            <div class="w-32 shrink-0">
                                <select name="items[{{ $ti }}][tag]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-2 font-bold text-slate-700">
                                    <option value="NEWS" {{ ($item['tag'] ?? '') === 'NEWS' ? 'selected' : '' }}>NEWS:</option>
                                    <option value="EMERGENCY" {{ ($item['tag'] ?? '') === 'EMERGENCY' ? 'selected' : '' }}>EMERGENCY:</option>
                                    <option value="ALERT" {{ ($item['tag'] ?? '') === 'ALERT' ? 'selected' : '' }}>ALERT:</option>
                                    <option value="NOTICE" {{ ($item['tag'] ?? '') === 'NOTICE' ? 'selected' : '' }}>NOTICE:</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <input 
                                    type="text" 
                                    name="items[{{ $ti }}][text]" 
                                    value="{{ old("items.{$ti}.text", $item['text'] ?? '') }}" 
                                    placeholder="Enter bulletin text..." 
                                    class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-800 uppercase"
                                />
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                        Update Live Ticker Marquee
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 5: HOSPITAL STATISTICS
         ========================================================================= -->
    <div x-show="activeTab === 'stats'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.stats') }}">
            @csrf
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-6">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-base text-navy-950">
                        Hospital Key Statistics Counters
                    </h3>
                    <p class="text-xs text-slate-500">
                        Animated counting numbers in the navy section above insurance partners.
                    </p>
                </div>

                <div class="max-w-md">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Section Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        value="{{ old('title', $stats['title'] ?? 'Hospital Statistics') }}" 
                        class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 font-semibold text-slate-800"
                        required
                    />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-navy-900">Counter 1: Beds</label>
                        <input 
                            type="text" 
                            name="beds_number" 
                            value="{{ old('beds_number', $stats['beds_number'] ?? '1,500') }}" 
                            placeholder="e.g. 1,500" 
                            class="w-full text-sm font-black font-heading rounded-lg border-slate-300 py-2 px-3 text-slate-900"
                        />
                        <input 
                            type="text" 
                            name="beds_label" 
                            value="{{ old('beds_label', $stats['beds_label'] ?? 'Beds') }}" 
                            class="w-full text-xs rounded-lg border-slate-300 py-1 px-3 text-slate-600"
                        />
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-navy-900">Counter 2: Doctors</label>
                        <input 
                            type="text" 
                            name="doctors_number" 
                            value="{{ old('doctors_number', $stats['doctors_number'] ?? '300+') }}" 
                            placeholder="e.g. 300+" 
                            class="w-full text-sm font-black font-heading rounded-lg border-slate-300 py-2 px-3 text-slate-900"
                        />
                        <input 
                            type="text" 
                            name="doctors_label" 
                            value="{{ old('doctors_label', $stats['doctors_label'] ?? 'Doctors') }}" 
                            class="w-full text-xs rounded-lg border-slate-300 py-1 px-3 text-slate-600"
                        />
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-navy-900">Counter 3: Staff Members</label>
                        <input 
                            type="text" 
                            name="staff_number" 
                            value="{{ old('staff_number', $stats['staff_number'] ?? '2,500+') }}" 
                            placeholder="e.g. 2,500+" 
                            class="w-full text-sm font-black font-heading rounded-lg border-slate-300 py-2 px-3 text-slate-900"
                        />
                        <input 
                            type="text" 
                            name="staff_label" 
                            value="{{ old('staff_label', $stats['staff_label'] ?? 'Staff Members') }}" 
                            class="w-full text-xs rounded-lg border-slate-300 py-1 px-3 text-slate-600"
                        />
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-navy-900">Counter 4: Patients</label>
                        <input 
                            type="text" 
                            name="patients_number" 
                            value="{{ old('patients_number', $stats['patients_number'] ?? '100K+') }}" 
                            placeholder="e.g. 100K+" 
                            class="w-full text-sm font-black font-heading rounded-lg border-slate-300 py-2 px-3 text-slate-900"
                        />
                        <input 
                            type="text" 
                            name="patients_label" 
                            value="{{ old('patients_label', $stats['patients_label'] ?? 'Annual Patients') }}" 
                            class="w-full text-xs rounded-lg border-slate-300 py-1 px-3 text-slate-600"
                        />
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                        Update Statistics Counters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 6: CORE VALUES
         ========================================================================= -->
    <div x-show="activeTab === 'values'" x-cloak class="space-y-6">
        <form method="POST" action="{{ route('admin.homepage.values') }}">
            @csrf
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-6">
                <div class="pb-3 border-b border-slate-100">
                    <h3 class="font-heading font-bold text-base text-navy-950">
                        Our Core Values Section
                    </h3>
                    <p class="text-xs text-slate-500">
                        Displays in column 2 of the institutional hub alongside "How do i?" FAQs and headlines.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($coreValues as $cvi => $cVal)
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                            <span class="text-xs font-bold text-slate-500 uppercase">Value #{{ $cvi + 1 }}</span>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Title</label>
                                <input 
                                    type="text" 
                                    name="values[{{ $cvi }}][title]" 
                                    value="{{ old("values.{$cvi}.title", $cVal['title'] ?? '') }}" 
                                    class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 font-bold text-slate-800"
                                    required
                                />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Description</label>
                                <textarea 
                                    name="values[{{ $cvi }}][description]" 
                                    rows="3" 
                                    class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-700"
                                    required
                                >{{ old("values.{$cvi}.description", $cVal['description'] ?? '') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Accent Color</label>
                                <select name="values[{{ $cvi }}][color]" class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-700">
                                    <option value="navy" {{ ($cVal['color'] ?? '') === 'navy' ? 'selected' : '' }}>Navy Blue</option>
                                    <option value="amber" {{ ($cVal['color'] ?? '') === 'amber' ? 'selected' : '' }}>Amber Gold</option>
                                    <option value="teal" {{ ($cVal['color'] ?? '') === 'teal' ? 'selected' : '' }}>Teal Green</option>
                                    <option value="red" {{ ($cVal['color'] ?? '') === 'red' ? 'selected' : '' }}>Crimson Red</option>
                                    <option value="purple" {{ ($cVal['color'] ?? '') === 'purple' ? 'selected' : '' }}>Royal Purple</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                        Update Core Values
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =========================================================================
         TAB 7: INSURANCE SERVICES & CORPORATE PARTNERS
         ========================================================================= -->
    <div x-show="activeTab === 'insurance'" x-cloak class="space-y-6" x-data="{
        partners: {{ json_encode($insurancePartners ?: []) }},
        addPartner() {
            this.partners.push({
                name: '',
                subtitle: '',
                badge_text: '',
                badge_color: 'navy',
                website_url: '',
                logo: null
            });
        },
        removePartner(index) {
            this.partners.splice(index, 1);
        }
    }">
        <form method="POST" action="{{ route('admin.homepage.insurance') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <h3 class="font-heading font-bold text-base text-navy-950">
                            Insurance Services & Corporate Partners
                        </h3>
                        <p class="text-xs text-slate-500">
                            These logos and partner cards scroll in an infinite marquee at the bottom of the public homepage.
                        </p>
                    </div>
                    <button 
                        type="button" 
                        @click="addPartner()" 
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-hospital-50 text-hospital-700 border border-slate-200 font-bold text-xs transition"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Add New Partner</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(partner, pIndex) in partners" :key="pIndex">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 relative group transition hover:border-slate-300">
                            <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-3">
                                <span class="font-bold text-xs text-slate-700 flex items-center gap-2">
                                    <span class="h-6 w-6 rounded-full bg-navy-800 text-white flex items-center justify-center text-[10px]" x-text="pIndex + 1"></span>
                                    <span x-text="partner.name || 'New Insurance / Partner'"></span>
                                </span>
                                <button 
                                    type="button" 
                                    @click="removePartner(pIndex)" 
                                    class="text-xs text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 transition"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Remove</span>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Partner Name *</label>
                                    <input 
                                        type="text" 
                                        :name="'partners[' + pIndex + '][name]'" 
                                        x-model="partner.name"
                                        placeholder="e.g. NHIF Tanzania"
                                        class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 font-semibold text-slate-800 focus:border-hospital-500 focus:ring-hospital-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Tagline / Subtitle</label>
                                    <input 
                                        type="text" 
                                        :name="'partners[' + pIndex + '][subtitle]'" 
                                        x-model="partner.subtitle"
                                        placeholder="e.g. National Health Insurance Fund"
                                        class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-700 focus:border-hospital-500 focus:ring-hospital-500"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Acronym / Text</label>
                                    <input 
                                        type="text" 
                                        :name="'partners[' + pIndex + '][badge_text]'" 
                                        x-model="partner.badge_text"
                                        placeholder="e.g. NHIF"
                                        class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 uppercase font-bold text-slate-800 focus:border-hospital-500 focus:ring-hospital-500"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Badge Color Theme</label>
                                    <select 
                                        :name="'partners[' + pIndex + '][badge_color]'" 
                                        x-model="partner.badge_color"
                                        class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-700 focus:border-hospital-500 focus:ring-hospital-500"
                                    >
                                        <option value="emerald">Emerald Green (NHIF style)</option>
                                        <option value="amber">Amber Gold (NSSF style)</option>
                                        <option value="navy">Navy Blue (Corporate style)</option>
                                        <option value="purple">Royal Purple (Strategis style)</option>
                                        <option value="teal">Teal Green (Assemble style)</option>
                                        <option value="orange">Orange (GA style)</option>
                                        <option value="red">Crimson Red</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-3 pt-3 border-t border-slate-200/60">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Website URL (Optional)</label>
                                    <input 
                                        type="url" 
                                        :name="'partners[' + pIndex + '][website_url]'" 
                                        x-model="partner.website_url"
                                        placeholder="https://..."
                                        class="w-full text-xs rounded-lg border-slate-300 py-1.5 px-3 text-slate-700 focus:border-hospital-500 focus:ring-hospital-500"
                                    />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Upload Logo Image (Optional PNG/SVG)</label>
                                    <div class="flex items-center gap-2">
                                        <input 
                                            type="file" 
                                            :name="'partners[' + pIndex + '][logo_file]'" 
                                            accept="image/*"
                                            class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[11px] file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300"
                                        />
                                        <input 
                                            type="hidden" 
                                            :name="'partners[' + pIndex + '][logo_existing]'" 
                                            :value="partner.logo || ''"
                                        />
                                    </div>
                                    <template x-if="partner.logo">
                                        <p class="text-[10px] text-emerald-600 mt-1 flex items-center gap-1">
                                            <span>Current Logo:</span>
                                            <span class="font-mono text-[9px]" x-text="partner.logo"></span>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                    <button 
                        type="button" 
                        @click="addPartner()" 
                        class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase tracking-wider transition"
                    >
                        + Add Another Partner
                    </button>
                    <button 
                        type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition"
                    >
                        Save All Insurance & Partners
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection

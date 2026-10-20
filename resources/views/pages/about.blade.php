@extends('layouts.public')

@section('title', ($page->title ?? 'About Us') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            'About Us' => route('about'),
            ($page->title ?? 'Overview') => null
        ]" />

        <!-- Header -->
        <div class="mb-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Institutional Profile
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ $page->title ?? 'About Ephamarcy Hospital' }}
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                {{ $page->excerpt ?? 'Committed to clinical excellence, patient dignity, and world-class healthcare.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation Tabs -->
            <div class="lg:col-span-1 bg-white p-2.5 sm:p-3 rounded-2xl border border-slate-200/80 shadow-soft self-start lg:sticky lg:top-24">
                <span class="px-2 py-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Institutional Overview</span>
                <div class="flex flex-wrap lg:flex-col gap-1.5">
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ empty($section) ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Hospital Overview
                    </a>
                    <a href="{{ route('about.section', 'history') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'history' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        History & Milestones
                    </a>
                    <a href="{{ route('about.section', 'mission-vision') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'mission-vision' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Mission, Vision & Values
                    </a>
                    <a href="{{ route('about.section', 'leadership') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'leadership' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Board & Leadership
                    </a>
                    <a href="{{ route('about.section', 'organization') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'organization' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Governance Structure
                    </a>
                    <a href="{{ route('about.section', 'quality-and-safety') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'quality-and-safety' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Quality & Safety Standards
                    </a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Page Body Card -->
                <x-card padding="p-8 sm:p-10" class="shadow-card border-slate-200">
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                        {!! nl2br(e($page->content ?? 'Institutional details currently being updated.')) !!}
                    </div>

                    <!-- Leadership Profiles Section (if on leadership tab) -->
                    @if($section === 'leadership' && isset($leaders))
                        <div class="mt-12 pt-8 border-t border-slate-200">
                            @foreach($leaders as $category => $members)
                                <div class="mb-10 last:mb-0">
                                    <h3 class="text-xl font-heading font-bold text-navy-950 mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-hospital-600"></span>
                                        {{ $category }}
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        @foreach($members as $member)
                                            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 flex gap-4">
                                                @if(!empty($member->photo))
                                                    <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="h-16 w-16 rounded-2xl object-cover object-top shrink-0 shadow-sm border border-slate-200">
                                                @else
                                                    <div class="h-16 w-16 rounded-2xl bg-gradient-to-tr from-hospital-700 to-hospital-500 text-white flex items-center justify-center font-bold text-xl shrink-0 shadow-sm">
                                                        {{ substr($member->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-heading font-bold text-base text-slate-900">{{ $member->name }}</h4>
                                                    <span class="text-xs font-semibold text-hospital-700 block mb-2">{{ $member->title }}</span>
                                                    <p class="text-xs text-slate-600 leading-relaxed">{{ $member->bio }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>

                <!-- Quick Appointment Callout -->
                <div class="bg-gradient-to-r from-hospital-800 to-navy-900 rounded-2xl p-6 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="font-heading font-bold text-lg">Need Specialist Medical Consultation?</h4>
                        <p class="text-xs text-hospital-200 mt-1">Book outpatient appointments across any of our 6 clinical departments.</p>
                    </div>
                    <x-button href="{{ route('appointments.create') }}" variant="primary" size="md" class="bg-hospital-500 text-slate-950 hover:bg-hospital-400 font-bold shrink-0">
                        Book Consultation
                    </x-button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

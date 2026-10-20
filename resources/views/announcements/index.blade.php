@extends('layouts.public')

@section('title', __('hospital.nav.announcements') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.announcements') => null
        ]" />

        <div class="max-w-3xl mb-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200 mb-3">
                Hospital Notices
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ __('hospital.nav.announcements') }}
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                Emergency operational notices, casualty alerts, public blood donation drives, and hospital community advisories.
            </p>
        </div>

        @if($announcements->isEmpty())
            <x-empty-state title="No active announcements" description="There are currently no urgent alerts or notices." />
        @else
            <div class="space-y-4">
                @foreach($announcements as $ann)
                    <div class="p-4 xs:p-6 rounded-2xl bg-white border border-slate-200 shadow-soft flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex flex-col xs:flex-row items-start gap-3 xs:gap-4">
                            <span class="p-3 rounded-xl shrink-0 mt-0.5 {{ $ann->type === 'urgent' ? 'bg-red-50 text-red-600' : 'bg-hospital-50 text-hospital-700' }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </span>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $ann->type === 'urgent' ? 'bg-red-600 text-white' : 'bg-hospital-100 text-hospital-800' }}">
                                        {{ $ann->type }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $ann->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="font-heading font-bold text-lg text-slate-900 mb-1">
                                    {{ $ann->title }}
                                </h3>
                                <p class="text-sm text-slate-600 leading-relaxed max-w-3xl">
                                    {{ $ann->message }}
                                </p>
                            </div>
                        </div>

                        @if($ann->action_url)
                            <div class="shrink-0 w-full xs:w-auto self-stretch xs:self-end md:self-center">
                                <x-button href="{{ $ann->action_url }}" variant="outline-primary" size="sm" class="w-full xs:w-auto text-center justify-center">
                                    {{ $ann->action_text ?? 'View Details' }}
                                </x-button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($announcements->hasPages())
                <div class="mt-8">
                    {{ $announcements->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

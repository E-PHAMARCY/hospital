@extends('layouts.public')

@section('title', $location->name . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            'Locations & Campuses' => route('locations.index'),
            $location->name => null
        ]" />

        <div class="h-60 sm:h-80 w-full rounded-2xl overflow-hidden shadow-card border border-slate-200 mt-6 relative bg-slate-900">
            <img src="{{ $location->is_main ? asset('images/branch_upanga_campus.jpg') : asset('images/hero_hospital_facade.jpg') }}" alt="{{ $location->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6">
                <div class="mb-2">
                    @if($location->is_main)
                        <span class="px-2.5 py-1 rounded bg-hospital-600 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm">Main Referral Hospital</span>
                    @else
                        <span class="px-2.5 py-1 rounded bg-navy-800 text-white text-[11px] font-bold uppercase tracking-wider shadow-sm">Outpatient Clinic</span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-extrabold text-white drop-shadow-md">
                    {{ $location->name }}
                </h1>
            </div>
        </div>

        <x-card padding="p-5 xs:p-8 sm:p-12" class="shadow-card border-slate-200 mt-6">

            <p class="text-base text-slate-600 leading-relaxed mb-8">
                {{ $location->description }}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-5 xs:p-6 rounded-2xl bg-slate-50 border border-slate-200 mb-8 text-xs text-slate-700">
                <div>
                    <span class="text-slate-400 font-semibold uppercase block mb-1">Physical Address</span>
                    <strong class="text-slate-900 block text-sm">{{ $location->address }}</strong>
                </div>

                @if($location->phone)
                    <div>
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Telephone Contact</span>
                        <strong class="font-mono text-slate-900 block text-sm">{{ $location->phone }}</strong>
                    </div>
                @endif

                @if($location->opening_hours)
                    <div class="md:col-span-2">
                        <span class="text-slate-400 font-semibold uppercase block mb-1">Operating Hours</span>
                        <span class="text-slate-900 font-medium block">{{ $location->opening_hours }}</span>
                    </div>
                @endif
            </div>

            @if($location->google_map_url)
                <div class="mb-8">
                    <a href="{{ $location->google_map_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-xs font-bold text-hospital-700 hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Open Location in Google Maps</span>
                    </a>
                </div>
            @endif

            <div class="flex flex-col xs:flex-row items-stretch xs:items-center gap-3 xs:gap-4 pt-6 border-t border-slate-100">
                <x-button href="{{ route('appointments.create') }}" variant="primary" size="md" class="w-full xs:w-auto text-center justify-center">
                    Schedule Visit at this Campus
                </x-button>
                <x-button href="{{ route('locations.index') }}" variant="outline" size="md" class="w-full xs:w-auto text-center justify-center">
                    Back to All Locations
                </x-button>
            </div>
        </x-card>

    </div>
</div>
@endsection

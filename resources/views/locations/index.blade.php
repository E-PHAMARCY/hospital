@extends('layouts.public')

@section('title', 'Hospital Locations & Campuses — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            'Locations & Campuses' => null
        ]" />

        <div class="max-w-3xl mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Hospital Network
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                Campuses & Clinics
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                Find addresses, operating hours, emergency casualty desks, and driving directions across our hospital network.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @php
                $campusImages = [
                    asset('images/branch_upanga_campus.jpg'),
                    asset('images/hero_hospital_facade.jpg'),
                    asset('images/hero_surgery_suite.jpg'),
                ];
            @endphp
            @foreach($locations as $loc)
                @php
                    $cImage = $campusImages[$loop->index % count($campusImages)];
                @endphp
                <x-card padding="p-0" class="border-slate-200/90 shadow-card flex flex-col justify-between overflow-hidden group">
                    <div class="h-48 w-full relative overflow-hidden bg-slate-800">
                        <img src="{{ $cImage }}" alt="{{ $loc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent"></div>
                        <div class="absolute top-4 left-4">
                            @if($loc->is_main)
                                <x-badge color="hospital" size="sm">Main Tertiary Hospital</x-badge>
                            @else
                                <x-badge color="navy" size="sm">Outpatient Clinic</x-badge>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 sm:p-8 flex-1 flex flex-col justify-between">
                        <div>
                            <h2 class="text-2xl font-heading font-bold text-navy-950 mb-3 group-hover:text-hospital-700 transition">
                                <a href="{{ route('locations.show', $loc->slug) }}">
                                    {{ $loc->name }}
                                </a>
                            </h2>

                            <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                                {{ $loc->description }}
                            </p>
                        </div>

                        <div class="space-y-3 text-xs text-slate-600 border-t border-slate-100 pt-4">
                            <div class="flex items-start gap-2.5">
                                <svg class="w-4 h-4 text-hospital-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $loc->address }}</span>
                            </div>

                            @if($loc->phone)
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-hospital-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="font-mono font-semibold">{{ $loc->phone }}</span>
                                </div>
                            @endif

                            @if($loc->opening_hours)
                                <div class="flex items-start gap-2.5">
                                    <svg class="w-4 h-4 text-hospital-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $loc->opening_hours }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 pt-4 border-t border-slate-100 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-3">
                        <a href="{{ route('locations.show', $loc->slug) }}" class="text-xs font-bold text-hospital-700 hover:underline">
                            Campus Details & Directions &rarr;
                        </a>
                        <x-button href="{{ route('appointments.create') }}" variant="outline" size="sm" class="w-full xs:w-auto text-center">
                            Book Visit
                        </x-button>
                    </div>
                </x-card>
            @endforeach
        </div>

    </div>
</div>
@endsection

@extends('layouts.public')

@section('title', $service->name . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.services') => route('services.index'),
            $service->name => null
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
            <!-- Left Main Details -->
            <div class="lg:col-span-2 space-y-8">
                @php
                    $slug = strtolower($service->slug ?? '');
                    $deptSlug = strtolower($service->department->slug ?? '');
                    
                    if (str_contains($slug, 'rehab') || str_contains($deptSlug, 'rehab')) {
                        $img = asset('images/service_rehab.jpg');
                    } elseif (str_contains($slug, 'dent') || str_contains($deptSlug, 'dent')) {
                        $img = asset('images/service_dental.jpg');
                    } elseif (str_contains($slug, 'obgyn') || str_contains($slug, 'matern') || str_contains($deptSlug, 'matern') || str_contains($slug, 'women')) {
                        $img = asset('images/service_obgyn.jpg');
                    } elseif (str_contains($slug, 'paed') || str_contains($slug, 'ped') || str_contains($deptSlug, 'ped') || str_contains($slug, 'child')) {
                        $img = asset('images/service_paediatric.jpg');
                    } elseif (str_contains($slug, 'card') || str_contains($deptSlug, 'card') || str_contains($slug, 'heart')) {
                        $img = asset('images/media_cardiac_surgery.jpg');
                    } elseif (str_contains($slug, 'plas') || str_contains($deptSlug, 'plas') || str_contains($slug, 'surg')) {
                        $img = asset('images/service_plastic.jpg');
                    } elseif (str_contains($slug, 'mri') || str_contains($slug, 'diag') || str_contains($slug, 'imag') || str_contains($slug, 'scan')) {
                        $img = asset('images/news_mri_diagnostic.jpg');
                    } else {
                        $img = asset('images/hero_surgery_suite.jpg');
                    }
                @endphp
                <div class="h-60 sm:h-80 w-full rounded-3xl overflow-hidden shadow-card border border-slate-200 relative bg-slate-900">
                    <img src="{{ $img }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            @if($service->is_emergency)
                                <span class="px-2.5 py-1 rounded bg-hospital-600 text-white text-xs font-bold uppercase tracking-wider shadow-sm">24/7 Emergency Service</span>
                            @endif
                            @if($service->department)
                                <span class="px-2.5 py-1 rounded bg-navy-800 text-white text-xs font-bold uppercase tracking-wider shadow-sm">{{ $service->department->name }}</span>
                            @endif
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-extrabold text-white drop-shadow-md">
                            {{ $service->name }}
                        </h1>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 xs:p-8 sm:p-10 shadow-soft border border-slate-200">
                    <p class="text-base text-slate-600 leading-relaxed mb-6 font-medium">
                        {{ $service->summary }}
                    </p>

                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base border-t border-slate-100 pt-6 space-y-4">
                        {!! nl2br(e($service->description ?? $service->summary)) !!}
                    </div>
                </div>

                <!-- Doctors in this Department -->
                @if($service->department && $service->department->doctors->isNotEmpty())
                    <div>
                        <h3 class="text-xl font-heading font-bold text-navy-950 mb-6">
                            Specialists Performing {{ $service->name }}
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($service->department->doctors as $doc)
                                <x-doctor-card :doctor="$doc" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Sidebar CTA -->
            <div class="space-y-6">
                <x-card padding="p-6">
                    <h3 class="font-heading font-bold text-base text-navy-950 mb-3">
                        Schedule this Service
                    </h3>
                    <p class="text-xs text-slate-600 mb-6 leading-relaxed">
                        Request an outpatient appointment or consult with our triage team regarding pre-procedure preparation.
                    </p>
                    <x-button href="{{ route('appointments.create', ['dept' => $service->department_id]) }}" variant="primary" size="lg" class="w-full">
                        Request Appointment
                    </x-button>
                </x-card>

                @if($service->is_emergency)
                    <div class="p-6 rounded-2xl bg-emergency-600 text-white shadow-soft">
                        <span class="text-xs uppercase font-bold tracking-wider block mb-1">Acute Casualty Emergency</span>
                        <h4 class="font-heading font-bold text-lg mb-2">24/7 Ambulance Dispatch</h4>
                        <p class="text-xs text-red-100 mb-4">
                            For urgent clinical crises or ambulance transport, contact our casualty center immediately.
                        </p>
                        <a href="tel:+255742448965" class="block text-center py-2.5 px-4 rounded-xl bg-white text-emergency-600 font-extrabold text-sm hover:bg-red-50 transition">
                            +255742448965
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

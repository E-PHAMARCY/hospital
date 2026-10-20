@extends('layouts.public')

@section('title', $department->name . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.departments') => route('departments.index'),
            $department->name => null
        ]" />

        <!-- Department Header Card -->
        <div class="bg-gradient-to-r from-hospital-900 via-hospital-800 to-navy-950 rounded-3xl p-6 sm:p-10 lg:p-12 text-white mb-10 shadow-soft relative overflow-hidden">
            <div class="max-w-3xl relative z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-hospital-200 border border-white/15 mb-4">
                    {{ $department->location ?? 'Main Clinical Wing' }}
                </span>
                <h1 class="text-2xl xs:text-3xl sm:text-4xl lg:text-5xl font-heading font-extrabold tracking-tight">
                    {{ $department->name }}
                </h1>
                <p class="mt-4 text-hospital-100/90 text-sm sm:text-base lg:text-lg leading-relaxed">
                    {{ $department->summary }}
                </p>

                <div class="mt-8 flex flex-col xs:flex-row flex-wrap items-stretch xs:items-center gap-4">
                    <x-button href="{{ route('appointments.create', ['dept' => $department->id]) }}" variant="primary" size="lg" class="bg-hospital-500 text-slate-950 hover:bg-hospital-400 font-bold w-full xs:w-auto text-center justify-center">
                        Book Appointment in this Department
                    </x-button>
                    @if($department->phone)
                        <a href="tel:{{ $department->phone }}" class="text-xs text-white hover:text-hospital-200 font-mono font-bold flex items-center justify-center xs:justify-start gap-2 py-2">
                            <span>Direct Desk:</span>
                            <span>{{ $department->phone }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
            <!-- Left 2 Cols: Description & Associated Services -->
            <div class="lg:col-span-2 space-y-8 sm:space-y-10">
                <!-- Description -->
                <x-card padding="p-5 xs:p-6 sm:p-8" class="shadow-card border-slate-200">
                    <h2 class="text-xl font-heading font-bold text-navy-950 mb-4 pb-2 border-b border-slate-100">
                        Department Overview & Clinical Scope
                    </h2>
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                        {!! nl2br(e($department->description ?? $department->summary)) !!}
                    </div>
                </x-card>

                <!-- Associated Services -->
                @if($department->services->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-heading font-bold text-navy-950 mb-6">
                            Clinical Services in {{ $department->name }}
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($department->services as $srv)
                                <x-service-card :service="$srv" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Associated Doctors -->
                @if($department->doctors->isNotEmpty())
                    <div>
                        <h2 class="text-xl font-heading font-bold text-navy-950 mb-6">
                            Specialists & Faculty in this Department
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($department->doctors as $doc)
                                <x-doctor-card :doctor="$doc" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Col: Contact & Location Card -->
            <div class="space-y-6">
                <x-card padding="p-6" class="border-slate-200">
                    <h3 class="font-heading font-bold text-base text-slate-900 mb-4">
                        Department Location & Info
                    </h3>
                    <div class="space-y-4 text-xs text-slate-600">
                        <div>
                            <span class="text-slate-400 block font-semibold uppercase">Physical Location</span>
                            <span class="text-slate-800 font-medium text-sm mt-0.5 block">{{ $department->location ?? 'Main Hospital Campus' }}</span>
                        </div>
                        @if($department->phone)
                            <div>
                                <span class="text-slate-400 block font-semibold uppercase">Direct Telephone</span>
                                <span class="font-mono text-slate-800 font-bold mt-0.5 block">{{ $department->phone }}</span>
                            </div>
                        @endif
                        @if($department->email)
                            <div>
                                <span class="text-slate-400 block font-semibold uppercase">Official Email</span>
                                <span class="font-mono text-slate-800 mt-0.5 block">{{ $department->email }}</span>
                            </div>
                        @endif
                    </div>
                </x-card>

                <!-- Outpatient Scheduling Prompt -->
                <div class="p-6 rounded-2xl bg-hospital-50 border border-hospital-200/80">
                    <h4 class="font-heading font-bold text-hospital-900 text-sm mb-2">Need Help Scheduling?</h4>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Our outpatient triage desk will guide you to the right clinic and specialist for your symptoms.
                    </p>
                    <x-button href="{{ route('appointments.create', ['dept' => $department->id]) }}" variant="primary" size="sm" class="w-full">
                        Schedule Online
                    </x-button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

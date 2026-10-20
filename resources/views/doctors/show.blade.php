@extends('layouts.public')

@section('title', $doctor->name . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.doctors') => route('doctors.index'),
            $doctor->name => null
        ]" />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left Specialist Card -->
            <div class="space-y-6">
                <x-card padding="p-8" class="text-center shadow-card border-slate-200">
                    <div class="h-36 w-36 rounded-full overflow-hidden mx-auto mb-4 shadow-lg shadow-hospital-900/10 border-2 border-slate-200">
                        @if($doctor->photo)
                            <img src="{{ asset($doctor->photo) }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-tr from-hospital-700 to-hospital-500 text-white flex items-center justify-center font-bold text-4xl">
                                {{ substr($doctor->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h1 class="text-2xl font-heading font-extrabold text-navy-950 mb-1">
                        {{ $doctor->name }}
                    </h1>
                    <span class="text-xs font-bold text-hospital-700 block mb-2">{{ $doctor->qualification }}</span>
                    @if($doctor->title)
                        <span class="text-xs text-slate-500 block mb-4">{{ $doctor->title }}</span>
                    @endif

                    <div class="pt-6 border-t border-slate-100 text-left space-y-3 text-xs text-slate-600">
                        @if($doctor->department)
                            <div>
                                <span class="text-slate-400 font-semibold block uppercase">Department</span>
                                <a href="{{ route('departments.show', $doctor->department->slug) }}" class="text-hospital-700 font-bold hover:underline">
                                    {{ $doctor->department->name }}
                                </a>
                            </div>
                        @endif
                        <div>
                            <span class="text-slate-400 font-semibold block uppercase">Consultation Schedule</span>
                            <span class="text-slate-900 font-medium block mt-0.5">{{ $doctor->consultation_hours ?? 'Monday - Friday (08:30 - 14:00)' }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-button href="{{ route('appointments.create', ['doctor' => $doctor->id, 'dept' => $doctor->department_id]) }}" variant="primary" size="lg" class="w-full">
                            Book Consultation
                        </x-button>
                    </div>
                </x-card>
            </div>

            <!-- Right Profile Biography -->
            <div class="lg:col-span-2 space-y-8">
                <x-card padding="p-8 sm:p-10" class="shadow-card border-slate-200">
                    <h2 class="text-xl font-heading font-bold text-navy-950 mb-4 pb-2 border-b border-slate-100">
                        Specialist Biography & Clinical Focus
                    </h2>
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                        {!! nl2br(e($doctor->biography ?? ($doctor->name . ' is an experienced specialist consultant practicing at Ephamarcy Hospital.'))) !!}
                    </div>
                </x-card>

                <!-- Department Services -->
                @if($doctor->department && $doctor->department->services->isNotEmpty())
                    <div>
                        <h3 class="text-lg font-heading font-bold text-navy-950 mb-4">
                            Associated Departmental Services
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($doctor->department->services as $srv)
                                <x-service-card :service="$srv" />
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

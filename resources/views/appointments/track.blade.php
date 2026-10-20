@extends('layouts.public')

@section('title', 'Track Appointment Status — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-[75vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.appointment') => route('appointments.create'),
            'Track Status' => null
        ]" />

        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Patient Outpatient Portal
            </span>
            <h1 class="text-3xl font-heading font-extrabold text-navy-950 tracking-tight">
                Track Appointment Status
            </h1>
            <p class="mt-2 text-slate-600 text-sm leading-relaxed">
                Enter your hospital reference code (e.g. <span class="font-mono text-hospital-700 font-semibold">APX-20261012-0001</span>) to check triage and doctor schedule confirmation.
            </p>
        </div>

        <!-- Lookup Form -->
        <x-card padding="p-6 sm:p-8" class="shadow-card border-slate-200 mb-8">
            <form method="GET" action="{{ route('appointments.track') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <x-input 
                        name="ref" 
                        value="{{ $ref }}" 
                        placeholder="e.g. APX-20261012-0001" 
                        required 
                        class="uppercase font-mono tracking-wider font-semibold"
                    />
                </div>
                <x-button type="submit" variant="burgundy" class="shrink-0 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Check Status</span>
                </x-button>
            </form>
        </x-card>

        @if($ref && !$appointment)
            <x-card padding="p-8" class="text-center border-red-200 bg-red-50/40">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-lg font-heading font-bold text-slate-900 mb-1">Appointment Not Found</h3>
                <p class="text-xs text-slate-600 max-w-md mx-auto mb-4">
                    We could not locate any consultation request with reference code <strong class="font-mono text-slate-800">{{ $ref }}</strong>. Please check your reference code or contact our triage desk.
                </p>
                <div class="flex justify-center gap-3">
                    <a href="tel:+255742448965" class="text-xs font-bold text-emergency-600 hover:underline">Call Hospital Helpline</a>
                    <span class="text-slate-300">|</span>
                    <a href="{{ route('appointments.create') }}" class="text-xs font-bold text-hospital-700 hover:underline">Book New Consultation</a>
                </div>
            </x-card>
        @elseif($appointment)
            <!-- Appointment Details Card -->
            <x-card padding="p-6 sm:p-8" class="shadow-card border-slate-200 space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                    <div>
                        <span class="text-xs uppercase font-bold text-slate-400 block tracking-wider">Reference Code</span>
                        <span class="text-2xl font-black font-mono text-hospital-900">{{ $appointment->reference_number }}</span>
                    </div>
                    <div>
                        @if($appointment->status === 'confirmed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <span class="h-2 w-2 rounded-full bg-emerald-600"></span>
                                Confirmed & Scheduled
                            </span>
                        @elseif($appointment->status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                <span class="h-2 w-2 rounded-full bg-slate-600"></span>
                                Consultation Completed
                            </span>
                        @elseif($appointment->status === 'cancelled')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                <span class="h-2 w-2 rounded-full bg-red-600"></span>
                                Cancelled
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200">
                                <span class="h-2 w-2 rounded-full bg-amber-600 animate-pulse"></span>
                                Under Clinical Triage
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Schedule & Patient Information Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Patient Details</span>
                        <div class="font-bold text-slate-900">{{ $appointment->patient_name }}</div>
                        <div class="text-xs text-slate-600">{{ $appointment->patient_phone }}</div>
                        <div class="text-xs text-slate-500">{{ $appointment->patient_email }}</div>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Clinical Appointment</span>
                        <div class="font-bold text-hospital-800">{{ $appointment->department->name ?? 'General Outpatient' }}</div>
                        <div class="text-xs text-slate-600">Doctor: {{ $appointment->doctor->name ?? 'Triage Assigned Specialist' }}</div>
                        <div class="text-xs font-semibold text-slate-800">
                            Date: {{ $appointment->preferred_date->format('l, F d, Y') }} ({{ $appointment->preferred_time }})
                        </div>
                    </div>
                </div>

                @if($appointment->reason)
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 text-xs">
                        <span class="font-bold text-slate-600 block mb-1">Reason for Visit:</span>
                        <p class="text-slate-700 leading-relaxed">{{ $appointment->reason }}</p>
                    </div>
                @endif

                <!-- Triage Timeline History -->
                @if($appointment->statusHistories->isNotEmpty())
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Triage Activity Log</h4>
                        <div class="space-y-3">
                            @foreach($appointment->statusHistories as $history)
                                <div class="flex items-start gap-3 text-xs">
                                    <div class="h-2 w-2 rounded-full bg-hospital-600 mt-1.5 shrink-0"></div>
                                    <div>
                                        <div class="font-semibold text-slate-800">
                                            Status updated to <span class="capitalize text-hospital-700">{{ $history->to_status }}</span>
                                        </div>
                                        @if($history->note)
                                            <div class="text-slate-500 mt-0.5">{{ $history->note }}</div>
                                        @endif
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $history->created_at->format('M d, Y H:i') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Preparation Advice -->
                <div class="p-4 rounded-xl bg-hospital-50/60 border border-hospital-100 text-xs text-slate-700 space-y-1.5">
                    <strong class="font-bold text-hospital-900 block">Patient Checklist:</strong>
                    <p>&bull; Arrive 15 minutes prior to your allocated time slot.</p>
                    <p>&bull; Present your reference number <strong class="font-mono text-hospital-800">{{ $appointment->reference_number }}</strong> at reception.</p>
                    <p>&bull; Carry your national identification and medical insurance card if applicable.</p>
                </div>
            </x-card>
        @endif

    </div>
</div>
@endsection

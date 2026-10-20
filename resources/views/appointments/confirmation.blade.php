@extends('layouts.public')

@section('title', 'Appointment Confirmation — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-[70vh] flex items-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 w-full">
        <x-card padding="p-5 xs:p-8 sm:p-10" class="shadow-card border-slate-200 text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-5 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-950 mb-2">
                {{ __('hospital.appointment.success_title') }}
            </h1>
            <p class="text-sm text-slate-600 max-w-md mx-auto mb-6 leading-relaxed">
                Your consultation request has been submitted to our clinical triage team. Please preserve your reference code below.
            </p>

            <div class="p-4 xs:p-5 rounded-2xl bg-hospital-50/60 border border-hospital-200/80 inline-block w-full max-w-md mb-8">
                <span class="text-xs uppercase font-bold text-hospital-800 tracking-wider block mb-1">Appointment Reference Code</span>
                <span class="text-2xl xs:text-3xl font-black font-mono text-hospital-900 tracking-wider break-all">{{ $ref ?? 'APT-2026-CONFIRMED' }}</span>
                @if($appointment)
                    <div class="mt-4 pt-4 border-t border-hospital-200/60 text-xs text-slate-700 space-y-1.5 text-left">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Patient:</span>
                            <strong class="text-slate-900">{{ $appointment->patient_name }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Department:</span>
                            <span>{{ $appointment->department->name ?? 'General Outpatient' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Preferred Date:</span>
                            <span>{{ $appointment->preferred_date->format('M d, Y') }} ({{ $appointment->preferred_time }})</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Status:</span>
                            <x-badge color="emergency" size="xs">Pending Verification</x-badge>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Important Patient Notice -->
            <div class="text-left text-xs text-slate-600 bg-slate-50 p-4 rounded-xl border border-slate-200 mb-8 space-y-2">
                <strong class="text-slate-900 block font-heading text-sm">Next Steps:</strong>
                <p>&bull; Our triage officer will contact your phone number within 2 operating hours to confirm physician availability.</p>
                <p>&bull; Arrive 15 minutes prior to your time slot with your national ID and health insurance card (if applicable).</p>
                <p>&bull; For acute emergency symptoms, call <strong class="text-emergency-600">+255742448965</strong> immediately.</p>
            </div>

            <div class="flex flex-col xs:flex-row flex-wrap items-stretch xs:items-center justify-center gap-3">
                <x-button href="{{ route('appointments.track', ['ref' => $ref]) }}" variant="primary" class="w-full xs:w-auto text-center justify-center">
                    Track Status Online
                </x-button>
                <x-button href="{{ route('home') }}" variant="secondary" class="w-full xs:w-auto text-center justify-center">
                    Return to Homepage
                </x-button>
                <x-button href="{{ route('appointments.create') }}" variant="outline" class="w-full xs:w-auto text-center justify-center">
                    Book Another
                </x-button>
            </div>
        </x-card>
    </div>
</div>
@endsection

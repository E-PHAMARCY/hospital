@extends('layouts.public')

@section('title', __('hospital.appointment.title') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-gradient-to-b from-hospital-50/50 via-white to-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                <span class="h-2 w-2 rounded-full bg-hospital-600"></span>
                Outpatient Scheduling
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ __('hospital.appointment.title') }}
            </h1>
            <p class="mt-3 text-slate-600 text-sm sm:text-base leading-relaxed">
                {{ __('hospital.appointment.subtitle') }}
            </p>
            <p class="mt-2 text-xs text-slate-500">
                Already scheduled? <a href="{{ route('appointments.track') }}" class="font-bold text-hospital-700 hover:text-hospital-900 underline underline-offset-2">Track appointment status with reference code &rarr;</a>
            </p>
        </div>

        <!-- Acute Emergency Warning Alert -->
        <div class="mb-8">
            <x-alert type="warning" title="Notice for Medical Emergencies">
                If you or the patient is experiencing chest pain, severe shortness of breath, heavy trauma, or acute neurological symptoms, do not book an outpatient slot. Call our 24/7 Emergency Hotline immediately at <strong class="text-red-700 underline">+255742448965</strong> or proceed to the Emergency Casualty Wing.
            </x-alert>
        </div>

        @if(session('appointment_success'))
            @php $res = session('appointment_success'); @endphp
            <div class="mb-8">
                <x-card class="border-2 border-emerald-400 bg-emerald-50/40 p-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-heading font-bold text-slate-900 mb-2">
                        {{ __('hospital.appointment.success_title') }}
                    </h3>
                    <p class="text-slate-600 text-sm max-w-lg mx-auto mb-6">
                        {{ __('hospital.appointment.success_msg', ['reference' => $res['reference']]) }}
                    </p>
                    <div class="inline-block p-4 rounded-xl bg-white border border-emerald-200 shadow-2xs font-mono text-center">
                        <span class="text-xs text-slate-400 block uppercase tracking-wider">Your Reference Code</span>
                        <span class="text-2xl font-black text-hospital-800">{{ $res['reference'] }}</span>
                        <span class="text-xs text-slate-500 block mt-1">Requested for: {{ $res['date'] }}</span>
                    </div>
                    <div class="mt-8">
                        <x-button href="{{ route('home') }}" variant="secondary">
                            Return to Homepage
                        </x-button>
                    </div>
                </x-card>
            </div>
        @else
            <!-- Appointment Request Form Card -->
            <x-card padding="p-6 sm:p-10" class="shadow-card border-slate-200/90">
                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                    @csrf

                    <!-- Patient Info Section -->
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-base font-heading font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-hospital-100 text-hospital-800 text-xs font-bold">1</span>
                            Patient Information
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="sm:col-span-2">
                                <x-input 
                                    label="{{ __('hospital.appointment.full_name') }}" 
                                    name="patient_name" 
                                    placeholder="e.g. Juma Ally Rashidi" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input 
                                    label="{{ __('hospital.appointment.email_address') }}" 
                                    name="patient_email" 
                                    type="email" 
                                    placeholder="juma.rashidi@example.com" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input 
                                    label="{{ __('hospital.appointment.phone_number') }}" 
                                    name="patient_phone" 
                                    placeholder="+255 712 345 678" 
                                    required 
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Department & Doctor Selection -->
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-base font-heading font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-hospital-100 text-hospital-800 text-xs font-bold">2</span>
                            Department & Specialist Preference
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-select label="{{ __('hospital.appointment.select_department') }}" name="department_id">
                                    <option value="">-- Any Department / General Triage --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div>
                                <x-select label="{{ __('hospital.appointment.select_doctor') }}" name="doctor_id">
                                    <option value="">-- Any Available Specialist --</option>
                                    @foreach($doctors as $doc)
                                        <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                                            {{ $doc->name }} ({{ $doc->qualification }})
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                    </div>

                    <!-- Date & Time Slot Selection -->
                    <div class="border-b border-slate-100 pb-6">
                        <h2 class="text-base font-heading font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-hospital-100 text-hospital-800 text-xs font-bold">3</span>
                            Preferred Date & Time
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input 
                                    label="{{ __('hospital.appointment.preferred_date') }}" 
                                    name="preferred_date" 
                                    type="date" 
                                    min="{{ date('Y-m-d') }}"
                                    required 
                                />
                            </div>
                            <div>
                                <x-select label="{{ __('hospital.appointment.preferred_time') }}" name="preferred_time" required>
                                    <option value="{{ __('hospital.appointment.morning_slot') }}" {{ old('preferred_time') == __('hospital.appointment.morning_slot') ? 'selected' : '' }}>
                                        {{ __('hospital.appointment.morning_slot') }}
                                    </option>
                                    <option value="{{ __('hospital.appointment.afternoon_slot') }}" {{ old('preferred_time') == __('hospital.appointment.afternoon_slot') ? 'selected' : '' }}>
                                        {{ __('hospital.appointment.afternoon_slot') }}
                                    </option>
                                    <option value="{{ __('hospital.appointment.evening_slot') }}" {{ old('preferred_time') == __('hospital.appointment.evening_slot') ? 'selected' : '' }}>
                                        {{ __('hospital.appointment.evening_slot') }}
                                    </option>
                                </x-select>
                            </div>
                        </div>
                    </div>

                    <!-- Clinical Reason -->
                    <div>
                        <h2 class="text-base font-heading font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <span class="flex items-center justify-center h-6 w-6 rounded-full bg-hospital-100 text-hospital-800 text-xs font-bold">4</span>
                            Reason for Visit
                        </h2>
                        <x-textarea 
                            label="{{ __('hospital.appointment.reason') }}" 
                            name="reason" 
                            rows="4" 
                            placeholder="Brief description of symptoms, previous diagnosis, or routine consultation request..." 
                            required 
                        />
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <x-button type="submit" variant="burgundy" size="lg" class="w-full sm:w-auto">
                            {{ __('hospital.appointment.submit_btn') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        @endif
    </div>
</div>
@endsection

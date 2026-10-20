@extends('layouts.public')

@section('title', __('hospital.contact_section.title') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-gradient-to-b from-hospital-50/40 via-white to-slate-50">
    <div class="site-container">
        
        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                <span class="h-2 w-2 rounded-full bg-hospital-600"></span>
                Patient Desk & Support
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ __('hospital.contact_section.title') }}
            </h1>
            <p class="mt-3 text-slate-600 text-sm sm:text-base leading-relaxed">
                {{ __('hospital.contact_section.subtitle') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Info Card -->
            <div class="space-y-6">
                <!-- Location & Contact Details -->
                <x-card padding="p-6">
                    <h3 class="text-base font-heading font-bold text-slate-900 mb-4">
                        Hospital Headquarters
                    </h3>
                    <div class="space-y-4 text-sm text-slate-600">
                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-hospital-50 text-hospital-700 shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <strong class="text-slate-900 block">Physical Location:</strong>
                                <span>{{ __('hospital.location_address') }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-hospital-50 text-hospital-700 shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <strong class="text-slate-900 block">Direct Inquiries:</strong>
                                <span>+255742448965</span>
                                <span class="block text-xs text-slate-400">Available: Mon - Fri, 08:00 - 18:00</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="p-2 rounded-lg bg-hospital-50 text-hospital-700 shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <strong class="text-slate-900 block">Official Email:</strong>
                                <span class="font-mono text-xs">info@ephamarcyhosp.com</span>
                            </div>
                        </div>
                    </div>
                </x-card>

                <!-- 24/7 Emergency Box -->
                <div class="p-6 rounded-2xl bg-gradient-to-br from-red-600 to-emergency-700 text-white shadow-soft">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white mb-2">
                        <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                        {{ __('hospital.emergency.badge') }}
                    </span>
                    <h4 class="font-heading font-bold text-lg mb-1">Ambulance & Trauma Center</h4>
                    <p class="text-xs text-red-100 leading-relaxed mb-4">
                        For critical accidents, cardiac crises, or emergency obstetrics, call our dispatch desk directly.
                    </p>
                    <a href="tel:+255742448965" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white text-red-700 font-bold text-sm shadow-md hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z" />
                        </svg>
                        <span>+255742448965</span>
                    </a>
                </div>
            </div>

            <!-- Right Message Form -->
            <div class="lg:col-span-2">
                <x-card padding="p-6 sm:p-8" class="shadow-card border-slate-200">
                    <h3 class="text-lg font-heading font-bold text-slate-900 mb-6">
                        {{ __('hospital.contact_section.send_message') }}
                    </h3>

                    @if(session('contact_success'))
                        <div class="mb-6">
                            <x-alert type="success" title="Message Received">
                                {{ __('hospital.contact_section.success') }}
                            </x-alert>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input 
                                    label="{{ __('hospital.contact_section.your_name') }}" 
                                    name="name" 
                                    placeholder="e.g. Grace Makundi" 
                                    required 
                                />
                            </div>
                            <div>
                                <x-input 
                                    label="{{ __('hospital.contact_section.your_email') }}" 
                                    name="email" 
                                    type="email" 
                                    placeholder="grace@example.com" 
                                    required 
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <x-input 
                                    label="{{ __('hospital.contact_section.your_phone') }}" 
                                    name="phone" 
                                    placeholder="+255 754 000 000" 
                                />
                            </div>
                            <div>
                                <x-input 
                                    label="{{ __('hospital.contact_section.subject') }}" 
                                    name="subject" 
                                    placeholder="General Inquiry, Insurance, or Feedback" 
                                    required 
                                />
                            </div>
                        </div>

                        <div>
                            <x-textarea 
                                label="{{ __('hospital.contact_section.message') }}" 
                                name="message" 
                                rows="5" 
                                placeholder="Write your message here..." 
                                required 
                            />
                        </div>

                        <div>
                            <x-button type="submit" variant="burgundy" size="lg" class="w-full sm:w-auto">
                                {{ __('hospital.contact_section.submit') }}
                            </x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
</div>
@endsection

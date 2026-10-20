@extends('layouts.public')

@section('title', ($page->title ?? 'Patient Information') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <!-- Breadcrumbs -->
        <x-breadcrumbs :items="[
            'Patient Guides' => route('patients'),
            ($page->title ?? 'Information') => null
        ]" />

        <!-- Header -->
        <div class="mb-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-navy-100 text-navy-800 border border-navy-200 mb-3">
                Patient & Visitor Services
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ $page->title ?? 'Patient & Visitor Information' }}
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                {{ $page->excerpt ?? 'Comprehensive guidelines on admissions, visiting hours, insurance, and medical referrals.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation Tabs -->
            <div class="lg:col-span-1 bg-white p-2.5 sm:p-3 rounded-2xl border border-slate-200/80 shadow-soft self-start lg:sticky lg:top-24">
                <span class="px-2 py-1 text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Patient Guides</span>
                <div class="flex flex-wrap lg:flex-col gap-1.5">
                    <a href="{{ route('patients.section', 'visiting-hours') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'visiting-hours' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Visiting Hours
                    </a>
                    <a href="{{ route('patients.section', 'admission') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ empty($section) || $section === 'admission' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Admission Guidelines
                    </a>
                    <a href="{{ route('patients.section', 'discharge') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'discharge' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Discharge Protocols
                    </a>
                    <a href="{{ route('patients.section', 'insurance') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'insurance' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Insurance Partners
                    </a>
                    <a href="{{ route('patients.section', 'billing') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'billing' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Billing & Payments
                    </a>
                    <a href="{{ route('patients.section', 'referrals') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'referrals' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Patient Referrals
                    </a>
                    <a href="{{ route('patients.section', 'faq') }}" class="px-3 py-2 rounded-lg text-xs sm:text-sm font-medium transition whitespace-nowrap {{ $section === 'faq' ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-slate-50 lg:bg-transparent text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        Frequently Asked Questions
                    </a>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Page Body Card -->
                <x-card padding="p-8 sm:p-10" class="shadow-card border-slate-200">
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                        {!! nl2br(e($page->content ?? 'Patient information is being updated.')) !!}
                    </div>

                    <!-- FAQs Section (if on FAQ tab) -->
                    @if($section === 'faq' && isset($faqs))
                        <div class="mt-8 pt-8 border-t border-slate-200">
                            @foreach($faqs as $category => $items)
                                <div class="mb-8 last:mb-0">
                                    <h3 class="text-base font-heading font-bold text-navy-950 mb-4 flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-hospital-600"></span>
                                        {{ $category }}
                                    </h3>
                                    <div class="space-y-3">
                                        @foreach($items as $faq)
                                            <div class="rounded-xl border border-slate-200 bg-slate-50/70 p-4" x-data="{ expanded: false }">
                                                <button 
                                                    type="button" 
                                                    @click="expanded = !expanded" 
                                                    class="w-full text-left font-heading font-semibold text-sm text-slate-900 flex items-center justify-between gap-4 focus:outline-none"
                                                >
                                                    <span>{{ $faq->question }}</span>
                                                    <span class="text-hospital-700 shrink-0 font-bold text-lg" x-text="expanded ? '−' : '+'"></span>
                                                </button>
                                                <div x-show="expanded" x-cloak class="mt-3 text-xs text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                                                    {{ $faq->answer }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-card>

                <!-- 24/7 Helpline Strip -->
                <div class="bg-navy-950 rounded-2xl p-6 text-white flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="p-2.5 rounded-xl bg-red-600 text-white shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z" />
                            </svg>
                        </span>
                        <div>
                            <strong class="font-bold text-sm block">Have Urgent Questions About an Admission?</strong>
                            <span class="text-xs text-slate-400">Our Admissions & Casualty helpdesk is active 24/7.</span>
                        </div>
                    </div>
                    <a href="tel:+255742448965" class="px-4 py-2 rounded-xl bg-emergency-600 hover:bg-emergency-700 text-white font-bold text-xs tracking-wider uppercase shrink-0 transition">
                        +255742448965
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

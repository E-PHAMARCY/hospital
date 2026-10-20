@extends('layouts.public')

@section('title', $career->title . ' — Careers — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            'Careers' => route('careers.index'),
            $career->title => null
        ]" />

        <x-card padding="p-5 xs:p-8 sm:p-12" class="shadow-card border-slate-200 mt-6">
            <div class="flex items-center gap-3 text-xs mb-4 flex-wrap">
                <span class="px-2.5 py-0.5 rounded font-bold bg-hospital-50 text-hospital-800 border border-hospital-100">
                    {{ $career->employment_type }}
                </span>
                @if($career->department)
                    <span class="text-slate-500">&bull; {{ $career->department->name }}</span>
                @endif
                <span class="text-slate-400">&bull; {{ $career->location }}</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-950 mb-4 leading-snug">
                {{ $career->title }}
            </h1>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 mb-8 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-600 gap-2">
                <div>
                    <span class="text-slate-400 block font-semibold">Application Deadline</span>
                    <strong class="font-mono text-emergency-600 text-sm">{{ $career->deadline->format('F d, Y') }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Application Channel</span>
                    <span class="font-mono font-bold text-slate-800 break-all">{{ $career->application_email ?? 'careers@ephamarcyhosp.com' }}</span>
                </div>
            </div>

            <div class="space-y-6 text-sm text-slate-700 leading-relaxed mb-10">
                <div>
                    <h3 class="font-heading font-bold text-base text-navy-950 mb-2">Role Overview</h3>
                    <p>{!! nl2br(e($career->description)) !!}</p>
                </div>

                @if($career->requirements)
                    <div>
                        <h3 class="font-heading font-bold text-base text-navy-950 mb-2">Qualifications & Experience</h3>
                        <p>{!! nl2br(e($career->requirements)) !!}</p>
                    </div>
                @endif
            </div>

            <!-- How to Apply Box -->
            <div class="p-5 xs:p-6 rounded-2xl bg-hospital-50/70 border border-hospital-200/80 mb-8">
                <h4 class="font-heading font-bold text-hospital-900 text-sm mb-2">Application Instructions:</h4>
                <p class="text-xs text-slate-700 leading-relaxed">
                    Qualified candidates are invited to submit their updated Curriculum Vitae, certified copies of academic certificates, and practicing licenses to <strong class="font-mono text-hospital-800">{{ $career->application_email ?? 'careers@ephamarcyhosp.com' }}</strong> citing the job title in the subject line before the deadline.
                </p>
            </div>

            <div class="flex flex-col xs:flex-row items-stretch xs:items-center gap-3 xs:gap-4 pt-4 border-t border-slate-100">
                <x-button href="mailto:{{ $career->application_email ?? 'careers@ephamarcyhosp.com' }}?subject=Application for {{ urlencode($career->title) }}" variant="primary" size="md" class="w-full xs:w-auto text-center justify-center">
                    Apply via Email
                </x-button>
                <x-button href="{{ route('careers.index') }}" variant="outline" size="md" class="w-full xs:w-auto text-center justify-center">
                    Back to All Vacancies
                </x-button>
            </div>
        </x-card>

    </div>
</div>
@endsection

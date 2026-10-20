@extends('layouts.public')

@section('title', 'Careers & Job Opportunities — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            'Careers' => null
        ]" />

        <div class="max-w-3xl mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Join Our Medical Team
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                Careers & Vacancies
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                Explore rewarding clinical and operational healthcare opportunities at Ephamarcy Hospital.
            </p>
        </div>

        @if($careers->isEmpty())
            <x-empty-state title="No active job vacancies" description="There are currently no open vacancies. Please check back later or send an open inquiry." />
        @else
            <div class="space-y-5">
                @foreach($careers as $job)
                    <x-card padding="p-6 sm:p-8" class="border-slate-200/90 shadow-soft flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-hospital-400 transition">
                        <div>
                            <div class="flex items-center gap-2 mb-2 flex-wrap">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-hospital-50 text-hospital-800 border border-hospital-100">
                                    {{ $job->employment_type }}
                                </span>
                                @if($job->department)
                                    <span class="text-xs text-slate-500">&bull; {{ $job->department->name }}</span>
                                @endif
                                <span class="text-xs text-slate-400">&bull; {{ $job->location }}</span>
                            </div>
                            <h2 class="text-xl font-heading font-bold text-navy-950 mb-2">
                                <a href="{{ route('careers.show', $job->slug) }}" class="hover:text-hospital-700 transition">
                                    {{ $job->title }}
                                </a>
                            </h2>
                            <p class="text-xs text-slate-600 line-clamp-2 max-w-2xl leading-relaxed">
                                {{ $job->description }}
                            </p>
                        </div>

                        <div class="shrink-0 flex flex-col md:items-end justify-between gap-3">
                            <div class="text-xs text-slate-500">
                                <span>Deadline:</span>
                                <strong class="text-emergency-600 block sm:inline font-mono">{{ $job->deadline->format('M d, Y') }}</strong>
                            </div>
                            <x-button href="{{ route('careers.show', $job->slug) }}" variant="burgundy" size="sm" class="w-full sm:w-auto text-center">
                                View Vacancy & Apply
                            </x-button>
                        </div>
                    </x-card>
                @endforeach
            </div>

            @if($careers->hasPages())
                <div class="mt-10">
                    {{ $careers->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

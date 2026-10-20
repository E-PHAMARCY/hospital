@extends('layouts.public')

@section('title', 'Institutional Tenders & Procurement — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            'Tenders & Procurement' => null
        ]" />

        <div class="max-w-3xl mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Procurement & Supply Chain
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                Tenders & Invitations to Bid
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                Official notices for supply of biomedical technology, hospital consumables, maintenance, and civil works.
            </p>
        </div>

        @if($tenders->isEmpty())
            <x-empty-state title="No active tenders" description="There are currently no active tenders advertised." />
        @else
            <div class="space-y-5">
                @foreach($tenders as $tender)
                    <x-card padding="p-6 sm:p-8" class="border-slate-200/90 shadow-soft flex flex-col md:flex-row md:items-center justify-between gap-6 hover:border-hospital-400 transition">
                        <div>
                            <div class="flex items-center gap-3 mb-2 flex-wrap">
                                <span class="font-mono text-xs font-bold text-hospital-800 bg-hospital-50 px-2.5 py-0.5 rounded border border-hospital-100">
                                    {{ $tender->tender_number }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    Published: {{ $tender->publication_date->format('M d, Y') }}
                                </span>
                                @if($tender->is_open)
                                    <x-badge color="emerald" size="xs">Open for Bidding</x-badge>
                                @else
                                    <x-badge color="slate" size="xs">Closed</x-badge>
                                @endif
                            </div>

                            <h2 class="text-xl font-heading font-bold text-navy-950 mb-2">
                                <a href="{{ route('tenders.show', $tender->slug) }}" class="hover:text-hospital-700 transition">
                                    {{ $tender->title }}
                                </a>
                            </h2>

                            <p class="text-xs text-slate-600 line-clamp-2 max-w-2xl leading-relaxed">
                                {{ $tender->description }}
                            </p>
                        </div>

                        <div class="shrink-0 flex flex-col md:items-end justify-between gap-3">
                            <div class="text-xs text-slate-500">
                                <span>Submission Deadline:</span>
                                <strong class="text-emergency-600 block sm:inline font-mono">{{ $tender->submission_deadline->format('M d, Y H:i') }}</strong>
                            </div>
                            <x-button href="{{ route('tenders.show', $tender->slug) }}" variant="outline-primary" size="sm" class="w-full sm:w-auto text-center">
                                View Bid Details
                            </x-button>
                        </div>
                    </x-card>
                @endforeach
            </div>

            @if($tenders->hasPages())
                <div class="mt-10">
                    {{ $tenders->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

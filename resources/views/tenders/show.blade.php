@extends('layouts.public')

@section('title', $tender->title . ' — Tenders — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            'Tenders & Procurement' => route('tenders.index'),
            $tender->title => null
        ]" />

        <x-card padding="p-5 xs:p-8 sm:p-12" class="shadow-card border-slate-200 mt-6">
            <div class="flex items-center gap-3 text-xs mb-4 flex-wrap">
                <span class="font-mono font-bold text-hospital-800 bg-hospital-50 px-3 py-1 rounded border border-hospital-100">
                    {{ $tender->tender_number }}
                </span>
                @if($tender->is_open)
                    <x-badge color="emerald" size="sm">Active Tender</x-badge>
                @else
                    <x-badge color="slate" size="sm">Closed</x-badge>
                @endif
                <span class="text-slate-400">&bull; Published: {{ $tender->publication_date->format('F d, Y') }}</span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-950 mb-6 leading-snug">
                {{ $tender->title }}
            </h1>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 mb-8 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-slate-700 gap-2">
                <div>
                    <span class="text-slate-400 block font-semibold">Submission Deadline</span>
                    <strong class="font-mono text-emergency-600 text-sm">{{ $tender->submission_deadline->format('F d, Y @ H:i') }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 block font-semibold">Tender Entity</span>
                    <span class="font-semibold text-slate-800">Ephamarcy Hospital Procurement Board</span>
                </div>
            </div>

            <div class="prose max-w-none text-slate-700 leading-relaxed text-sm space-y-4 mb-10">
                <h3 class="font-heading font-bold text-base text-navy-950 mb-2">Scope of Bid / Tender Description</h3>
                <p>{!! nl2br(e($tender->description)) !!}</p>
            </div>

            <!-- Submission instructions -->
            <div class="p-5 xs:p-6 rounded-2xl bg-hospital-50/70 border border-hospital-200/80 mb-8 text-xs text-slate-700 leading-relaxed">
                <h4 class="font-heading font-bold text-hospital-900 text-sm mb-2">Submission Instructions:</h4>
                <p>
                    Sealed bids addressed to the Secretary of the Tender Board must be delivered to the Procurement Management Unit (PMU), Wing B, Ground Floor, Ephamarcy Hospital, on or before the stated submission deadline. Late bids will not be accepted.
                </p>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                <x-button href="{{ route('tenders.index') }}" variant="outline" size="md" class="w-full xs:w-auto text-center justify-center">
                    Back to All Tenders
                </x-button>
            </div>
        </x-card>

    </div>
</div>
@endsection

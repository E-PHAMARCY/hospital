@extends('layouts.public')

@section('title', $resource->title . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-[70vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.resources') => route('resources.index'),
            $resource->title => null
        ]" />

        <x-card padding="p-5 xs:p-8 sm:p-10" class="shadow-card border-slate-200 mt-6 text-center">
            <div class="h-16 w-16 rounded-2xl bg-hospital-50 text-hospital-700 flex items-center justify-center mx-auto mb-4 border border-hospital-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>

            <span class="text-xs uppercase font-bold text-hospital-700 tracking-wider block mb-2">{{ $resource->category }}</span>
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-950 mb-3">
                {{ $resource->title }}
            </h1>
            <p class="text-sm text-slate-600 max-w-lg mx-auto leading-relaxed mb-6">
                {{ $resource->description }}
            </p>

            <div class="flex flex-wrap items-center justify-center gap-2 xs:gap-4 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-500 font-mono mb-8 max-w-full">
                <span>Format: {{ $resource->file_type ?? 'PDF' }}</span>
                <span>&bull;</span>
                <span>Approx. Size: {{ $resource->file_size ?? '2.4 MB' }}</span>
                <span>&bull;</span>
                <span>Downloads: {{ $resource->download_count }}</span>
            </div>

            <div>
                <x-button href="{{ route('resources.download', $resource->id) }}" variant="primary" size="lg" class="w-full xs:w-auto text-center justify-center">
                    Download Official Document
                </x-button>
            </div>
        </x-card>

    </div>
</div>
@endsection

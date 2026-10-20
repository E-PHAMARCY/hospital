@extends('layouts.public')

@section('title', $page->title . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-[70vh]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            $page->title => null
        ]" />

        <div class="mb-8">
            <h1 class="text-2xl xs:text-3xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ $page->title }}
            </h1>
            <p class="mt-2 text-xs xs:text-sm text-slate-500">
                Last reviewed: {{ $page->updated_at->format('F d, Y') }} &bull; Institutional Compliance Desk
            </p>
        </div>

        <x-card padding="p-5 xs:p-8 sm:p-10" class="shadow-card border-slate-200">
            <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                {!! nl2br(e($page->content)) !!}
            </div>
        </x-card>
    </div>
</div>
@endsection

@extends('layouts.public')

@section('title', __('hospital.nav.departments') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.departments') => null
        ]" />

        <div class="max-w-3xl mb-12">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                Centres of Excellence
            </span>
            <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                {{ __('hospital.nav.departments') }}
            </h1>
            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                Specialized clinical departments offering outpatient clinics, acute admissions, diagnostics, and multi-disciplinary specialty surgery.
            </p>
        </div>

        @if($departments->isEmpty())
            <x-empty-state title="No departments found" description="No clinical departments are currently active." />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($departments as $dept)
                    <x-department-card :department="$dept" />
                @endforeach
            </div>

            @if($departments->hasPages())
                <div class="mt-10">
                    {{ $departments->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

@extends('layouts.public')

@section('title', __('hospital.nav.doctors') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.doctors') => null
        ]" />

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                    Medical Faculty
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                    {{ __('hospital.nav.doctors') }}
                </h1>
                <p class="mt-3 text-slate-600 text-base leading-relaxed">
                    Meet our dedicated clinical consultants, surgeons, and specialists committed to high-standard evidence-based medicine.
                </p>
            </div>

            <!-- Filter by Department -->
            @if($departments->isNotEmpty())
                <div class="shrink-0">
                    <form method="GET" action="{{ route('doctors.index') }}" class="flex items-center gap-2">
                        <select name="department" onchange="this.form.submit()" class="text-xs rounded-xl border-slate-300 py-2.5 px-3 font-medium text-slate-700 bg-white shadow-2xs focus:border-hospital-500 focus:ring-hospital-500">
                            <option value="">All Specialty Divisions</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->id }}" {{ $deptId == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($deptId)
                            <a href="{{ route('doctors.index') }}" class="text-xs text-hospital-700 font-semibold hover:underline">Reset</a>
                        @endif
                    </form>
                </div>
            @endif
        </div>

        @if($doctors->isEmpty())
            <x-empty-state title="No doctors found" description="No specialists match your selected filter." />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($doctors as $doc)
                
                    <x-doctor-card :doctor="$doc" />
                @endforeach
            </div>

            @if($doctors->hasPages())
                <div class="mt-10">
                    {{ $doctors->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

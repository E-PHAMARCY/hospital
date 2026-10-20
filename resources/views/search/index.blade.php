@extends('layouts.public')

@section('title', 'Search Results — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            'Search Results' => null
        ]" />

        <!-- Search Bar Header -->
        <div class="mb-10 mt-4">
            <h1 class="text-2xl sm:text-3xl font-heading font-extrabold text-navy-950 mb-4">
                Hospital Information Search
            </h1>
            <form action="{{ route('search') }}" method="GET" class="relative max-w-2xl">
                <input 
                    type="search" 
                    name="q" 
                    value="{{ $query }}" 
                    placeholder="Search clinical departments, doctors, services, news, guides..." 
                    class="w-full rounded-2xl border-slate-300 py-3.5 pl-4 sm:pl-5 pr-24 sm:pr-28 text-slate-900 shadow-soft focus:border-hospital-600 focus:ring-2 focus:ring-hospital-600/20 text-xs sm:text-sm"
                    required
                >
                <div class="absolute right-1.5 sm:right-2 top-2">
                    <x-button type="submit" variant="burgundy" size="sm" class="py-2 sm:py-2.5 px-3 sm:px-4">
                        Search
                    </x-button>
                </div>
            </form>
        </div>

        @if(!empty($query))
            <div class="mb-6 flex items-center justify-between text-xs text-slate-500 pb-3 border-b border-slate-200">
                <span>Showing {{ $total }} results for "<strong class="text-slate-900">{{ $query }}</strong>"</span>
            </div>
        @endif

        @if($results->isEmpty())
            <x-empty-state 
                title="No results found" 
                description="We couldn't find any published records matching your search query. Try keywords like 'Cardiology', 'Emergency', 'Admission', or specialist doctor names." 
                actionText="Explore Departments" 
                actionUrl="{{ route('departments.index') }}" 
            />
        @else
            <div class="space-y-4">
                @foreach($results as $res)
                    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-2xs hover:shadow-soft hover:border-hospital-300 transition">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-hospital-50 text-hospital-800 border border-hospital-100">
                                {{ $res['type'] }}
                            </span>
                        </div>
                        <h3 class="text-base font-heading font-bold text-navy-950 hover:text-hospital-700 transition">
                            <a href="{{ $res['url'] }}">
                                {{ $res['title'] }}
                            </a>
                        </h3>
                        @if(!empty($res['snippet']))
                            <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                                {{ $res['snippet'] }}
                            </p>
                        @endif
                        <div class="mt-3">
                            <a href="{{ $res['url'] }}" class="text-xs font-bold text-hospital-700 hover:underline">
                                View {{ $res['type'] }} &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection

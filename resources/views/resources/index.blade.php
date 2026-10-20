@extends('layouts.public')

@section('title', __('hospital.nav.resources') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.resources') => null
        ]" />

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-hospital-100 text-hospital-800 border border-hospital-200 mb-3">
                    Institutional Publications & Documents
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                    {{ __('hospital.nav.resources') }}
                </h1>
                <p class="mt-3 text-slate-600 text-base leading-relaxed">
                    Download clinical admission guides, patient rights charters, quality performance reports, and pre-surgery checklists.
                </p>
            </div>

            <!-- Category Filter -->
            @if($categories->isNotEmpty())
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('resources.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($category) ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        All Documents
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('resources.index', ['category' => $cat]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $category === $cat ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($resources->isEmpty())
            <x-empty-state title="No resources found" description="No downloadable documents match your filter." />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($resources as $res)
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-soft hover:shadow-card hover:border-hospital-400 transition flex flex-col justify-between">
                        <div>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-hospital-100 text-hospital-800">
                                    {{ $res->file_type ?? 'PDF' }}
                                </span>
                                <span class="text-xs text-slate-400 font-mono">{{ $res->file_size ?? '1.5 MB' }}</span>
                            </div>
                            <h3 class="font-heading font-bold text-base text-slate-900 mb-2 leading-snug">
                                <a href="{{ route('resources.show', $res->id) }}" class="hover:text-hospital-700 transition">
                                    {{ $res->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ $res->description }}
                            </p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">{{ $res->category }}</span>
                            <a href="{{ route('resources.download', $res->id) }}" class="text-xs font-bold text-hospital-700 hover:text-hospital-900 transition flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($resources->hasPages())
                <div class="mt-10">
                    {{ $resources->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

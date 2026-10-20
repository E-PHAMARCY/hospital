@extends('layouts.public')

@section('title', 'Health Education & Wellness — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            'Health Education' => null
        ]" />

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mb-3">
                    Preventative Medicine & Wellness
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                    Health Education & Guidance
                </h1>
                <p class="mt-3 text-slate-600 text-base leading-relaxed">
                    Evidence-based articles reviewed by our clinical specialists covering disease prevention, maternal care, and wellness.
                </p>
            </div>

            <!-- Categories Filter -->
            @if($categories->isNotEmpty())
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('health-education.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($category) ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        All Topics
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('health-education.index', ['category' => $cat]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $category === $cat ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($articles->isEmpty())
            <x-empty-state title="No health articles found" description="No educational articles are available for this topic." />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $art)
                    <x-card :hover="true" padding="p-6" class="flex flex-col justify-between h-full border-slate-200/90 group">
                        <div>
                            <div class="flex items-center justify-between text-xs text-slate-400 mb-3">
                                <span class="font-semibold text-hospital-700 bg-hospital-50 px-2 py-0.5 rounded">{{ $art->category }}</span>
                                <span>{{ $art->published_at ? $art->published_at->format('M d, Y') : 'Recent' }}</span>
                            </div>
                            <h3 class="font-heading font-bold text-lg text-navy-950 mb-2 leading-snug group-hover:text-hospital-700 transition">
                                <a href="{{ route('health-education.show', $art->slug) }}">
                                    {{ $art->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed mb-4">
                                {{ $art->excerpt }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 text-[11px]">By {{ $art->author_name }}</span>
                            <a href="{{ route('health-education.show', $art->slug) }}" class="font-bold text-hospital-700 hover:text-hospital-900 transition flex items-center gap-1">
                                <span>Read Article</span> &rarr;
                            </a>
                        </div>
                    </x-card>
                @endforeach
            </div>

            @if($articles->hasPages())
                <div class="mt-10">
                    {{ $articles->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

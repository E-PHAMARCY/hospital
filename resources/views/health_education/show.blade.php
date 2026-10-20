@extends('layouts.public')

@section('title', $article->title . ' — Health Education — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            'Health Education' => route('health-education.index'),
            $article->title => null
        ]" />

        <article class="bg-white rounded-3xl p-5 xs:p-8 sm:p-12 shadow-soft border border-slate-200 mt-6">
            <div class="flex items-center gap-2 xs:gap-3 text-xs text-slate-500 mb-4 flex-wrap">
                <span class="px-2.5 py-1 rounded-full font-bold bg-hospital-50 text-hospital-800 border border-hospital-100">
                    {{ $article->category }}
                </span>
                <span>&bull;</span>
                <span>By {{ $article->author_name }}</span>
                <span>&bull;</span>
                <span>{{ $article->published_at ? $article->published_at->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $article->views_count }} Reads</span>
            </div>

            <h1 class="text-2xl xs:text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            @if($article->excerpt)
                <p class="text-base text-slate-600 font-medium leading-relaxed mb-8 p-4 rounded-xl bg-slate-50 border-l-4 border-hospital-600">
                    {{ $article->excerpt }}
                </p>
            @endif

            <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                {!! nl2br(e($article->content)) !!}
            </div>

            <!-- Mandatory Medical Disclaimer Box (Requirement Section 6) -->
            <div class="mt-10 p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 text-xs text-amber-900 leading-relaxed">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <strong class="font-bold text-amber-950 block mb-1">Official Medical Disclaimer:</strong>
                        <span>{{ $article->disclaimer }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-3 text-xs text-slate-500">
                <a href="{{ route('health-education.index') }}" class="font-bold text-hospital-700 hover:underline">
                    &larr; Back to Health Education Topics
                </a>
                <span>Reviewed by Ephamarcy Hospital Clinical Review Board</span>
            </div>
        </article>

        <!-- Related Topics -->
        @if($related->isNotEmpty())
            <div class="mt-14">
                <h3 class="text-xl font-heading font-bold text-navy-950 mb-6">Related Health Guidance</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        <x-card :hover="true" padding="p-5">
                            <span class="text-[10px] font-bold text-hospital-700 bg-hospital-50 px-2 py-0.5 rounded">{{ $rel->category }}</span>
                            <h4 class="font-heading font-bold text-sm text-slate-900 mt-2 mb-2 line-clamp-2">
                                <a href="{{ route('health-education.show', $rel->slug) }}" class="hover:text-hospital-700">
                                    {{ $rel->title }}
                                </a>
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $rel->excerpt }}</p>
                        </x-card>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

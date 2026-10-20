@extends('layouts.public')

@section('title', $article->title . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.news') => route('news.index'),
            $article->title => null
        ]" />

        <article class="bg-white rounded-3xl p-5 xs:p-8 sm:p-12 shadow-soft border border-slate-200 mt-6">
            <div class="flex flex-wrap items-center gap-2 xs:gap-3 text-xs text-slate-500 mb-4">
                <span class="px-2.5 py-1 rounded-full font-bold bg-hospital-50 text-hospital-800 border border-hospital-100">
                    {{ $article->category }}
                </span>
                <span>&bull;</span>
                <span>{{ $article->published_at ? $article->published_at->format('F d, Y') : 'Recent' }}</span>
                <span>&bull;</span>
                <span>{{ $article->views_count }} Views</span>
            </div>

            <h1 class="text-2xl xs:text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            @if($article->featured_image)
                <div class="h-64 sm:h-80 lg:h-96 w-full rounded-2xl overflow-hidden mb-8 shadow-sm">
                    <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if($article->excerpt)
                <p class="text-base text-slate-600 font-medium leading-relaxed mb-8 p-4 rounded-xl bg-slate-50 border-l-4 border-hospital-600">
                    {{ $article->excerpt }}
                </p>
            @endif

            <div class="prose max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4">
                {!! nl2br(e($article->content)) !!}
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col xs:flex-row items-start xs:items-center justify-between gap-3 text-xs text-slate-500">
                <a href="{{ route('news.index') }}" class="font-bold text-hospital-700 hover:underline">
                    &larr; Back to All News
                </a>
                <span>Published by Ephamarcy Hospital Editorial Desk</span>
            </div>
        </article>

        <!-- Related News -->
        @if($related->isNotEmpty())
            <div class="mt-14">
                <h3 class="text-xl font-heading font-bold text-navy-950 mb-6">Related News & Health Updates</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        <x-news-card :item="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

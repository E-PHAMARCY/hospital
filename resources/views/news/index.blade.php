@extends('layouts.public')

@section('title', __('hospital.nav.news') . ' — ' . __('hospital.hospital_name'))

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="site-container">
        
        <x-breadcrumbs :items="[
            __('hospital.nav.news') => null
        ]" />

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200 mb-3">
                    Institutional News & Health Insights
                </span>
                <h1 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                    {{ __('hospital.nav.news') }}
                </h1>
                <p class="mt-3 text-slate-600 text-base leading-relaxed">
                    Official hospital announcements, public health campaigns, clinical breakthroughs, and wellness tips.
                </p>
            </div>

            <!-- Categories Filter -->
            @if($categories->isNotEmpty())
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('news.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($category) ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                        All News
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('news.index', ['category' => $cat]) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition {{ $category === $cat ? 'bg-hospital-600 text-white shadow-2xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
                            {{ $cat }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($news->isEmpty())
            <x-empty-state title="No articles published" description="No news articles are available for this category." />
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($news as $item)
                    <x-news-card :item="$item" />
                @endforeach
            </div>

            @if($news->hasPages())
                <div class="mt-10">
                    {{ $news->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection

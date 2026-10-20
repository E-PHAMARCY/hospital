@props(['items' => []])

<nav aria-label="Breadcrumb" class="py-3 text-xs text-slate-500 font-medium">
    <ol class="flex items-center flex-wrap gap-2">
        <li class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-hospital-700 transition flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ __('hospital.nav.home') }}</span>
            </a>
        </li>

        @foreach($items as $label => $url)
            <li class="flex items-center gap-2">
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                @if($url && !$loop->last)
                    <a href="{{ $url }}" class="hover:text-hospital-700 transition truncate max-w-[130px] xs:max-w-xs">{{ $label }}</a>
                @else
                    <span class="text-slate-800 font-semibold truncate max-w-[150px] xs:max-w-xs sm:max-w-md">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

@props([
    'title' => 'No records found',
    'description' => 'There are currently no items matching your criteria in this section.',
    'actionText' => null,
    'actionUrl' => null,
])

<div class="p-12 text-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 my-6">
    <div class="h-12 w-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
    </div>
    <h3 class="text-base font-heading font-semibold text-slate-800">{{ $title }}</h3>
    <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 leading-relaxed">{{ $description }}</p>
    @if($actionText && $actionUrl)
        <div class="mt-4">
            <x-button href="{{ $actionUrl }}" variant="primary" size="sm">
                {{ $actionText }}
            </x-button>
        </div>
    @endif
</div>

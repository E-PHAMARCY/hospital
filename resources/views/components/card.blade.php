@props([
    'hover' => false,
    'border' => true,
    'padding' => 'p-6',
])

@php
$classes = "bg-white rounded-2xl shadow-soft overflow-hidden transition-all duration-200";

if ($border) {
    $classes .= " border border-slate-200/80";
}

if ($hover) {
    $classes .= " hover:shadow-card hover:-translate-y-1 hover:border-hospital-300";
}
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if(isset($header))
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60 font-medium text-slate-800">
            {{ $header }}
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $footer }}
        </div>
    @endif
</div>

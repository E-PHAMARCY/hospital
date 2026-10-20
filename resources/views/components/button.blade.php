@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'icon' => null,
])

@php
$baseClasses = "inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed rounded-lg shadow-sm";

$sizeClasses = [
    'sm' => 'px-3 py-1.5 text-xs gap-1.5',
    'md' => 'px-4 py-2.5 text-sm gap-2',
    'lg' => 'px-6 py-3.5 text-base gap-2.5 font-semibold',
][$size] ?? 'px-4 py-2.5 text-sm gap-2';

$variantClasses = [
    'primary' => 'bg-hospital-700 hover:bg-hospital-800 text-white focus:ring-hospital-500 shadow-hospital-900/10',
    'burgundy' => 'bg-hospital-600 hover:bg-hospital-700 text-white focus:ring-red-700 shadow-sm uppercase tracking-wide font-bold',
    'secondary' => 'bg-navy-800 hover:bg-navy-900 text-white focus:ring-navy-600 shadow-navy-900/10',
    'emergency' => 'bg-emergency-600 hover:bg-emergency-700 text-white focus:ring-emergency-500 shadow-red-500/20 animate-pulse-subtle',
    'outline' => 'border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 focus:ring-hospital-500',
    'outline-primary' => 'border-2 border-hospital-700 text-hospital-700 hover:bg-hospital-50 focus:ring-hospital-500 font-semibold',
    'ghost' => 'text-slate-600 hover:text-slate-900 hover:bg-slate-100 shadow-none focus:ring-slate-400',
][$variant] ?? 'bg-hospital-700 hover:bg-hospital-800 text-white focus:ring-hospital-500';

$classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </button>
@endif

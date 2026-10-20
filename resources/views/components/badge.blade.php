@props([
    'color' => 'hospital',
    'size' => 'sm',
    'pulse' => false,
])

@php
$colorClasses = [
    'hospital' => 'bg-hospital-50 text-hospital-800 border-hospital-200',
    'navy' => 'bg-navy-50 text-navy-800 border-navy-200',
    'emergency' => 'bg-emergency-50 text-emergency-600 border-red-200',
    'emerald' => 'bg-emerald-50 text-emerald-800 border-emerald-200',
    'amber' => 'bg-amber-50 text-amber-800 border-amber-200',
    'slate' => 'bg-slate-100 text-slate-700 border-slate-200',
][$color] ?? 'bg-hospital-50 text-hospital-800 border-hospital-200';

$sizeClasses = [
    'xs' => 'text-[11px] px-2 py-0.5 font-medium',
    'sm' => 'text-xs px-2.5 py-1 font-semibold',
    'md' => 'text-sm px-3 py-1.5 font-semibold',
][$size] ?? 'text-xs px-2.5 py-1 font-semibold';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 rounded-full border shadow-2xs {$colorClasses} {$sizeClasses}"]) }}>
    @if($pulse)
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $color === 'emergency' ? 'bg-red-400' : 'bg-hospital-400' }}"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 {{ $color === 'emergency' ? 'bg-red-600' : 'bg-hospital-600' }}"></span>
        </span>
    @endif
    {{ $slot }}
</span>

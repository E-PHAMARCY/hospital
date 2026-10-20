@props(['announcement'])

@php
$typeStyles = [
    'urgent' => 'bg-red-700 text-white border-red-800',
    'alert' => 'bg-amber-600 text-white border-amber-700',
    'info' => 'bg-hospital-900 text-hospital-100 border-hospital-800',
][$announcement->type] ?? 'bg-hospital-900 text-hospital-100 border-hospital-800';
@endphp

<div class="border-b {{ $typeStyles }} py-2.5">
    <div class="site-container flex items-center justify-between flex-wrap gap-2 text-xs">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $announcement->type === 'urgent' ? 'bg-white text-red-700' : 'bg-hospital-700 text-white' }}">
                {{ $announcement->type }}
            </span>
            <strong class="font-semibold text-white">{{ $announcement->title }}:</strong>
            <span>{{ $announcement->message }}</span>
        </div>
        @if($announcement->action_url)
            <a href="{{ $announcement->action_url }}" class="underline font-bold hover:text-white transition">
                {{ $announcement->action_text ?? 'Details &rarr;' }}
            </a>
        @endif
    </div>
</div>

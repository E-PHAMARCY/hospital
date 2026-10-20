@props([
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed with this operation? This action may not be reversible.',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'action' => '#',
    'method' => 'POST',
])

<div x-data="{ open: false }" class="inline">
    <div @click="open = true" class="inline cursor-pointer">
        {{ $trigger ?? $slot }}
    </div>

    <div 
        x-show="open" 
        x-cloak 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs"
        @keydown.escape.window="open = false"
    >
        <div 
            class="bg-white rounded-2xl p-6 max-w-md w-full shadow-2xl border border-slate-200"
            @click.away="open = false"
        >
            <h3 class="text-lg font-heading font-bold text-slate-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-slate-600 mb-6 leading-relaxed">{{ $message }}</p>

            <form action="{{ $action }}" method="POST" class="flex justify-end gap-3">
                @csrf
                @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
                    @method($method)
                @endif
                <button 
                    type="button" 
                    @click="open = false"
                    class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50 text-xs font-semibold"
                >
                    {{ $cancelText }}
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 rounded-lg bg-emergency-600 hover:bg-emergency-700 text-white text-xs font-semibold shadow-sm"
                >
                    {{ $confirmText }}
                </button>
            </form>
        </div>
    </div>
</div>

@props([
    'label' => null,
    'name' => '',
    'required' => false,
    'helper' => null,
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-emergency-600">*</span>
            @endif
        </label>
    @endif

    <div class="relative rounded-lg shadow-2xs">
        <select 
            name="{{ $name }}" 
            id="{{ $name }}"
            @if($required) required @endif
            {{ $attributes->merge([
                'class' => 'block w-full rounded-lg border-slate-300 px-3.5 py-2.5 text-slate-900 focus:border-hospital-600 focus:ring-2 focus:ring-hospital-600/20 text-sm transition sm:leading-6 bg-white ' . ($errors->has($name) ? 'border-red-400 focus:border-red-500 focus:ring-red-200' : 'border-slate-300')
            ]) }}
        >
            {{ $slot }}
        </select>
    </div>

    @if($helper && !$errors->has($name))
        <p class="mt-1 text-xs text-slate-500">{{ $helper }}</p>
    @endif

    @error($name)
        <p class="mt-1.5 text-xs text-emergency-600 font-medium flex items-center gap-1">
            <svg class="w-3.5 h-3.5 inline shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>

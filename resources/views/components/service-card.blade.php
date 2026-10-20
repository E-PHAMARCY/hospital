@props(['service'])

@php
    $slug = strtolower($service->slug ?? '');
    $deptSlug = strtolower($service->department->slug ?? '');
    
    if (str_contains($slug, 'rehab') || str_contains($deptSlug, 'rehab')) {
        $img = asset('images/service_rehab.jpg');
    } elseif (str_contains($slug, 'dent') || str_contains($deptSlug, 'dent')) {
        $img = asset('images/service_dental.jpg');
    } elseif (str_contains($slug, 'obgyn') || str_contains($slug, 'matern') || str_contains($deptSlug, 'matern') || str_contains($slug, 'women')) {
        $img = asset('images/service_obgyn.jpg');
    } elseif (str_contains($slug, 'paed') || str_contains($slug, 'ped') || str_contains($deptSlug, 'ped') || str_contains($slug, 'child')) {
        $img = asset('images/service_paediatric.jpg');
    } elseif (str_contains($slug, 'card') || str_contains($deptSlug, 'card') || str_contains($slug, 'heart')) {
        $img = asset('images/media_cardiac_surgery.jpg');
    } elseif (str_contains($slug, 'plas') || str_contains($deptSlug, 'plas') || str_contains($slug, 'surg')) {
        $img = asset('images/service_plastic.jpg');
    } elseif (str_contains($slug, 'mri') || str_contains($slug, 'diag') || str_contains($slug, 'imag') || str_contains($slug, 'scan')) {
        $img = asset('images/news_mri_diagnostic.jpg');
    } else {
        $img = asset('images/hero_surgery_suite.jpg');
    }
@endphp

<div class="rounded-2xl border border-slate-200 overflow-hidden hover:shadow-card hover:border-hospital-400 transition bg-white flex flex-col justify-between group">
    <div>
        <div class="h-36 w-full relative overflow-hidden bg-slate-900">
            <img src="{{ $img }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent"></div>
            
            <div class="absolute top-3 left-3">
                @if($service->department)
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-navy-800 text-white backdrop-blur-xs shadow-sm">
                        {{ $service->department->name }}
                    </span>
                @endif
            </div>

            @if($service->is_emergency)
                <div class="absolute top-3 right-3">
                    <x-badge color="emergency" size="xs">24/7 Resuscitation</x-badge>
                </div>
            @endif
        </div>

        <div class="p-5">
            <h3 class="text-base font-heading font-bold text-navy-950 mb-2 group-hover:text-hospital-700 transition leading-snug">
                <a href="{{ route('services.show', $service->slug) }}">
                    {{ $service->name }}
                </a>
            </h3>
            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                {{ $service->summary ?? 'Advanced diagnostic and therapeutic clinical support.' }}
            </p>
        </div>
    </div>

    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
        @if($service->department)
            <span class="text-slate-400 truncate text-[11px]">{{ $service->department->name }}</span>
        @else
            <span></span>
        @endif
        <a href="{{ route('services.show', $service->slug) }}" class="font-bold text-hospital-700 hover:text-hospital-900 transition">
            Details &rarr;
        </a>
    </div>
</div>

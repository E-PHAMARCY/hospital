@props(['department'])

<x-card :hover="true" class="flex flex-col justify-between h-full group border-slate-200/90">
    <div>
        <div class="h-12 w-12 rounded-xl bg-hospital-50 text-hospital-700 flex items-center justify-center font-bold text-xl mb-4 border border-hospital-100 group-hover:scale-105 group-hover:bg-hospital-700 group-hover:text-white transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h3 class="text-lg font-heading font-bold text-navy-950 mb-2 group-hover:text-hospital-700 transition">
            <a href="{{ route('departments.show', $department->slug) }}">
                {{ $department->name }}
            </a>
        </h3>
        <p class="text-sm text-slate-600 line-clamp-3 leading-relaxed mb-4">
            {{ $department->summary ?? 'Specialized medical diagnosis and clinical treatment services.' }}
        </p>
    </div>

    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
        <span class="text-slate-500 font-medium truncate max-w-[60%]">{{ $department->location ?? 'Main Clinical Wing' }}</span>
        <a href="{{ route('departments.show', $department->slug) }}" class="font-bold text-hospital-700 hover:text-hospital-900 transition flex items-center gap-1">
            <span>{{ __('hospital.actions.learn_more') }}</span> &rarr;
        </a>
    </div>
</x-card>

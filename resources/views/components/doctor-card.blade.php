@props(['doctor'])

<x-card padding="p-6" :hover="true" class="text-center flex flex-col justify-between h-full border-slate-200/90 group">
    <div>
        <div class="h-28 w-28 rounded-full bg-gradient-to-tr from-hospital-700 to-hospital-500 text-white flex items-center justify-center font-bold text-3xl mx-auto mb-4 shadow-md group-hover:scale-105 transition duration-200">
            @if($doctor->photo)
                <img src="{{ asset($doctor->photo) }}" alt="{{ $doctor->name }}" class="h-full w-full object-cover rounded-full">
            @else
                <span>{{ substr($doctor->name, 0, 1) }}</span>
            @endif
        </div>
        <h3 class="font-heading font-bold text-base text-navy-950 mb-1 group-hover:text-hospital-700 transition">
            <a href="{{ route('doctors.show', $doctor->id) }}">
                {{ $doctor->name }}
            </a>
        </h3>
        <div class="text-xs font-semibold text-hospital-700 mb-2">
            {{ $doctor->qualification }}
        </div>
        @if($doctor->department)
            <div class="text-xs text-slate-500 mb-3">
                {{ $doctor->department->name }}
            </div>
        @endif
    </div>

    <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs mt-3">
        <span class="text-slate-500 truncate text-[11px]">
            {{ $doctor->consultation_hours ?? 'Mon - Fri' }}
        </span>
        <a href="{{ route('appointments.create', ['doctor' => $doctor->id]) }}" class="font-bold text-hospital-700 hover:text-hospital-900 transition flex items-center gap-1">
            <span>Book</span> &rarr;
        </a>
    </div>
</x-card>

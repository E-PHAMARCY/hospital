@props(['item'])

<x-card :hover="true" padding="p-0" class="overflow-hidden flex flex-col justify-between h-full border-slate-200/90 group">
    <div>
        <div class="h-44 w-full bg-slate-800 relative overflow-hidden">
            <img src="{{ $item->image }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
            <span class="absolute top-2.5 left-2.5 font-semibold text-white bg-hospital-600 px-2 py-0.5 rounded text-[10px] uppercase shadow-xs">
                {{ $item->category }}
            </span>
            <span class="absolute bottom-2.5 right-2.5 text-[10px] text-white/90 bg-black/60 px-2 py-0.5 rounded backdrop-blur-xs">
                {{ $item->published_at ? $item->published_at->format('M d, Y') : 'Recent' }}
            </span>
        </div>
        <div class="p-5">
            <h3 class="font-heading font-bold text-base text-navy-950 mb-2 leading-snug group-hover:text-hospital-700 transition line-clamp-2">
                <a href="{{ route('news.show', $item->slug) }}">
                    {{ $item->title }}
                </a>
            </h3>
            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                {{ $item->excerpt }}
            </p>
        </div>
    </div>
    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between text-xs bg-slate-50/50">
        <a href="{{ route('news.show', $item->slug) }}" class="font-bold text-hospital-700 hover:text-hospital-700 transition flex items-center gap-1">
            <span>{{ __('hospital.actions.read_more') }}</span> &rarr;
        </a>
    </div>
</x-card>

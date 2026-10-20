@extends('layouts.public')

@section('title', __('hospital.hospital_name') . ' — Excellence in Healthcare')

@section('content')

<!-- =========================================================================
     1. HERO ARCHITECTURAL SLIDER (Screenshot 1)
     ========================================================================= -->
@php
    $heroSlidesList = !empty($heroSlides) ? $heroSlides : [
        [
            'title' => 'EPHAMARCY HOSPITAL',
            'sub' => 'Delivering comprehensive inpatient, outpatient, advanced surgical procedures, and compassionate healing.',
            'image' => 'images/hero_hospital_facade.jpg',
            'btn1_text' => 'Book Appointment',
            'btn1_link' => route('appointments.create'),
            'btn2_text' => 'Explore Services →',
            'btn2_link' => route('services.index')
        ],
        [
            'title' => 'ADVANCED CLINICAL EXCELLENCE',
            'sub' => 'Equipped with state-of-the-art diagnostic imaging, cath labs, surgical suites, and 24/7 emergency resuscitation.',
            'image' => 'images/hero_surgery_suite.jpg',
            'btn1_text' => 'Book Appointment',
            'btn1_link' => route('appointments.create'),
            'btn2_text' => 'Explore Services →',
            'btn2_link' => route('services.index')
        ]
    ];
@endphp
<section class="relative bg-slate-900 text-white overflow-hidden" x-data="{
    activeSlide: 0,
    slides: @js($heroSlidesList),
    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length }
}">
    <!-- Slider Container -->
    <div class="relative min-h-[460px] sm:min-h-[520px] lg:h-[600px] w-full flex items-center">
        
        <!-- Dynamic Slide Background Photos -->
        <template x-for="(slide, sIdx) in slides" :key="sIdx">
            <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out"
                 :class="activeSlide === sIdx ? 'opacity-100 scale-100 z-0' : 'opacity-0 scale-105 pointer-events-none -z-10'"
                 :style="'background-image: linear-gradient(180deg, rgba(9, 28, 49, 0.4) 0%, rgba(9, 28, 49, 0.85) 100%), radial-gradient(circle at 50% 30%, rgba(21, 60, 99, 0.3) 0%, rgba(9, 28, 49, 0.95) 100%), url(\'' + (slide.image && (slide.image.startsWith('http') || slide.image.startsWith('/')) ? slide.image : '{{ asset('') }}' + slide.image) + '\');'">
            </div>
        </template>

        <!-- Subtle Gradient Scrim at Bottom for Maximum Contrast -->
        <div class="absolute inset-x-0 bottom-0 h-48 bg-gradient-to-t from-navy-950/90 via-navy-950/50 to-transparent pointer-events-none z-10"></div>

        <!-- Hero Content Overlay -->
        <div class="relative site-container px-16 sm:px-20 lg:px-24 2xl:px-12 py-16 z-20">
            <div class="max-w-4xl space-y-3 sm:space-y-4 text-left">

                <!-- Prominent Hospital Title on Building Facade -->
                <h1 class="text-2xl xs:text-3xl sm:text-5xl lg:text-6xl font-heading font-black tracking-tight text-white uppercase drop-shadow-lg"
                    x-text="slides[activeSlide]?.title || '{{ __('hospital.hospital_name') }}'">
                    {{ __('hospital.hospital_name') }}
                </h1>

                <p class="text-xs sm:text-base lg:text-lg text-slate-100 font-light max-w-2xl leading-relaxed drop-shadow"
                   x-text="slides[activeSlide]?.sub || ''">
                    Excellence in healthcare delivery, super-specialized clinical consultation, emergency trauma resuscitation, and patient-centered healing.
                </p>

                <div class="flex flex-col xs:flex-row items-stretch xs:items-center justify-start gap-2.5 sm:gap-3 pt-3 sm:pt-4">
                    <a :href="slides[activeSlide]?.btn1_link || '{{ route('appointments.create') }}'" 
                       class="px-5 py-3 rounded bg-hospital-600 hover:bg-hospital-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg transition text-center"
                       x-text="slides[activeSlide]?.btn1_text || 'Book Appointment'">
                        Book Appointment
                    </a>
                    <a :href="slides[activeSlide]?.btn2_link || '{{ route('services.index') }}'" 
                       class="px-5 py-3 rounded bg-white/15 hover:bg-white/25 backdrop-blur-md text-white font-bold text-xs uppercase tracking-wider border border-white/30 transition text-center"
                       x-text="slides[activeSlide]?.btn2_text || 'Explore Services →'">
                        Explore Services &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Slider Arrows (< and >) -->
        <button @click="prev()" type="button" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow-lg transition duration-150 focus:outline-none z-30" aria-label="Previous Slide">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button @click="next()" type="button" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 h-9 w-9 sm:h-11 sm:w-11 rounded-full bg-white/80 hover:bg-white text-slate-800 flex items-center justify-center shadow-lg transition duration-150 focus:outline-none z-30" aria-label="Next Slide">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Slide Indicator Dots -->
        <div class="absolute bottom-4 right-4 sm:right-8 z-30 flex items-center gap-2">
            <template x-for="(slide, sIdx) in slides" :key="sIdx">
                <button @click="activeSlide = sIdx" class="h-2 rounded-full transition-all duration-300" :class="activeSlide === sIdx ? 'w-8 bg-hospital-600' : 'w-2 bg-white/60 hover:bg-white'"></button>
            </template>
        </div>
    </div>
</section>

<!-- =========================================================================
     2. EXECUTIVE DIRECTOR'S STATEMENT & MEDIA (Image 1)
     ========================================================================= -->
<section class="py-12 sm:py-16 bg-white border-b border-slate-200">
    <div class="site-container">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-8 items-center">
            
            <!-- Executive Director Profile Card (Image 1 Left) -->
            <div class="md:col-span-4 lg:col-span-3">
                <div class="rounded-2xl overflow-hidden bg-white border border-slate-200/90 shadow-sm max-w-xs mx-auto md:max-w-none text-center group">
                    <!-- Director Portrait with Vibrant Blue Studio Background -->
                    <div class="w-full aspect-[4/5] bg-sky-500 relative overflow-hidden">
                        <img src="{{ asset(!empty($directorStatement['photo']) ? $directorStatement['photo'] : 'images/director_dr_delilah.jpg') }}" 
                             alt="{{ $directorStatement['name'] ?? ($director->name ?? 'Dr. Delilah Charles Kimambo') }}" 
                             class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                    </div>

                    <!-- Label Card Below Portrait -->
                    <div class="p-4 bg-white border-t border-slate-100">
                        <h4 class="font-heading font-extrabold text-base text-navy-950 leading-snug">
                            {{ $directorStatement['name'] ?? ($director->name ?? 'Dr. Delilah Charles Kimambo') }}
                        </h4>
                        <span class="block text-xs font-semibold text-slate-500 mt-0.5">
                            {{ $directorStatement['title'] ?? 'Executive Director' }}
                        </span>
                        <span class="block text-[11px] text-slate-400 mt-0.5">
                            {{ $directorStatement['hospital'] ?? __('hospital.hospital_name') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Statement Content (Image 1 Center) -->
            <div class="md:col-span-8 lg:col-span-5 space-y-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-black text-navy-950 tracking-tight leading-tight">
                        {{ $directorStatement['statement_title'] ?? "Executive Director's Statement" }}
                    </h2>
                </div>

                <div class="text-slate-600 text-sm leading-relaxed space-y-3 font-normal" x-data="{ expanded: false }">
                    <p>
                        {{ $directorStatement['lead'] ?? "Muhimbili National Hospital is proud of its long-standing history as Tanzania's leading tertiary referral and teaching hospital under the Ministry of Health. As the highest level of care in the country's health system, MNH serves the nation and neighboring countries by providing advanced specialized and super-specialized medical services." }}
                        @if(!empty($directorStatement['extended']))
                            <span x-show="expanded" x-cloak>
                                {{ $directorStatement['extended'] }}
                            </span>
                            <button @click="expanded = !expanded" type="button" class="text-navy-900 font-bold hover:underline inline ml-1 focus:outline-none">
                                <span x-show="!expanded">See more</span>
                                <span x-show="expanded" x-cloak>Show less</span>
                            </button>
                        @endif
                    </p>
                </div>

                <!-- Two CTA Buttons (Image 1: Navy Solid & Red Outline) -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ $directorStatement['btn1_link'] ?? route('about.section', 'mission-vision') }}" class="px-6 py-3 rounded bg-[#153C63] hover:bg-[#0f2c4a] text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                        {{ $directorStatement['btn1_text'] ?? 'DISCOVER OUR MISSION' }}
                    </a>
                    <a href="{{ $directorStatement['btn2_link'] ?? route('doctors.index') }}" class="px-6 py-3 rounded border-2 border-red-600 text-red-600 hover:bg-red-50 font-bold text-xs uppercase tracking-wider transition">
                        {{ $directorStatement['btn2_text'] ?? 'MEET OUR TEAM' }}
                    </a>
                </div>
            </div>

            <!-- Hospital Media / Video Cards Carousel (Image 1 Right) -->
            <div class="col-span-12 lg:col-span-4 pt-4 lg:pt-0" x-data="{
                scrollLeft() { $refs.videoTrack.scrollBy({ left: -240, behavior: 'smooth' }) },
                scrollRight() { $refs.videoTrack.scrollBy({ left: 240, behavior: 'smooth' }) }
            }">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                        Featured Videos
                    </span>
                    <div class="flex items-center gap-1.5">
                        <button @click="scrollLeft()" type="button" class="h-7 w-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition" aria-label="Previous video">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="scrollRight()" type="button" class="h-7 w-7 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition" aria-label="Next video">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <div x-ref="videoTrack" class="flex gap-4 overflow-x-auto pb-2 scroll-smooth snap-x snap-mandatory scrollbar-none">
                    @forelse($homepageVideos as $hVid)
                        <a href="{{ $hVid['url'] ?? '#' }}" target="_blank" class="w-60 sm:w-64 shrink-0 snap-start rounded-xl overflow-hidden bg-white border border-slate-200 shadow-2xs hover:shadow-md transition group block">
                            <div class="h-36 bg-slate-900 relative flex items-center justify-center overflow-hidden">
                                <img src="{{ asset($hVid['image'] ?? 'images/media_doctor_interview.jpg') }}" alt="{{ $hVid['title'] ?? '' }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-black/30"></div>
                                <div class="relative h-11 w-11 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-200">
                                    <svg class="w-5 h-5 ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                    </svg>
                                </div>
                                <span class="absolute top-2 left-2 text-[10px] font-bold text-white bg-black/60 backdrop-blur-xs px-2 py-0.5 rounded">{{ $hVid['channel'] ?? 'Muhimbili TV' }}</span>
                            </div>
                            <div class="p-3 bg-white text-center">
                                <h4 class="font-heading font-bold text-xs text-navy-950 group-hover:text-hospital-700 transition line-clamp-2">
                                    {{ $hVid['title'] ?? '' }}
                                </h4>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-xs text-slate-400">No videos posted.</div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</section>


<!-- =========================================================================
     LIVE OPERATIONAL TICKER ("HIGHLIGHTS" STRIP — Image 2)
     ========================================================================= -->
@php
    $tickerBadge = $ticker['badge'] ?? 'HIGHLIGHTS';
    $tickerFeed = !empty($ticker['items']) ? $ticker['items'] : [
        ['tag' => 'NEWS', 'text' => 'WAZIRI WA AFYA ATOA MAAGIZO BODI MPYA YA WADHAMINI MUHIMBILI'],
        ['tag' => 'NEWS', 'text' => 'MUHIMBILI YAKUTANA NA MASHUJAA WALIOPONA MAGONJWA SUGU'],
        ['tag' => 'NEWS', 'text' => 'KAMBI MAALUM YA MADAKTARI BINGWA WA UPASUAJI WA MOYO YAANZA'],
        ['tag' => 'EMERGENCY', 'text' => 'HUDUMA YA DHARURA 24/7 — PIGA SIMU: +255742448965'],
    ];
@endphp
<div class="bg-slate-100 border-b border-slate-200 py-2.5 overflow-hidden">
    <div class="site-container flex items-center gap-3">
        <!-- Highlights Badge in Navy to Burgundy Gradient (Image 2) -->
        <div class="shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded bg-gradient-to-r from-[#153C63] to-[#8C1D2F] text-white font-extrabold text-[11px] sm:text-xs uppercase tracking-wider shadow-sm z-10">
            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 00-3 3v2a3 3 0 003 3h3.763l7.79 3.894A1 1 0 0018 17V3zM4 11a1 1 0 01-1-1V9a1 1 0 011-1h1v3H4zm6.5-3.327l5.5-2.75v10.154l-5.5-2.75V7.673z" clip-rule="evenodd"/>
            </svg>
            <span>{{ $tickerBadge }}</span>
        </div>

        <!-- Continuous Right-to-Left Automatic Swipe Marquee -->
        <div class="relative overflow-hidden flex-1 group">
            <div class="flex animate-marquee whitespace-nowrap group-hover:[animation-play-state:paused]">
                <!-- Track 1 -->
                <div class="flex items-center gap-6 text-xs text-slate-700 font-medium shrink-0 pr-6">
                    @foreach($tickerFeed as $tItem)
                        <span class="text-slate-400 font-bold">...</span>
                        <span class="font-bold text-navy-950 uppercase">{{ $tItem['tag'] ?? 'NEWS' }}:</span>
                        <span>{{ $tItem['text'] }}</span>
                    @endforeach
                </div>
                <!-- Track 2 (Identical duplicate for seamless infinite loop) -->
                <div class="flex items-center gap-6 text-xs text-slate-700 font-medium shrink-0 pr-6" aria-hidden="true">
                    @foreach($tickerFeed as $tItem)
                        <span class="text-slate-400 font-bold">...</span>
                        <span class="font-bold text-navy-950 uppercase">{{ $tItem['tag'] ?? 'NEWS' }}:</span>
                        <span>{{ $tItem['text'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =========================================================================
     3. CLINICAL SERVICES SECTION (Image 3)
     ========================================================================= -->
@php
    $serviceColorStyles = [
        'teal' => [
            'icon' => 'text-teal-600',
            'title' => 'text-teal-700',
            'link' => 'text-teal-600 hover:text-teal-800'
        ],
        'purple' => [
            'icon' => 'text-purple-600',
            'title' => 'text-purple-700',
            'link' => 'text-purple-600 hover:text-purple-800'
        ],
        'orange' => [
            'icon' => 'text-orange-500',
            'title' => 'text-orange-600',
            'link' => 'text-orange-500 hover:text-orange-700'
        ],
        'red' => [
            'icon' => 'text-red-600',
            'title' => 'text-red-600',
            'link' => 'text-red-600 hover:text-red-800'
        ],
        'amber' => [
            'icon' => 'text-amber-500',
            'title' => 'text-amber-600',
            'link' => 'text-amber-500 hover:text-amber-700'
        ],
        'navy' => [
            'icon' => 'text-navy-900',
            'title' => 'text-navy-950',
            'link' => 'text-navy-800 hover:text-navy-950'
        ],
        'blue' => [
            'icon' => 'text-blue-600',
            'title' => 'text-blue-700',
            'link' => 'text-blue-600 hover:text-blue-800'
        ],
        'emerald' => [
            'icon' => 'text-emerald-600',
            'title' => 'text-emerald-700',
            'link' => 'text-emerald-600 hover:text-emerald-800'
        ],
    ];
@endphp
<section class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="site-container">
        
        <!-- Header with Two-Tone Accent Underline -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                Clinical Services
            </h2>
            <!-- Centered Two-Tone Accent Line (Half Red, Half Navy) -->
            <div class="h-1 w-20 mx-auto mt-3 flex rounded-full overflow-hidden">
                <div class="w-1/2 bg-red-600"></div>
                <div class="w-1/2 bg-[#153C63]"></div>
            </div>
            <p class="mt-3 text-slate-600 text-sm leading-relaxed">
                We offer a wide range of clinical services to our patients.
            </p>
        </div>

        <!-- Services Carousel with Left and Right Arrows (Image 3) -->
        <div class="relative" x-data="{
            scrollLeft() { $refs.servicesTrack.scrollBy({ left: -280, behavior: 'smooth' }) },
            scrollRight() { $refs.servicesTrack.scrollBy({ left: 280, behavior: 'smooth' }) }
        }">
            <!-- Left Arrow Button (<) -->
            <button @click="scrollLeft()" type="button" class="absolute -left-2 sm:-left-5 top-1/2 -translate-y-1/2 z-20 h-9 w-9 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-600 hover:text-navy-950 hover:bg-slate-50 transition focus:outline-none" aria-label="Previous clinical services">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Cards Track -->
            <div x-ref="servicesTrack" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 overflow-x-auto scrollbar-none scroll-smooth py-1 px-1">
                @forelse($services as $srv)
                    @php
                        $cStyle = $serviceColorStyles[$srv->color ?? 'teal'] ?? $serviceColorStyles['teal'];
                        $icon = $srv->icon ?? 'briefcase';
                    @endphp
                    <div class="p-6 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md transition duration-200 flex flex-col justify-between text-center group min-w-[240px] sm:min-w-0">
                        <div>
                            <!-- Dynamic Colored Icon -->
                            <div class="h-12 w-12 mx-auto mb-4 {{ $cStyle['icon'] }} flex items-center justify-center">
                                @if($icon === 'smile')
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h.01M15 10h.01M9.5 15a3.5 3.5 0 005 0"/>
                                    </svg>
                                @elseif($icon === 'heart-pulse')
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12h4l3-7 4 14 3-7h4"/>
                                    </svg>
                                @elseif($icon === 'brain')
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2a7 7 0 00-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 001 1h6a1 1 0 001-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 00-7-7zm0 18a2 2 0 01-2-2h4a2 2 0 01-2 2z"/>
                                    </svg>
                                @else
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 6h-3V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2zM10 4h4v2h-4V4zm3 10h-2v2a1 1 0 11-2 0v-2H7a1 1 0 110-2h2v-2a1 1 0 112 0v2h2a1 1 0 110 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="font-heading font-bold text-base {{ $cStyle['title'] }} mb-2">
                                {{ $srv->name }}
                            </h3>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                {{ $srv->summary }}
                            </p>
                        </div>
                        <div class="pt-5 mt-4 text-center">
                            <a href="{{ route('services.show', $srv->slug) }}" class="text-xs font-semibold {{ $cStyle['link'] }} transition inline-flex items-center gap-1">
                                <span>&rarr; Learn More</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-5 text-center py-8 text-slate-400 text-sm">
                        No clinical services currently listed.
                    </div>
                @endforelse
            </div>

            <!-- Right Arrow Button (>) -->
            <button @click="scrollRight()" type="button" class="absolute -right-2 sm:-right-5 top-1/2 -translate-y-1/2 z-20 h-9 w-9 rounded-full bg-white border border-slate-200 shadow-md flex items-center justify-center text-slate-600 hover:text-navy-950 hover:bg-slate-50 transition focus:outline-none" aria-label="Next clinical services">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Centered "View All Services" Button (Image 3) -->
        <div class="text-center mt-10">
            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded border border-red-600 text-red-600 hover:bg-red-600 hover:text-white font-bold text-xs uppercase tracking-wider transition">
                <span>View All Services</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>


<!-- =========================================================================
     4. THREE-COLUMN INSTITUTIONAL & FAQ HUB (Screenshot 4)
     ========================================================================= -->
<section class="py-16 bg-white border-b border-slate-200">
    <div class="site-container">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Col 1: "How do i?" FAQ Accordion -->
            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-soft flex flex-col justify-between">
                <div>
                    <!-- Deep Blue Header Banner -->
                    <div class="bg-navy-800 text-white p-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-hospital-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="font-heading font-extrabold text-base">How do i?</h3>
                                    <!-- Accordion Items -->
                    <div class="divide-y divide-slate-100 text-xs">
                        @forelse($faqs as $fItem)
                            <div x-data="{ open: false }" class="p-3.5 hover:bg-slate-50 transition cursor-pointer" @click="open = !open">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="font-semibold text-slate-800">{{ $fItem->question }}</span>
                                    <svg class="w-4 h-4 text-slate-400 shrink-0 transition" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] font-bold bg-hospital-100 text-hospital-700 uppercase">{{ $fItem->category }}</span>
                                <div x-show="open" x-cloak class="mt-2 text-slate-500 leading-relaxed pt-2 border-t border-slate-100">
                                    {{ $fItem->answer }}
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-xs text-slate-400 text-center">No FAQs available.</div>
                        @endforelse
                    </div>
                </div>

                <div class="p-3 border-t border-slate-100 text-center bg-slate-50/50">
                    <a href="{{ route('patients.section', 'faq') }}" class="text-xs font-bold text-hospital-700 hover:underline">View All FAQs &rarr;</a>
                </div>
            </div>

            <!-- Col 2: "Our Core Values" (Screenshot 4 Center) -->
            @php
                $coreValuesList = !empty($coreValues) ? $coreValues : [
                    [
                        'title' => 'Core Services',
                        'description' => "Priorities related to Ephamarcy Hospital's core service offering as a premier medical center.",
                        'color' => 'navy',
                    ],
                    [
                        'title' => 'Enablers',
                        'description' => 'Priorities related to clinical workforce training, infrastructure modernization, and healthcare digitalization.',
                        'color' => 'amber',
                    ],
                    [
                        'title' => 'Foundations',
                        'description' => 'Priorities related to mechanisms and relationships fundamental to ensuring sustainability, research, and ethics.',
                        'color' => 'teal',
                    ],
                ];
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-soft flex flex-col justify-between">
                <div>
                    <!-- Deep Blue Header Banner -->
                    <div class="bg-navy-800 text-white p-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-hospital-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <h3 class="font-heading font-extrabold text-base">Our Core Values</h3>
                    </div>

                    <!-- Values List -->
                    <div class="p-5 space-y-6">
                        @foreach($coreValuesList as $cv)
                            @php
                                $vColor = match($cv['color'] ?? 'navy') {
                                    'amber' => 'bg-amber-500',
                                    'teal' => 'bg-teal-600',
                                    'red' => 'bg-red-600',
                                    'purple' => 'bg-purple-600',
                                    default => 'bg-navy-900',
                                };
                            @endphp
                            <div class="flex items-start gap-3">
                                <div class="h-9 w-9 rounded-lg {{ $vColor }} text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-heading font-bold text-sm text-navy-950">{{ $cv['title'] }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                        {{ $cv['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-3 border-t border-slate-100 text-center bg-slate-50/50">
                    <a href="{{ route('about.section', 'mission-vision') }}" class="text-xs font-bold text-hospital-700 hover:underline">Our Mission & Principles &rarr;</a>
                </div>
            </div>      </div>

            <!-- Col 3: "Muhimbili Headlines" (Screenshot 4 Right) -->
            <div class="md:col-span-2 lg:col-span-1 rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-soft flex flex-col justify-between">
                <div>
                    <!-- Deep Blue Header Banner -->
                    <div class="bg-navy-800 text-white p-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-hospital-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        <h3 class="font-heading font-extrabold text-base">{{ __('hospital.hospital_name') }} Headlines</h3>
                    </div>

                    <!-- Vertical News Feed with Scrollbar -->
                    <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto text-xs">
                        @forelse($headlines as $hl)
                            <div class="p-4 hover:bg-slate-50 transition">
                                <h4 class="font-bold text-slate-800 hover:text-hospital-700 leading-snug">
                                    <a href="{{ route('news.show', $hl->slug) }}">
                                        {{ $hl->title }}
                                    </a>
                                </h4>
                                <span class="text-[10px] text-slate-400 mt-1 block">
                                    {{ $hl->published_at ? $hl->published_at->format('F d, Y') : 'Recent' }}
                                </span>
                            </div>
                        @empty
                            <div class="p-4 text-slate-400 text-center">
                                No headlines available.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="p-3 border-t border-slate-100 text-center bg-slate-50/50">
                    <a href="{{ route('news.index') }}" class="text-xs font-bold text-hospital-700 hover:underline">All Official Bulletins &rarr;</a>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- =========================================================================
     5. LATEST NEWS & ANNOUNCEMENTS (Screenshot 5)
     ========================================================================= -->
<section class="py-16 bg-slate-50 border-b border-slate-200">
    <div class="site-container">
        
        <!-- Section Header with Red Megaphone Icon -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-6 h-6 text-hospital-700" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/>
                </svg>
                <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                    Latest News & Announcements
                </h2>
            </div>
            <!-- Two-Tone Accent Line -->
            <div class="h-1 w-20 mx-auto mt-3 flex rounded-full overflow-hidden">
                <div class="w-1/2 bg-hospital-600"></div>
                <div class="w-1/2 bg-navy-800"></div>
            </div>
        </div>

        <!-- 4-Card News Grid (Screenshot 5) -->
        @php
            $newsPhotos = [
                asset('images/news_mri_diagnostic.jpg'),
                asset('images/news_blood_donation.jpg'),
                asset('images/media_cardiac_surgery.jpg'),
                asset('images/media_maternal_health.jpg'),
            ];
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($latestNews as $newsItem)
                @php
                    $photo = $newsItem->image ? asset($newsItem->image) : ($newsPhotos[$loop->index % count($newsPhotos)]);
                @endphp
                <div class="rounded-2xl overflow-hidden bg-white border border-slate-200/90 shadow-soft hover:shadow-card transition flex flex-col justify-between group">
                    <div>
                        <!-- Thumbnail Image Container with Badge -->
                        <div class="h-44 w-full bg-slate-800 relative overflow-hidden">
                            <img src="{{ $photo }}" alt="{{ $newsItem->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-transparent"></div>

                            <!-- Category Badge -->
                            <div class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-md bg-hospital-600 text-[10px] font-bold text-white uppercase shadow-sm">
                                {{ $newsItem->category ?? 'News' }}
                            </div>

                            <!-- Date Pill (e.g. October 11, 2026) -->
                            <div class="absolute bottom-2.5 right-2.5 px-2.5 py-1 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-semibold text-white flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $newsItem->published_at ? $newsItem->published_at->format('F d, Y') : 'October 11, 2026' }}</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5">
                            <h3 class="font-heading font-extrabold text-sm text-navy-950 group-hover:text-hospital-700 transition line-clamp-2 leading-snug mb-2">
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    {{ $newsItem->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ $newsItem->excerpt }}
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Bar with Read More & Share Icon -->
                    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('news.show', $newsItem->slug) }}" class="font-bold text-hospital-700 hover:text-hospital-700 transition flex items-center gap-1">
                            <span>Read More</span> &rarr;
                        </a>
                        <button type="button" class="text-slate-400 hover:text-slate-600 transition" aria-label="Share">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-8 text-slate-400 text-sm">
                    No news articles published yet.
                </div>
            @endforelse
        </div>

        <!-- Centered "View All News" Button -->
        <div class="text-center mt-10">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded border-2 border-hospital-600 text-hospital-700 hover:bg-hospital-600 hover:text-white font-bold text-xs uppercase tracking-wider transition">
                <span>View All News</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>

    </div>
</section>


<!-- =========================================================================
     6. OUR BRANCHES / CAMPUSES (Screenshot 5 bottom)
     ========================================================================= -->
<section class="py-16 bg-white">
    <div class="site-container">
        
        <!-- Header with Two-Tone Accent Line -->
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl sm:text-4xl font-heading font-extrabold text-navy-950 tracking-tight">
                Our Branches
            </h2>
            <div class="h-1 w-20 mx-auto mt-3 flex rounded-full overflow-hidden">
                <div class="w-1/2 bg-hospital-600"></div>
                <div class="w-1/2 bg-navy-800"></div>
            </div>
            <p class="mt-3 text-slate-600 text-sm leading-relaxed">
                Strategic clinical campuses and satellite referral facilities delivering specialized healthcare.
            </p>
        </div>

        @php
            $branchPhotos = [
                asset('images/branch_upanga_campus.jpg'),
                asset('images/hero_hospital_facade.jpg'),
                asset('images/hero_surgery_suite.jpg'),
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($locations as $loc)
                @php
                    $bPhoto = $branchPhotos[$loop->index % count($branchPhotos)];
                @endphp
                <div class="rounded-2xl overflow-hidden bg-slate-50 border border-slate-200/90 shadow-soft hover:shadow-card hover:border-hospital-600/40 transition flex flex-col justify-between group">
                    <div>
                        <!-- Branch Campus Photo Banner -->
                        <div class="h-40 w-full relative overflow-hidden bg-slate-800">
                            <img src="{{ $bPhoto }}" alt="{{ $loc->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            @if($loc->is_main)
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-hospital-600 text-white uppercase shadow-sm">
                                    Main Campus
                                </span>
                            @else
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded text-[10px] font-bold bg-navy-800 text-white uppercase shadow-sm">
                                    Specialty Wing
                                </span>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="font-heading font-bold text-lg text-navy-950 mb-2">
                                {{ $loc->name }}
                            </h3>

                            <p class="text-xs text-slate-600 mb-2.5 flex items-start gap-1.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $loc->address }}</span>
                            </p>

                            <p class="text-xs text-slate-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $loc->opening_hours }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="px-5 py-3.5 border-t border-slate-200/80 bg-white flex items-center justify-between text-xs">
                        <span class="font-mono text-slate-600 font-semibold">{{ $loc->phone }}</span>
                        <a href="{{ route('locations.show', $loc->slug) }}" class="font-bold text-hospital-700 hover:underline">
                            Details & Directions &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <!-- Fallback Branches -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-hospital-600 text-white uppercase">Main Campus</span>
                    <h3 class="font-heading font-bold text-lg text-navy-950 mt-3 mb-1">Upanga Main Hospital</h3>
                    <p class="text-xs text-slate-600 mb-3">Medical Avenue, Upanga, Dar es Salaam</p>
                    <span class="text-xs font-mono text-slate-500">Emergency 24/7 | +255742448965</span>
                </div>
            @endforelse
        </div>

    </div>
</section>


<!-- =========================================================================
     7. HOSPITAL STATISTICS (Animated Number Count — Screenshot 1)
     ========================================================================= -->
@php
    $statsTitle = $stats['title'] ?? 'Hospital Statistics';
    $stat1Num = $stats['beds_number'] ?? '1,500';
    $stat1Label = $stats['beds_label'] ?? 'Beds';
    $stat2Num = $stats['doctors_number'] ?? '300+';
    $stat2Label = $stats['doctors_label'] ?? 'Doctors';
    $stat3Num = $stats['staff_number'] ?? '2,500+';
    $stat3Label = $stats['staff_label'] ?? 'Staff Members';
    $stat4Num = $stats['patients_number'] ?? '100K+';
    $stat4Label = $stats['patients_label'] ?? 'Annual Patients';
@endphp
<section class="py-16 sm:py-20 bg-navy-800 text-white overflow-hidden">
    <div class="site-container">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-extrabold text-white text-center mb-12 sm:mb-16 tracking-tight">
            {{ $statsTitle }}
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12 text-center max-w-6xl mx-auto">
            <!-- 1. Beds -->
            <div class="space-y-2">
                <div class="text-4xl sm:text-5xl lg:text-6xl font-heading font-black text-white tracking-tight">
                    {{ $stat1Num }}
                </div>
                <div class="text-xs sm:text-sm text-slate-200 font-medium">
                    {{ $stat1Label }}
                </div>
            </div>

            <!-- 2. Doctors -->
            <div class="space-y-2">
                <div class="text-4xl sm:text-5xl lg:text-6xl font-heading font-black text-white tracking-tight">
                    {{ $stat2Num }}
                </div>
                <div class="text-xs sm:text-sm text-slate-200 font-medium">
                    {{ $stat2Label }}
                </div>
            </div>

            <!-- 3. Staff Members -->
            <div class="space-y-2">
                <div class="text-4xl sm:text-5xl lg:text-6xl font-heading font-black text-white tracking-tight">
                    {{ $stat3Num }}
                </div>
                <div class="text-xs sm:text-sm text-slate-200 font-medium">
                    {{ $stat3Label }}
                </div>
            </div>

            <!-- 4. Annual Patients -->
            <div class="space-y-2">
                <div class="text-4xl sm:text-5xl lg:text-6xl font-heading font-black text-white tracking-tight">
                    {{ $stat4Num }}
                </div>
                <div class="text-xs sm:text-sm text-slate-200 font-medium">
                    {{ $stat4Label }}
                </div>
            </div>
        </div>
    </div>
</section>


<!-- =========================================================================
     8. INSURANCE SERVICES (Auto-Swiping Marquee — Screenshot 2)
     ========================================================================= -->
<section class="py-14 sm:py-18 bg-white border-b border-slate-200 overflow-hidden">
    <div class="site-container">
        
        <!-- Header with Star Accent Line (Screenshot 2) -->
        <div class="text-center max-w-xl mx-auto mb-10">
            <div class="flex items-center justify-center gap-2.5 mb-3">
                <div class="h-[1.5px] w-14 sm:w-20 bg-navy-800"></div>
                <span class="text-hospital-600 text-sm font-bold leading-none">&#9733;</span>
                <div class="h-[1.5px] w-14 sm:w-20 bg-navy-800"></div>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-heading font-black tracking-wider text-[#ea2b2b] uppercase">
                INSURANCE SERVICES
            </h2>
        </div>

        <!-- Auto-Swipe Infinite Marquee Slider -->
        <div class="relative w-full overflow-hidden py-4">
            <!-- Left and Right Gradient Fade Edges -->
            <div class="absolute left-0 inset-y-0 w-16 sm:w-32 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 inset-y-0 w-16 sm:w-32 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

            <div class="animate-marquee items-center gap-12 sm:gap-20">
                
                @php
                    $colorClasses = [
                        'emerald' => 'bg-emerald-600 text-white',
                        'amber' => 'bg-gradient-to-b from-amber-400 to-amber-500 text-slate-900 border border-amber-500/50',
                        'navy' => 'bg-navy-800 text-white',
                        'purple' => 'bg-purple-700 text-white',
                        'teal' => 'bg-teal-600 text-white',
                        'orange' => 'bg-orange-500 text-white',
                        'red' => 'bg-red-600 text-white',
                    ];
                @endphp

                <!-- First Set of Dynamic Partners -->
                @foreach($insurancePartners as $partner)
                    @php
                        $badgeBg = $colorClasses[$partner['badge_color'] ?? 'navy'] ?? 'bg-navy-800 text-white';
                    @endphp
                    <a href="{{ !empty($partner['website_url']) ? $partner['website_url'] : 'javascript:void(0)' }}" 
                       {{ !empty($partner['website_url']) ? 'target="_blank" rel="noopener noreferrer"' : '' }}
                       class="flex items-center gap-3 shrink-0 select-none hover:scale-105 transition duration-200 group">
                        @if(!empty($partner['logo']))
                            <img src="{{ asset($partner['logo']) }}" alt="{{ $partner['name'] }}" class="h-10 max-w-[130px] object-contain drop-shadow-2xs">
                        @else
                            <div class="h-10 min-w-10 px-2 rounded-xl {{ $badgeBg }} flex items-center justify-center font-heading font-black text-xs shadow-2xs tracking-wider">
                                {{ $partner['badge_text'] ?? strtoupper(substr($partner['name'], 0, 4)) }}
                            </div>
                        @endif
                        <div class="leading-tight text-left">
                            <span class="block font-heading font-bold text-xs sm:text-sm text-slate-900 group-hover:text-hospital-600 transition">
                                {{ $partner['name'] }}
                            </span>
                            @if(!empty($partner['subtitle']))
                                <span class="block text-[10px] sm:text-[11px] font-medium text-slate-500">
                                    {{ $partner['subtitle'] }}
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach

                <!-- Seamless Duplicate for Infinite Marquee Loop -->
                @foreach($insurancePartners as $partner)
                    @php
                        $badgeBg = $colorClasses[$partner['badge_color'] ?? 'navy'] ?? 'bg-navy-800 text-white';
                    @endphp
                    <div class="flex items-center gap-3 shrink-0 select-none hover:scale-105 transition duration-200" aria-hidden="true">
                        @if(!empty($partner['logo']))
                            <img src="{{ asset($partner['logo']) }}" alt="" class="h-10 max-w-[130px] object-contain drop-shadow-2xs">
                        @else
                            <div class="h-10 min-w-10 px-2 rounded-xl {{ $badgeBg }} flex items-center justify-center font-heading font-black text-xs shadow-2xs tracking-wider">
                                {{ $partner['badge_text'] ?? strtoupper(substr($partner['name'], 0, 4)) }}
                            </div>
                        @endif
                        <div class="leading-tight text-left">
                            <span class="block font-heading font-bold text-xs sm:text-sm text-slate-900">
                                {{ $partner['name'] }}
                            </span>
                            @if(!empty($partner['subtitle']))
                                <span class="block text-[10px] sm:text-[11px] font-medium text-slate-500">
                                    {{ $partner['subtitle'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

@endsection

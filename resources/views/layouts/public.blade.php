<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __('hospital.hospital_name')) — {{ __('hospital.hospital_tagline') }}</title>
    <meta name="description" content="@yield('meta_description', __('hospital.footer.about_text'))">
    <meta property="og:title" content="@yield('title', __('hospital.hospital_name'))">
    <meta property="og:description" content="@yield('meta_description', __('hospital.footer.about_text'))">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col bg-slate-50 text-slate-800 antialiased font-sans selection:bg-hospital-500 selection:text-white" x-data="{ mobileMenuOpen: false }">

    <!-- Top Institutional Banner with National Coat of Arms & Hospital Logo -->
    <div class="relative overflow-hidden border-b border-slate-200/80 bg-cover bg-center"
         style="background-image: linear-gradient(180deg, rgba(239, 246, 255, 0.86) 0%, rgba(248, 250, 252, 0.92) 100%), url('{{ asset('images/news_mri_diagnostic.jpg') }}');">
        <div class="relative site-container py-3 sm:py-5 flex items-center justify-between gap-4">
            <!-- National Coat of Arms -->
            <div class="flex items-center shrink-0">
                <img src="{{ asset('images/coat_of_arms_tanzania.png') }}" alt="Coat of Arms of the United Republic of Tanzania" class="h-12 sm:h-16 lg:h-20 w-auto object-contain drop-shadow-sm">
            </div>

            <!-- National Institutional Header Text -->
            <div class="text-center flex-1 min-w-0">
                <span class="block text-xs sm:text-sm lg:text-base font-medium text-slate-700">
                    The United Republic of Tanzania
                </span>
                <span class="block font-heading font-extrabold text-sm sm:text-lg lg:text-xl text-navy-950 tracking-tight uppercase mt-0.5">
                    {{ __('hospital.hospital_name') }} ({{ __('hospital.hospital_type') }})
                </span>
            </div>

            <!-- Hospital Brand Logo -->
            <div class="flex items-center shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('hospital.hospital_name') }}" class="h-12 sm:h-16 lg:h-20 w-auto object-contain drop-shadow-sm">
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="border-b border-slate-200/90 bg-white sticky top-0 z-40 shadow-xs">
        <nav class="site-container py-2.5 sm:py-3 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group shrink-0 min-w-0">
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('hospital.hospital_name') }}" class="h-10 sm:h-12 w-auto object-contain shrink-0 group-hover:scale-105 transition">
                <div class="truncate max-w-[140px] xs:max-w-[220px] sm:max-w-xs lg:max-w-none">
                    <span class="block font-heading font-extrabold text-sm sm:text-base md:text-lg text-navy-950 tracking-tight leading-tight truncate">
                        {{ __('hospital.hospital_name') }}
                    </span>
                    <span class="hidden sm:block text-[11px] font-medium text-slate-500 tracking-wide truncate">
                        Excellence in Healthcare
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden xl:flex items-center gap-6 text-[13px] font-semibold text-slate-700">
                <a href="{{ route('home') }}" class="py-1 transition {{ request()->routeIs('home') ? 'text-hospital-700 border-b-2 border-hospital-600' : 'hover:text-hospital-700' }}">
                    Home
                </a>

                <!-- About Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>About</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('about') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700 font-medium">Hospital Overview</a>
                        <a href="{{ route('about.section', 'history') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">History & Milestones</a>
                        <a href="{{ route('about.section', 'mission-vision') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Mission & Vision</a>
                        <a href="{{ route('about.section', 'leadership') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Board & Leadership</a>
                        <a href="{{ route('about.section', 'organization') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Organization Structure</a>
                        <a href="{{ route('about.section', 'quality-and-safety') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Quality & Safety</a>
                    </div>
                </div>

                <!-- Services Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>Services</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('services.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700 font-medium">All Clinical Services</a>
                        <a href="{{ route('departments.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Clinical Departments</a>
                    </div>
                </div>

                <!-- Clinics / Doctors Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>Clinics</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('doctors.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Specialist Consultants</a>
                        <a href="{{ route('locations.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Outpatient Clinics & Campuses</a>
                    </div>
                </div>

                <!-- Resources Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>Resources</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('resources.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Downloadable Documents</a>
                        <a href="{{ route('tenders.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Tenders & Procurement</a>
                    </div>
                </div>

                <!-- News and Events Dropdown -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>News and Events</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('news.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">News & Editorial Bulletins</a>
                        <a href="{{ route('announcements.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Public Announcements</a>
                        <a href="{{ route('health-education.index') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Health Education</a>
                    </div>
                </div>

                <!-- Social Welfare / Patient Support -->
                <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
                    <button @mouseover="open = true" @click="open = !open" class="flex items-center gap-1 hover:text-hospital-700 transition py-1 focus:outline-none">
                        <span>Social Welfare</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="absolute left-0 mt-2 w-56 rounded-xl bg-white shadow-xl border border-slate-200 py-2 z-50">
                        <a href="{{ route('patients.section', 'visiting-hours') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Visiting Hours</a>
                        <a href="{{ route('patients.section', 'admission') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Admission Guidelines</a>
                        <a href="{{ route('patients.section', 'insurance') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Health Insurance (NHIF)</a>
                        <a href="{{ route('patients.section', 'faq') }}" class="block px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 hover:text-hospital-700">Patient FAQs</a>
                    </div>
                </div>

                <a href="{{ route('contact.index') }}" class="hover:text-hospital-700 transition">Contact</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-hospital-700 font-bold hover:underline">Staff Portal</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-hospital-700 transition">Staff Mail</a>
                @endauth
            </div>

            <!-- Header Action Button (Burgundy Appointments Button) & Mobile Hamburger -->
            <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                <a href="{{ route('search') }}" class="p-1.5 sm:p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition hidden sm:inline-flex" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </a>

                <!-- MNH Style Solid Red/Burgundy Appointments Button -->
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center justify-center px-2.5 sm:px-5 py-2 sm:py-2.5 rounded bg-hospital-600 hover:bg-hospital-700 text-white font-bold text-[11px] sm:text-sm tracking-wide shadow-xs transition duration-150 uppercase whitespace-nowrap">
                    Appointments
                </a>

                <!-- Mobile Menu Toggle Button -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-1.5 sm:p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Toggle navigation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Maroon / Burgundy Emergency Hotline & Social Strip (Screenshot 1) -->
        <div class="bg-gradient-to-r from-navy-800 via-navy-700 to-hospital-600 text-white py-1.5 sm:py-2">
            <div class="site-container grid grid-cols-1 sm:grid-cols-3 items-center gap-y-1.5 gap-x-3 text-xs font-medium">
                <!-- Left spacer keeps the hotline perfectly centered -->
                <div class="hidden sm:block"></div>

                <!-- Emergency Hotline (Centered) -->
                <div class="flex items-center justify-center gap-1.5 sm:gap-2 text-xs sm:text-sm">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-white shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z" />
                    </svg>
                    <span class="font-semibold">Emergency:</span>
                    <a href="tel:+255742448965" class="font-bold tracking-wide hover:underline whitespace-nowrap">+255742448965</a>
                </div>

                <!-- Social Icons & Language Switcher -->
                <div class="flex items-center justify-center sm:justify-end gap-3">
                    <div class="hidden sm:flex items-center gap-2 text-white">
                        <a href="mailto:info@ephamarcyhosp.com" class="h-6 w-6 rounded-full bg-white text-hospital-700 flex items-center justify-center hover:scale-110 transition" aria-label="Email">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" class="h-6 w-6 rounded-full bg-white text-hospital-700 flex items-center justify-center hover:scale-110 transition" aria-label="Facebook">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="h-6 w-6 rounded-full bg-white text-hospital-700 flex items-center justify-center hover:scale-110 transition" aria-label="Instagram">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" class="h-6 w-6 rounded-full bg-white text-hospital-700 flex items-center justify-center hover:scale-110 transition" aria-label="Twitter">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="h-6 w-6 rounded-full bg-white text-hospital-700 flex items-center justify-center hover:scale-110 transition" aria-label="YouTube">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>

                    <!-- Language Switcher Pill -->
                    <div class="flex items-center gap-1 bg-navy-950/30 rounded-md p-0.5 border border-white/30 text-[10px]">
                        <a href="{{ route('language.switch', 'en') }}" class="px-1.5 py-0.5 rounded font-bold {{ app()->getLocale() === 'en' ? 'bg-white text-hospital-700' : 'text-white' }}">EN</a>
                        <a href="{{ route('language.switch', 'sw') }}" class="px-1.5 py-0.5 rounded font-bold {{ app()->getLocale() === 'sw' ? 'bg-white text-hospital-700' : 'text-white' }}">SW</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div 
            x-show="mobileMenuOpen" 
            x-cloak 
            @click.outside="mobileMenuOpen = false"
            class="xl:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-8 space-y-2 max-h-[85vh] overflow-y-auto shadow-2xl"
        >
            <!-- Mobile Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="mb-3">
                <div class="relative">
                    <input 
                        type="search" 
                        name="q" 
                        placeholder="Search services, doctors, guides..." 
                        class="w-full text-xs rounded-xl border-slate-200 py-2.5 pl-9 pr-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-hospital-600/20 focus:border-hospital-600"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </form>

            <div class="grid grid-cols-2 gap-1 py-1 border-b border-slate-100 text-xs font-semibold">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50 {{ request()->routeIs('home') ? 'bg-hospital-50 text-hospital-700' : '' }}">Home</a>
                <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">About Hospital</a>
                <a href="{{ route('services.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Clinical Services</a>
                <a href="{{ route('departments.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Departments</a>
                <a href="{{ route('doctors.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Clinics & Doctors</a>
                <a href="{{ route('resources.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Downloads</a>
                <a href="{{ route('news.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">News & Events</a>
                <a href="{{ route('patients.section', 'visiting-hours') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Visiting Hours</a>
                <a href="{{ route('contact.index') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Contact Us</a>
                <a href="{{ route('appointments.track') }}" class="px-3 py-2 rounded-lg text-slate-800 hover:bg-slate-50">Track Booking</a>
            </div>

            <!-- Emergency Direct Call & Language in Mobile Drawer -->
            <div class="pt-2 flex items-center justify-between gap-2">
                <a href="tel:+255742448965" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg bg-hospital-50 border border-hospital-200 text-hospital-700 font-bold text-xs">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z" />
                    </svg>
                    <span>Emergency Hotline</span>
                </a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-lg bg-slate-900 text-white font-bold text-xs">Portal</a>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-semibold text-xs">Staff</a>
                @endauth
            </div>

            <div class="pt-2">
                <a href="{{ route('appointments.create') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded bg-hospital-600 hover:bg-hospital-700 text-white font-bold text-xs uppercase tracking-wider shadow-sm transition">
                    Book Appointment
                </a>
            </div>
        </div>
    </header>

    <!-- Global Notification Banner Messages -->
    @if(session('success'))
        <div class="bg-emerald-50 border-b border-emerald-200 text-emerald-900 px-4 py-3 text-sm flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 text-red-900 px-4 py-3 text-sm flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Professional Healthcare Footer with Diagnostic Photographic Suite (Screenshot 3) -->
    <div class="h-1 w-full bg-gradient-to-r from-hospital-600 via-navy-800 to-hospital-500"></div>
    <footer class="relative text-slate-200 overflow-hidden"
            style="background-image: linear-gradient(135deg, rgba(21, 60, 99, 0.94) 0%, rgba(9, 28, 49, 0.96) 100%), url('{{ asset('images/news_mri_diagnostic.jpg') }}'); background-size: cover; background-position: center;">
        
        <div class="site-container pt-12 lg:pt-16 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">
                
                <!-- Col 1: Location & Google Map Widget -->
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="h-7 w-7 rounded-md bg-white/10 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-heading font-extrabold text-base tracking-tight">Location</h4>
                    </div>

                    <!-- Map Card Widget with Interactive Google Map of Sombetini, Arusha -->
                    <div class="rounded-2xl overflow-hidden bg-white shadow-xl border border-white/20 p-2 text-slate-900 group">
                        <div class="relative h-44 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                            <!-- Real Google Maps Embed for Sombetini, Ukumbi wa Diwani, Arusha -->
                            <iframe 
                                title="Ephamarcy Hospital Location at Sombetini, Ukumbi wa Diwani, Arusha"
                                class="w-full h-full border-0" 
                                loading="lazy" 
                                allowfullscreen
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://maps.google.com/maps?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania&t=&z=16&ie=UTF8&iwloc=&output=embed">
                            </iframe>

                            <!-- Floating Map Badge -->
                            <div class="absolute top-2 left-2 z-10 pointer-events-auto">
                                <a href="https://maps.google.com/?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-white/95 backdrop-blur-xs text-[11px] font-bold text-navy-800 shadow-md border border-slate-200 hover:bg-white hover:text-hospital-700 transition">
                                    <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                                    <span>Sombetini, Ukumbi wa Diwani</span>
                                </a>
                            </div>
                        </div>

                        <!-- Location Subtitle Strip -->
                        <div class="p-2 pt-2.5 flex items-center justify-between text-xs">
                            <span class="font-semibold text-slate-800 text-[11px] truncate flex items-center gap-1">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 shrink-0"></span>
                                Sombetini (Ukumbi wa Diwani), Arusha
                            </span>
                            <a href="https://maps.google.com/?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania" target="_blank" rel="noopener" class="text-[11px] font-bold text-hospital-700 hover:text-hospital-900 transition flex items-center gap-0.5">
                                <span>Directions</span> &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Col 2: Contact Us & Emergency Box (Screenshot 3) -->
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="h-7 w-7 rounded-md bg-white/10 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-heading font-extrabold text-base tracking-tight">Contact Us</h4>
                    </div>

                    <div class="space-y-2.5 text-xs text-slate-200">
                        <p class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-hospital-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span class="font-semibold text-white">{{ \App\Models\HospitalSetting::get('hospital_name_' . app()->getLocale(), \App\Models\HospitalSetting::get('hospital_name_en', 'Ephamarcy Hospital')) }}</span>
                        </p>
                        <p class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-hospital-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span class="font-medium text-white">{{ \App\Models\HospitalSetting::get('address_' . app()->getLocale(), \App\Models\HospitalSetting::get('address_en', 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania')) }}</span>
                        </p>
                        <p class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-hospital-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            @php $officialEmail = \App\Models\HospitalSetting::get('official_email', 'info@ephamarcyhosp.com'); @endphp
                            <a href="mailto:{{ $officialEmail }}" class="hover:text-hospital-300 transition">{{ $officialEmail }}</a>
                        </p>
                        <p class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-hospital-300 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            @php $receptionPhone = \App\Models\HospitalSetting::get('reception_phone', '+255742448965'); @endphp
                            <a href="tel:{{ $receptionPhone }}" class="font-mono font-semibold hover:text-hospital-300 transition">{{ $receptionPhone }}</a>
                        </p>
                    </div>

                    <!-- Emergency Box (Screenshot 3) -->
                    @php $emergencyPhone = \App\Models\HospitalSetting::get('emergency_phone', '+255742448965'); @endphp
                    <div class="mt-4 p-3.5 rounded-xl bg-hospital-600/90 border border-hospital-300/40 backdrop-blur-xs text-white">
                        <div class="flex items-center gap-1.5 text-[10px] font-extrabold uppercase tracking-widest text-hospital-50">
                            <span class="h-1.5 w-1.5 rounded-full bg-white animate-ping"></span>
                            <span>* EMERGENCY</span>
                        </div>
                        <a href="tel:{{ $emergencyPhone }}" class="block text-base sm:text-lg font-mono font-black text-white hover:text-hospital-100 mt-0.5 tracking-wider">
                            {{ $emergencyPhone }}
                        </a>
                    </div>
                </div>

                <!-- Col 3: Quick Links (Screenshot 3) -->
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="h-7 w-7 rounded-md bg-white/10 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h4 class="font-heading font-extrabold text-base tracking-tight">Quick Links</h4>
                    </div>

                    <ul class="space-y-2 text-xs text-slate-200">
                        <li><a href="{{ route('contact.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Contact Us</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Clinics Schedule</a></li>
                        <li><a href="{{ route('services.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Services</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Staff Mail</a></li>
                        <li><a href="{{ route('locations.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Satellite Clinics</a></li>
                    </ul>

                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center gap-3 text-xs">
                        <a href="{{ route('about') }}" class="text-hospital-300 hover:text-white font-medium transition">See More</a>
                        <span class="text-white/30">&bull;</span>
                        <a href="{{ route('services.index') }}" class="text-hospital-300 hover:text-white font-bold flex items-center gap-1 transition">
                            <span>View All</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Col 4: Related Links (Screenshot 3) -->
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="h-7 w-7 rounded-md bg-white/10 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <h4 class="font-heading font-extrabold text-base tracking-tight">Related Links</h4>
                    </div>

                    <ul class="space-y-2 text-xs text-slate-200">
                        <li><a href="{{ route('resources.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Ethical Clearance Application</a></li>
                        <li><a href="{{ route('careers.index') }}" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Practical Training Application</a></li>
                        <li><a href="https://nest.go.tz" target="_blank" rel="noopener" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> NeST</a></li>
                        <li><a href="https://moh.go.tz" target="_blank" rel="noopener" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Ministry of Health</a></li>
                        <li><a href="https://ajira.go.tz" target="_blank" rel="noopener" class="hover:text-hospital-300 transition flex items-center gap-1.5"><span class="text-hospital-400 font-bold">&rsaquo;</span> Utumishi</a></li>
                    </ul>

                    <div class="mt-4 pt-3 border-t border-white/10 text-xs">
                        <a href="{{ route('resources.index') }}" class="text-hospital-300 hover:text-white font-medium transition">See More &rarr;</a>
                    </div>
                </div>

                <!-- Col 5: Visiting Hours (Screenshot 3) -->
                <div>
                    <div class="flex items-center gap-2 mb-4 text-white">
                        <div class="h-7 w-7 rounded-md bg-white/10 text-white flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-heading font-extrabold text-base tracking-tight">Visiting Hours</h4>
                    </div>

                    <!-- Weekdays -->
                    <div>
                        <span class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-2">WEEKDAYS</span>
                        <div class="space-y-1.5">
                            <div class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-xs text-xs font-semibold text-white flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-hospital-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>06:00AM - 07:00AM</span>
                            </div>
                            <div class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-xs text-xs font-semibold text-white flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-hospital-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>12:30PM - 02:00PM</span>
                            </div>
                            <div class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-xs text-xs font-semibold text-white flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-hospital-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>04:00PM - 06:00PM</span>
                            </div>
                        </div>
                    </div>

                    <!-- Weekend & Public Holidays -->
                    <div class="mt-4">
                        <span class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-2">WEEKEND & PUBLIC HOLIDAYS</span>
                        <div class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 backdrop-blur-xs text-xs font-semibold text-white flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-hospital-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>12:00PM - 02:00PM</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom Copyright & Social Strip (Screenshot 3) -->
        <div class="bg-navy-950 py-5 border-t border-white/10">
            <div class="site-container flex flex-col items-center justify-center gap-3 text-center">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} {{ \App\Models\HospitalSetting::get('hospital_name_' . app()->getLocale(), \App\Models\HospitalSetting::get('hospital_name_en', 'Ephamarcy Hospital')) }}. All rights reserved.
                </p>
                <!-- Social Icons Centered (Screenshot 3) -->
                <div class="flex items-center justify-center gap-2.5">
                    <a href="mailto:{{ \App\Models\HospitalSetting::get('official_email', 'info@ephamarcyhosp.com') }}" class="h-7 w-7 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-hospital-600 hover:text-white transition" aria-label="Email">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    </a>
                    <a href="{{ \App\Models\HospitalSetting::get('social_facebook', 'https://facebook.com') }}" target="_blank" rel="noopener" class="h-7 w-7 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-hospital-600 hover:text-white transition" aria-label="Facebook">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="{{ \App\Models\HospitalSetting::get('social_instagram', 'https://instagram.com') }}" target="_blank" rel="noopener" class="h-7 w-7 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-hospital-600 hover:text-white transition" aria-label="Instagram">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="{{ \App\Models\HospitalSetting::get('social_twitter', 'https://twitter.com') }}" target="_blank" rel="noopener" class="h-7 w-7 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-hospital-600 hover:text-white transition" aria-label="Twitter">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="{{ \App\Models\HospitalSetting::get('social_youtube', 'https://youtube.com') }}" target="_blank" rel="noopener" class="h-7 w-7 rounded-full bg-white/10 text-white flex items-center justify-center hover:bg-hospital-600 hover:text-white transition" aria-label="YouTube">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- =========================================================================
         FLOATING & HANGING AI CLINICAL CONCIERGE WIDGET
         ========================================================================= -->
    <div x-data="{
        isOpen: false,
        userQuery: '',
        loading: false,
        hasInteracted: false,
        messages: [
            {
                role: 'assistant',
                text: 'Hello! I am **Ephamarcy AI**, your 24/7 hospital concierge. Ask me anything about our medical specialists, booking appointments, 24/7 emergency unit, or visiting us in **Sombetini (Ukumbi wa Diwani), Arusha**!',
                actions: []
            }
        ],
        formatText(text) {
            if (!text) return '';
            return text
                .replace(/\*\*(.*?)\*\*/g, '<strong class=\'text-white font-semibold\'>$1</strong>')
                .replace(/\n/g, '<br>');
        },
        askPrompt(promptText) {
            this.userQuery = promptText;
            this.submitQuery();
        },
        async submitQuery() {
            const text = this.userQuery.trim();
            if (!text || this.loading) return;

            this.hasInteracted = true;
            this.messages.push({ role: 'user', text: text });
            this.userQuery = '';
            this.loading = true;

            this.$nextTick(() => {
                if (this.$refs.chatScroll) {
                    this.$refs.chatScroll.scrollTop = this.$refs.chatScroll.scrollHeight;
                }
            });

            try {
                const res = await fetch('{{ route('ai.ask') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ message: text })
                });
                const data = await res.json();
                if (data && data.success) {
                    this.messages.push({
                        role: 'assistant',
                        text: data.answer,
                        actions: data.actions || []
                    });
                } else {
                    this.messages.push({
                        role: 'assistant',
                        text: 'Thank you for reaching out! For direct help, contact our reception desk in Sombetini (Ukumbi wa Diwani), Arusha at +255742448965.',
                        actions: [{ label: 'Call Reception: +255742448965', url: 'tel:+255742448965' }]
                    });
                }
            } catch (e) {
                this.messages.push({
                    role: 'assistant',
                    text: 'Our team is ready to serve you. Please contact our 24/7 customer line at +255742448965 or visit our hospital in Sombetini (Ukumbi wa Diwani), Arusha.',
                    actions: [{ label: 'Call Hotline: +255742448965', url: 'tel:+255742448965' }]
                });
            } finally {
                this.loading = false;
                this.$nextTick(() => {
                    if (this.$refs.chatScroll) {
                        this.$refs.chatScroll.scrollTop = this.$refs.chatScroll.scrollHeight;
                    }
                });
            }
        }
    }">




        <!-- 3. Backdrop for Mobile Overlay -->
        <div 
            x-show="isOpen" 
            x-cloak
            @click="isOpen = false"
            x-transition:enter="transition-opacity ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-navy-950/40 backdrop-blur-xs z-50 md:hidden"
        ></div>

        <!-- 4. Interactive Floating AI Concierge Chat Dialog (Hanging Downwards from Top-Right) -->
        <div 
            x-show="isOpen"
            x-cloak
            @click.outside="isOpen = false"
            @keydown.escape.window="isOpen = false"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-8 scale-95"
            class="fixed top-16 sm:top-20 right-3 sm:right-6 z-50 w-[94vw] max-w-[460px] max-h-[calc(100vh-5.5rem)] flex flex-col rounded-3xl bg-slate-900/95 border border-hospital-400/40 shadow-2xl backdrop-blur-2xl overflow-hidden text-white"
        >
            <!-- Header Strip -->
            <div class="px-5 py-3.5 bg-navy-950/95 border-b border-slate-800 flex items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-hospital-600 to-hospital-400 text-white flex items-center justify-center font-black text-sm shadow-md">
                        ✨
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-heading font-extrabold text-sm text-white">Ephamarcy Smart Assistant</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Online 24/7</span>
                        </div>
                        <span class="text-[11px] text-slate-300 block">Sombetini (Ukumbi wa Diwani), Arusha &bull; English &amp; Swahili</span>
                    </div>
                </div>

                <!-- Close & Minimize Button -->
                <button 
                    @click="isOpen = false" 
                    type="button" 
                    class="h-8 w-8 rounded-full bg-white/10 hover:bg-white/20 text-slate-300 hover:text-white flex items-center justify-center transition focus:outline-none"
                    title="Close Assistant"
                    aria-label="Close"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Messages Window -->
            <div x-ref="chatScroll" class="flex-1 p-4 sm:p-5 space-y-3.5 overflow-y-auto scroll-smooth min-h-[220px] max-h-[360px]">
                <template x-for="(msg, mIdx) in messages" :key="mIdx">
                    <div class="flex flex-col gap-1.5" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                        <!-- Badge -->
                        <div class="flex items-center gap-1.5 text-[10px] text-slate-400 px-1">
                            <span x-text="msg.role === 'user' ? 'You' : 'Ephamarcy AI Concierge'"></span>
                        </div>

                        <!-- Chat Bubble -->
                        <div class="max-w-[88%] sm:max-w-md rounded-2xl p-3.5 text-xs sm:text-sm leading-relaxed shadow-sm"
                             :class="msg.role === 'user' 
                                 ? 'bg-hospital-600 text-white rounded-br-xs font-medium' 
                                 : 'bg-navy-950/90 border border-slate-800 text-slate-200 rounded-bl-xs'">
                            
                            <div x-html="formatText(msg.text)"></div>

                            <!-- Action Buttons if available -->
                            <template x-if="msg.actions && msg.actions.length > 0">
                                <div class="mt-3 pt-2.5 border-t border-white/10 flex flex-wrap gap-2">
                                    <template x-for="(act, aIdx) in msg.actions" :key="aIdx">
                                        <a :href="act.url" 
                                           :target="act.external ? '_blank' : '_self'"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition shadow-xs"
                                           :class="act.url && act.url.startsWith('tel:') 
                                               ? 'bg-red-600 hover:bg-red-700 text-white' 
                                               : 'bg-white/15 hover:bg-white/25 text-white border border-white/20'">
                                            <span x-text="act.label"></span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Loading Typing Indicator -->
                <div x-show="loading" x-cloak class="flex items-center gap-2 text-xs text-hospital-300 bg-navy-950/90 px-3.5 py-2 rounded-2xl border border-slate-800 w-fit">
                    <span class="inline-flex gap-1">
                        <span class="h-2 w-2 rounded-full bg-cyan-400 animate-bounce"></span>
                        <span class="h-2 w-2 rounded-full bg-cyan-400 animate-bounce [animation-delay:0.2s]"></span>
                        <span class="h-2 w-2 rounded-full bg-cyan-400 animate-bounce [animation-delay:0.4s]"></span>
                    </span>
                    <span>Consulting Ephamarcy hospital knowledge base...</span>
                </div>
            </div>

            <!-- Quick Suggestion Prompt Chips -->
            <div class="px-4 py-2 bg-navy-950/70 border-t border-slate-800/80 flex items-center gap-1.5 overflow-x-auto scrollbar-none shrink-0">
                <span class="text-[9px] font-bold uppercase tracking-wider text-slate-400 shrink-0">Suggestions:</span>
                
                <button type="button" @click="askPrompt('Where is Ephamarcy Hospital located near Ukumbi wa Diwani, Sombetini?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    📍 Sombetini (Ukumbi wa Diwani)
                </button>
                <button type="button" @click="askPrompt('When can I see a cardiologist?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    🩺 Cardiologist schedules
                </button>
                <button type="button" @click="askPrompt('What are the patient visiting hours?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    🕒 Visiting hours
                </button>
                <button type="button" @click="askPrompt('How do I book an outpatient appointment?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    📅 Book appointment
                </button>
                <button type="button" @click="askPrompt('Do you accept NHIF and insurance?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    💳 Insurance & NHIF
                </button>
                <button type="button" @click="askPrompt('Are emergency and ambulance services available 24/7?')" class="shrink-0 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 hover:border-hospital-500 transition">
                    🚨 24/7 Emergency care
                </button>
            </div>

            <!-- Input Bar -->
            <form @submit.prevent="submitQuery()" class="p-3 bg-navy-950 border-t border-slate-800 flex items-center gap-2 shrink-0">
                <input 
                    type="text" 
                    x-model="userQuery" 
                    placeholder="Ask me anything... (e.g. Where in Arusha?)" 
                    class="flex-1 bg-slate-900 border border-slate-700 text-white placeholder:text-slate-500 text-xs sm:text-sm rounded-2xl px-3.5 py-2.5 focus:outline-none focus:border-hospital-500 focus:ring-1 focus:ring-hospital-500 transition"
                    :disabled="loading"
                />

                <button 
                    type="submit" 
                    :disabled="loading || !userQuery.trim()" 
                    class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-hospital-600 to-hospital-500 hover:from-hospital-500 hover:to-hospital-400 disabled:opacity-40 disabled:cursor-not-allowed text-white font-bold text-xs shadow-md transition flex items-center gap-1.5 shrink-0"
                >
                    <span>Ask</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </button>
            </form>

            <!-- Bottom Disclaimer Strip -->
            <div class="px-4 py-2 bg-navy-950 text-[10px] text-slate-400 border-t border-slate-800/60 flex flex-col sm:flex-row items-center justify-between gap-1 text-center sm:text-left shrink-0">
                <span>Ephamarcy AI provides clinic guidance & hospital navigation in Sombetini (Ukumbi wa Diwani), Arusha.</span>
                <span class="text-slate-400 font-medium">Emergency: <a href="tel:+255742448965" class="text-red-400 font-bold hover:underline">+255 742 448 965</a></span>
            </div>
        </div>

        <!-- Floating Customer WhatsApp & Ask AI Buttons in Bottom-Right Corner -->
        @php 
            $whatsappNumber = \App\Models\HospitalSetting::get('whatsapp_phone', '255742448965');
            $hospitalName = \App\Models\HospitalSetting::get('hospital_name_' . app()->getLocale(), \App\Models\HospitalSetting::get('hospital_name_en', 'Ephamarcy Hospital'));
        @endphp
        <aside aria-label="Support & AI Concierge" class="fixed bottom-5 sm:bottom-6 right-4 sm:right-6 z-40 flex flex-col xs:flex-row items-end xs:items-center gap-2 sm:gap-2.5">
            <!-- Ask Ephamarcy AI Floating Button (like WhatsApp) -->
            <button 
                @click="isOpen = !isOpen"
                type="button"
                class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-gradient-to-r from-hospital-600 via-hospital-700 to-navy-900 hover:from-hospital-500 hover:to-hospital-800 text-white font-heading font-bold text-xs shadow-2xl hover:scale-105 transition duration-200 border border-white/20 group cursor-pointer"
                title="Ask Ephamarcy AI Concierge"
            >
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-300 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-cyan-400"></span>
                </span>
                <span class="text-sm">✨</span>
                <span>Ask Ephamarcy AI</span>
            </button>

            <!-- WhatsApp Us Button -->
            <a 
                href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode('Hello ' . $hospitalName . ', I would like to inquire about healthcare services.') }}" 
                target="_blank" 
                rel="noopener noreferrer"
                class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-bold text-xs shadow-2xl hover:scale-105 transition duration-200 border border-white/20 group"
                title="Chat with Customer Care on WhatsApp"
            >
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-200 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                </span>
                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                <span class="hidden sm:inline">WhatsApp Us</span>
            </a>
        </aside>

    </div>
</body>
</html>

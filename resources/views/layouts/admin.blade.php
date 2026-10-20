<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Console') — {{ __('hospital.hospital_name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex antialiased font-sans text-slate-800" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar Navigation -->
    <aside 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-950 text-slate-200 flex flex-col transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-auto"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <!-- Sidebar Brand Header -->
        <div class="h-16 flex items-center justify-between px-6 border-b border-navy-900">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Ephamarcy Hospital" class="h-9 w-auto object-contain bg-white/95 rounded-lg p-0.5 shadow-sm">
                <div>
                    <span class="block font-heading font-bold text-white text-base leading-tight">Ephamarcy</span>
                    <span class="block text-[10px] text-hospital-400 font-medium uppercase tracking-wider">Hospital Admin</span>
                </div>
            </div>
            <!-- Mobile Close Button -->
            <button type="button" @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1.5 rounded-lg focus:outline-none" aria-label="Close sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a 
                href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>{{ __('hospital.nav.dashboard') }}</span>
            </a>

            <div class="pt-3 pb-1">
                <span class="px-3 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Patient CRM & Outreach</span>
            </div>

            <a 
                href="{{ route('admin.appointments.index') }}" 
                class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.appointments.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.appointments.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Appointments CRM</span>
                </div>
                @php
                    $pendingCount = \App\Models\AppointmentRequest::where('status', 'pending')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full bg-emergency-600 text-white">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>

            <a 
                href="{{ route('admin.inquiries.index') }}" 
                class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.inquiries.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>Inquiries CRM</span>
                </div>
                @php
                    $newInquiries = \App\Models\ContactInquiry::where('status', 'new')->count();
                @endphp
                @if($newInquiries > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold rounded-full bg-hospital-500 text-slate-950">
                        {{ $newInquiries }}
                    </span>
                @endif
            </a>

            <div class="pt-4 pb-2">
                <span class="px-3 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Clinical Management</span>
            </div>

            <a 
                href="{{ route('admin.departments.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.departments.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.departments.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Departments</span>
            </a>

            <a 
                href="{{ route('admin.services.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.services.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.services.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <span>Clinical Services</span>
            </a>

            <a 
                href="{{ route('admin.doctors.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.doctors.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.doctors.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Specialists & Faculty</span>
            </a>

            <div class="pt-4 pb-2">
                <span class="px-3 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Editorial & Content</span>
            </div>

            <a 
                href="{{ route('admin.health-education.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.health-education.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.health-education.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Health Education Hub</span>
            </a>

            <a 
                href="{{ route('admin.news.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.news.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.news.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Bulletins & Notices</span>
            </a>

            <a 
                href="{{ route('admin.resources.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.resources.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.resources.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>Patient Documents</span>
            </a>

            <a 
                href="{{ route('admin.careers.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.careers.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.careers.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Careers & Vacancies</span>
            </a>

            <div class="pt-4 pb-2">
                <span class="px-3 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">Hospital Operations & Setup</span>
            </div>

            <a 
                href="{{ route('admin.homepage.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.homepage.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.homepage.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                <span>Homepage Materials</span>
            </a>

            <a 
                href="{{ route('admin.locations.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.locations.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.locations.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Campuses & Branches</span>
            </a>

            <a 
                href="{{ route('admin.faqs.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.faqs.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.faqs.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>FAQs (How do I?)</span>
            </a>

            <a 
                href="{{ route('admin.users.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Staff & Security Roles</span>
            </a>

            <a 
                href="{{ route('admin.settings.index') }}" 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-hospital-700 text-white shadow-sm' : 'text-slate-300 hover:bg-navy-900 hover:text-white' }}"
            >
                <svg class="w-5 h-5 {{ request()->routeIs('admin.settings.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Hospital Settings</span>
            </a>

            <div class="pt-6 pb-2">
                <span class="px-3 text-[11px] font-semibold tracking-wider text-slate-400 uppercase">External Navigation</span>
            </div>

            <a 
                href="{{ route('home') }}" 
                target="_blank"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-400 hover:bg-navy-900 hover:text-slate-200 transition"
            >
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>View Public Site</span>
            </a>
        </nav>

        <!-- Current User Info & Logout -->
        <div class="p-4 border-t border-navy-900 bg-navy-900/40">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <div class="h-8 w-8 rounded-full bg-hospital-600/30 text-hospital-300 border border-hospital-500/40 flex items-center justify-center font-bold text-xs shrink-0">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="truncate">
                        <span class="block text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Staff User' }}</span>
                        <span class="block text-[10px] uppercase font-bold text-hospital-400">{{ auth()->user()->role ?? 'staff' }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-slate-800 hover:bg-red-950 text-slate-300 hover:text-red-300 border border-slate-700/80 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Shell Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Admin Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-2xs">
            <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-sm sm:text-lg font-heading font-bold text-slate-900 truncate">
                    @yield('header', 'Admin Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Language Switcher in Admin Header -->
                <div class="flex items-center gap-1 bg-slate-100 rounded-md p-0.5 border border-slate-200 text-xs">
                    <a href="{{ route('language.switch', 'en') }}" class="px-2 py-0.5 rounded font-semibold transition {{ app()->getLocale() === 'en' ? 'bg-white shadow-2xs text-hospital-800' : 'text-slate-600 hover:text-slate-900' }}">
                        EN
                    </a>
                    <a href="{{ route('language.switch', 'sw') }}" class="px-2 py-0.5 rounded font-semibold transition {{ app()->getLocale() === 'sw' ? 'bg-white shadow-2xs text-hospital-800' : 'text-slate-600 hover:text-slate-900' }}">
                        SW
                    </a>
                </div>

                <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                <span class="hidden xs:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-hospital-50 text-hospital-700 border border-hospital-200 shrink-0">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    System Live
                </span>
            </div>
        </header>

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                <x-alert type="success" title="Success">
                    {{ session('success') }}
                </x-alert>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                <x-alert type="error" title="Notice">
                    {{ session('error') }}
                </x-alert>
            </div>
        @endif

        <!-- Admin View Body -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>

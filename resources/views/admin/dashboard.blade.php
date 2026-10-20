@extends('layouts.admin')

@section('header', __('hospital.admin.title'))

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-hospital-800 via-hospital-700 to-navy-900 rounded-2xl p-6 sm:p-8 text-white shadow-soft relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-hospital-200 backdrop-blur-xs border border-white/10 mb-3">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Ephamarcy Hospital Administration &bull; Live System
            </span>
            <h2 class="text-2xl sm:text-3xl font-heading font-extrabold tracking-tight">
                {{ __('hospital.admin.welcome', ['name' => auth()->user()->name]) }}
            </h2>
            <p class="mt-2 text-hospital-100/90 text-sm sm:text-base leading-relaxed">
                Hospital triage center, patient appointment management, and departmental records overview.
            </p>
        </div>
        <!-- Decorative abstract pattern -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Metric 1: Pending Appointments -->
        <x-card padding="p-5" class="border-l-4 border-l-emergency-500">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pending Requests</span>
                <span class="p-2 rounded-lg bg-red-50 text-emergency-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-heading font-black text-slate-900">{{ $stats['pending_appointments'] }}</span>
                <span class="text-xs text-slate-500 block mt-1">Awaiting staff confirmation</span>
            </div>
        </x-card>

        <!-- Metric 2: Total Appointments -->
        <x-card padding="p-5" class="border-l-4 border-l-hospital-500">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">All Appointments</span>
                <span class="p-2 rounded-lg bg-hospital-50 text-hospital-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-heading font-black text-slate-900">{{ $stats['total_appointments'] }}</span>
                <span class="text-xs text-slate-500 block mt-1">Total requests recorded</span>
            </div>
        </x-card>

        <!-- Metric 3: Patient Inquiries -->
        <x-card padding="p-5" class="border-l-4 border-l-navy-500">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Contact Inquiries</span>
                <span class="p-2 rounded-lg bg-navy-50 text-navy-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-heading font-black text-slate-900">{{ $stats['total_inquiries'] }}</span>
                <span class="text-xs text-slate-500 block mt-1">{{ $stats['new_inquiries'] }} unread / new messages</span>
            </div>
        </x-card>

        <!-- Metric 4: Doctors & Departments -->
        <x-card padding="p-5" class="border-l-4 border-l-navy-600">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Clinical Capacity</span>
                <span class="p-2 rounded-lg bg-slate-100 text-navy-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </span>
            </div>
            <div class="mt-3">
                <span class="text-3xl font-heading font-black text-slate-900">{{ $stats['total_doctors'] }}</span>
                <span class="text-xs text-slate-500 block mt-1">Specialists across {{ $stats['total_departments'] }} departments</span>
            </div>
        </x-card>
    </div>

    <!-- Quick Operations Navigation Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
        <a href="{{ route('admin.departments.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-hospital-50 text-hospital-700 flex items-center justify-center group-hover:bg-hospital-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Departments</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_departments'] }} active</span>
        </a>

        <a href="{{ route('admin.doctors.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center group-hover:bg-teal-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Specialists</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_doctors'] }} doctors</span>
        </a>

        <a href="{{ route('admin.services.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center group-hover:bg-sky-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Services</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_services'] }} clinical</span>
        </a>

        <a href="{{ route('admin.health-education.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Health Hub</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_health_articles'] }} guides</span>
        </a>

        <a href="{{ route('admin.careers.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center group-hover:bg-indigo-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Vacancies</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_careers'] }} open</span>
        </a>

        <a href="{{ route('admin.news.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-red-50 text-red-700 flex items-center justify-center group-hover:bg-red-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Bulletins</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_news'] }} news</span>
        </a>

        <a href="{{ route('admin.resources.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center group-hover:bg-amber-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Documents</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_resources'] }} files</span>
        </a>

        <a href="{{ route('admin.users.index') }}" class="p-3 bg-white rounded-xl border border-slate-200/80 shadow-2xs hover:border-hospital-500 hover:shadow-xs transition text-center group">
            <div class="h-8 w-8 mx-auto rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center group-hover:bg-purple-700 group-hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <span class="block text-xs font-semibold text-slate-800 mt-2">Accounts</span>
            <span class="block text-[10px] text-slate-400 font-mono">{{ $stats['total_staff'] }} staff</span>
        </a>
    </div>

    <!-- Data Tables: Appointments & Inquiries -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Appointments (2 cols) -->
        <div class="lg:col-span-2">
            <x-card padding="p-0">
                <div class="p-4 xs:p-6 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">
                            {{ __('hospital.admin.recent_appointments') }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Direct triage queue</p>
                    </div>
                    <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-hospital-700 hover:text-hospital-900 transition">
                        View All Appointments &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[650px] text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-500 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Ref / Patient</th>
                                <th class="px-6 py-3 font-semibold">Department / Doctor</th>
                                <th class="px-6 py-3 font-semibold">Date & Time</th>
                                <th class="px-6 py-3 font-semibold">Status</th>
                                <th class="px-6 py-3 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentAppointments as $apt)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-mono text-xs font-bold text-hospital-800">{{ $apt->reference_number }}</div>
                                        <div class="font-medium text-slate-900">{{ $apt->patient_name }}</div>
                                        <div class="text-xs text-slate-400">{{ $apt->patient_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">{{ $apt->department->name ?? 'General Consultation' }}</div>
                                        <div class="text-xs text-slate-500">{{ $apt->doctor->name ?? 'Unassigned Specialist' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-medium text-slate-900">{{ $apt->preferred_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-slate-500">{{ $apt->preferred_time }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($apt->status === 'pending')
                                            <x-badge color="emergency" size="xs" :pulse="true">Pending</x-badge>
                                        @elseif($apt->status === 'confirmed')
                                            <x-badge color="emerald" size="xs">Confirmed</x-badge>
                                        @elseif($apt->status === 'completed')
                                            <x-badge color="navy" size="xs">Completed</x-badge>
                                        @else
                                            <x-badge color="slate" size="xs">Cancelled</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.appointments.index') }}" class="text-xs font-semibold text-hospital-700 hover:underline">
                                            Manage
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-xs">
                                        No appointment requests yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Recent Inquiries (1 col) -->
        <div class="lg:col-span-1">
            <x-card padding="p-0">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-heading font-bold text-slate-900">
                            {{ __('hospital.admin.recent_inquiries') }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Visitor messages</p>
                    </div>
                    <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-semibold text-hospital-700 hover:text-hospital-900 transition">
                        All &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($recentInquiries as $inq)
                        <div class="p-5 hover:bg-slate-50/70 transition">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-sm text-slate-900">{{ $inq->name }}</span>
                                <span class="text-[10px] text-slate-400">{{ $inq->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="text-xs font-semibold text-hospital-800 mb-1 truncate">{{ $inq->subject }}</div>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">{{ $inq->message }}</p>
                            <div class="mt-2.5 flex items-center justify-between">
                                <span class="text-[11px] text-slate-400 font-mono">{{ $inq->email }}</span>
                                @if($inq->status === 'new')
                                    <x-badge color="hospital" size="xs">New</x-badge>
                                @else
                                    <x-badge color="slate" size="xs">{{ ucfirst($inq->status) }}</x-badge>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400">
                            No contact inquiries recorded.
                        </div>
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection

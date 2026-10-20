@extends('layouts.public')

@section('title', 'Staff Portal Login — ' . __('hospital.hospital_name'))

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-slate-50 via-hospital-50/20 to-slate-100">
    <div class="max-w-md w-full space-y-8">
        <!-- Login Card Header -->
        <div class="text-center">
            <div class="mx-auto h-14 w-14 rounded-2xl bg-gradient-to-tr from-hospital-800 to-hospital-600 text-white flex items-center justify-center shadow-lg shadow-hospital-900/20 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="font-heading font-extrabold text-2xl sm:text-3xl text-navy-950 tracking-tight">
                Staff & Admin Portal
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                Authorized clinical and administrative access only
            </p>
        </div>

        <x-card padding="p-5 xs:p-6 sm:p-8" class="shadow-card border-slate-200">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <x-input 
                    label="Official Email Address" 
                    name="email" 
                    type="email" 
                    placeholder="e.g. admin@ephamarcyhosp.com" 
                    required 
                    autocomplete="email"
                />

                <!-- Password Input -->
                <x-input 
                    label="Password" 
                    name="password" 
                    type="password" 
                    placeholder="••••••••••••" 
                    required 
                    autocomplete="current-password"
                />

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-hospital-700 focus:ring-hospital-500 h-4 w-4">
                        <span class="text-slate-600 text-xs font-medium">Keep me signed in</span>
                    </label>
                </div>

                <div>
                    <x-button type="submit" variant="primary" size="lg" class="w-full">
                        Secure Sign In
                    </x-button>
                </div>
            </form>

            <!-- Security Notice -->
            <div class="mt-8 pt-4 border-t border-slate-100 -mx-5 xs:-mx-6 sm:-mx-8 -mb-5 xs:-mb-6 sm:-mb-8 p-4 xs:p-5 sm:p-6 bg-slate-50/60 rounded-b-2xl flex items-center gap-2.5 text-slate-500 text-xs">
                <svg class="w-4 h-4 text-hospital-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Protected by Ephamarcy Hospital IT & Healthcare Security Protocol. Authorized medical & administrative personnel only.</span>
            </div>
        </x-card>
    </div>
</div>
@endsection

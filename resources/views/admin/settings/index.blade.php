@extends('layouts.admin')

@section('title', 'Hospital Identity & Settings')
@section('header', 'Hospital Identity & Configuration Settings')

@section('content')
<div class="space-y-6" x-data="{ activeTab: 'general' }">

    <!-- Top Overview Banner -->
    <div class="bg-gradient-to-r from-navy-950 via-navy-900 to-hospital-800 rounded-2xl p-6 sm:p-8 text-white shadow-soft relative overflow-hidden">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-hospital-200 backdrop-blur-xs border border-white/10 mb-3">
                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                Central Hospital Configuration Console
            </span>
            <h2 class="text-2xl sm:text-3xl font-heading font-extrabold tracking-tight">
                Hospital Identity & Operations
            </h2>
            <p class="mt-2 text-hospital-100/90 text-xs sm:text-sm leading-relaxed">
                Manage official institutional branding, 24/7 emergency hotlines, OPD consultation hours, patient visiting schedules, and digital presence across the web portal.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-56 h-56 rounded-full bg-white/5 pointer-events-none"></div>
    </div>

    <!-- Configuration Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Tabs Navigation -->
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-2xs flex flex-wrap items-center gap-1.5">
            <button 
                type="button" 
                @click="activeTab = 'general'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition"
                :class="activeTab === 'general' ? 'bg-hospital-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>General Identity</span>
            </button>

            <button 
                type="button" 
                @click="activeTab = 'contacts'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition"
                :class="activeTab === 'contacts' ? 'bg-hospital-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>Emergency & Contacts</span>
            </button>

            <button 
                type="button" 
                @click="activeTab = 'hours'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition"
                :class="activeTab === 'hours' ? 'bg-hospital-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Clinical & Visiting Hours</span>
            </button>

            <button 
                type="button" 
                @click="activeTab = 'social'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition"
                :class="activeTab === 'social' ? 'bg-hospital-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span>Social & Online Presence</span>
            </button>

            <button 
                type="button" 
                @click="activeTab = 'branding'"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold transition"
                :class="activeTab === 'branding' ? 'bg-hospital-700 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                <span>Branding & Logo</span>
            </button>

            <div class="ml-auto">
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-sm transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save All Changes</span>
                </button>
            </div>
        </div>

        <!-- Tab 1: General Identity -->
        <div x-show="activeTab === 'general'" x-cloak class="space-y-6">
            <x-card padding="p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-heading font-bold text-slate-900">Hospital Institutional Identity</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Primary nomenclature and bilingual brand presentation.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Hospital Name (English) *</label>
                        <x-input name="hospital_name_en" value="{{ old('hospital_name_en', $settings['hospital_name_en']) }}" required />
                        <span class="text-[11px] text-slate-400 mt-1 block">Main name displayed across header, title tags, and legal documentation.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Hospital Name (Swahili)</label>
                        <x-input name="hospital_name_sw" value="{{ old('hospital_name_sw', $settings['hospital_name_sw']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">Displayed when visitors switch portal locale to Kiswahili.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Hospital Tagline / Motto (English)</label>
                        <x-input name="tagline_en" value="{{ old('tagline_en', $settings['tagline_en']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. Excellence in Healthcare, Compassion in Healing</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Hospital Tagline / Motto (Swahili)</label>
                        <x-input name="tagline_sw" value="{{ old('tagline_sw', $settings['tagline_sw']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. Ubora katika Huduma za Afya, Huruma katika Uponyaji</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Classification / Institutional Category (EN)</label>
                        <x-input name="hospital_type_en" value="{{ old('hospital_type_en', $settings['hospital_type_en']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. Specialized Medical & Healthcare Center</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Classification / Institutional Category (SW)</label>
                        <x-input name="hospital_type_sw" value="{{ old('hospital_type_sw', $settings['hospital_type_sw']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. Kituo cha Ubingwa wa Afya na Matibabu</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Footer Overview Summary (English)</label>
                        <x-textarea name="about_short_en" rows="3">{{ old('about_short_en', $settings['about_short_en']) }}</x-textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Footer Overview Summary (Swahili)</label>
                        <x-textarea name="about_short_sw" rows="3">{{ old('about_short_sw', $settings['about_short_sw']) }}</x-textarea>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Tab 2: Emergency & Contacts -->
        <div x-show="activeTab === 'contacts'" x-cloak class="space-y-6">
            <x-card padding="p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-emergency-600 animate-ping"></span>
                        <h3 class="text-base font-heading font-bold text-slate-900">Emergency Hotlines & Contact Information</h3>
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">Critical telephone lines shown in urgent alert banners, public footers, and contact hubs.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Emergency Hotline -->
                    <div class="p-4 rounded-xl bg-red-50/70 border border-red-200">
                        <label class="block text-xs font-bold text-emergency-700 mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emergency-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span>24/7 Emergency Line *</span>
                        </label>
                        <x-input name="emergency_phone" value="{{ old('emergency_phone', $settings['emergency_phone']) }}" class="font-mono font-bold" required />
                        <span class="text-[10px] text-emergency-600 mt-1 block">Displayed in high-priority red badges throughout the portal.</span>
                    </div>

                    <!-- Reception / Switchboard -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1">General Switchboard / Reception</label>
                        <x-input name="reception_phone" value="{{ old('reception_phone', $settings['reception_phone']) }}" class="font-mono" />
                        <span class="text-[10px] text-slate-400 mt-1 block">Main hospital inquiries desk phone.</span>
                    </div>

                    <!-- Ambulance Dispatch -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ambulance Dispatch Line</label>
                        <x-input name="ambulance_phone" value="{{ old('ambulance_phone', $settings['ambulance_phone']) }}" class="font-mono" />
                        <span class="text-[10px] text-slate-400 mt-1 block">Direct fleet line for trauma and emergency ambulance.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Official Inquiries Email *</label>
                        <x-input type="email" name="official_email" value="{{ old('official_email', $settings['official_email']) }}" required />
                        <span class="text-[11px] text-slate-400 mt-1 block">Receives notification copies of patient contact forms.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">WhatsApp Customer Care Number</label>
                        <x-input name="whatsapp_phone" value="{{ old('whatsapp_phone', $settings['whatsapp_phone']) }}" placeholder="e.g. 255742448965" />
                        <span class="text-[11px] text-slate-400 mt-1 block">Include international country code without plus sign (for wa.me links).</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">P.O. Box & Postal Code</label>
                        <x-input name="po_box" value="{{ old('po_box', $settings['po_box']) }}" placeholder="e.g. PO Box 65000 Dar es Salaam" />
                        <span class="text-[11px] text-slate-400 mt-1 block">Official postal registry address.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-slate-100">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Physical Campus Address (English)</label>
                        <x-textarea name="address_en" rows="2">{{ old('address_en', $settings['address_en']) }}</x-textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Physical Campus Address (Swahili)</label>
                        <x-textarea name="address_sw" rows="2">{{ old('address_sw', $settings['address_sw']) }}</x-textarea>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Google Maps Embed URL / Iframe src</label>
                    <x-input name="google_maps_embed" value="{{ old('google_maps_embed', $settings['google_maps_embed']) }}" placeholder="https://www.google.com/maps/embed?pb=..." />
                    <span class="text-[11px] text-slate-400 mt-1 block">Paste embed link from Google Maps to display on Contact & Locations pages.</span>
                </div>
            </x-card>
        </div>

        <!-- Tab 3: Clinical & Visiting Hours -->
        <div x-show="activeTab === 'hours'" x-cloak class="space-y-6">
            <x-card padding="p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-heading font-bold text-slate-900">Hospital Operating & Visiting Hours</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Schedules displayed in public banners, OPD booking modules, and patient ward guidance.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Accident & Emergency Operating Hours</label>
                        <x-input name="working_hours_emergency" value="{{ old('working_hours_emergency', $settings['working_hours_emergency']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. 24/7 Everyday Resuscitation & Emergency Unit</span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Outpatient (OPD) Consultation Hours</label>
                        <x-input name="working_hours_opd" value="{{ old('working_hours_opd', $settings['working_hours_opd']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. Monday - Sunday, 07:30 - 20:00</span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Inpatient Ward Visiting Hours (Weekdays)</label>
                        <x-input name="visiting_hours_weekdays" value="{{ old('visiting_hours_weekdays', $settings['visiting_hours_weekdays']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. 06:00AM - 07:00AM | 12:30PM - 02:00PM | 04:00PM - 06:00PM</span>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-800 mb-1">Inpatient Ward Visiting Hours (Weekends & Holidays)</label>
                        <x-input name="visiting_hours_weekends" value="{{ old('visiting_hours_weekends', $settings['visiting_hours_weekends']) }}" />
                        <span class="text-[11px] text-slate-400 mt-1 block">e.g. 12:00PM - 02:00PM</span>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Tab 4: Social & Online Presence -->
        <div x-show="activeTab === 'social'" x-cloak class="space-y-6">
            <x-card padding="p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-heading font-bold text-slate-900">Official Social Media & Channels</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Social channels linked in website footer and announcement bulletins.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-blue-600"></span>
                            <span>Facebook Page URL</span>
                        </label>
                        <x-input name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']) }}" placeholder="https://facebook.com/..." />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-slate-900"></span>
                            <span>Twitter / X Handle or URL</span>
                        </label>
                        <x-input name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter']) }}" placeholder="https://x.com/..." />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-pink-600"></span>
                            <span>Instagram Profile URL</span>
                        </label>
                        <x-input name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/..." />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-red-600"></span>
                            <span>YouTube Channel URL</span>
                        </label>
                        <x-input name="social_youtube" value="{{ old('social_youtube', $settings['social_youtube']) }}" placeholder="https://youtube.com/..." />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-sky-700"></span>
                            <span>LinkedIn Institutional Page</span>
                        </label>
                        <x-input name="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin']) }}" placeholder="https://linkedin.com/company/..." />
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Tab 5: Branding & Logo -->
        <div x-show="activeTab === 'branding'" x-cloak class="space-y-6">
            <x-card padding="p-6 sm:p-8">
                <div class="border-b border-slate-100 pb-4 mb-6">
                    <h3 class="text-base font-heading font-bold text-slate-900">Hospital Brand Assets & Palette</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Customize corporate brand palette and public emblem.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Brand Colors -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Brand Color Hex Tokens</h4>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Primary Brand Color (Navy)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="primary_color_picker" :value="'{{ $settings['primary_color'] }}'" @input="$refs.primaryInput.value = $event.target.value" class="h-10 w-12 rounded-lg cursor-pointer border border-slate-300 p-0.5" />
                                <input x-ref="primaryInput" type="text" name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}" class="text-xs rounded-xl border-slate-300 py-2.5 px-3 font-mono text-slate-800 uppercase focus:border-hospital-500 focus:ring-hospital-500 w-36" />
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Default: #153C63 (Institutional Navy Blue)</span>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Accent Brand Color (Orange / Coral)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="accent_color_picker" :value="'{{ $settings['accent_color'] }}'" @input="$refs.accentInput.value = $event.target.value" class="h-10 w-12 rounded-lg cursor-pointer border border-slate-300 p-0.5" />
                                <input x-ref="accentInput" type="text" name="accent_color" value="{{ old('accent_color', $settings['accent_color']) }}" class="text-xs rounded-xl border-slate-300 py-2.5 px-3 font-mono text-slate-800 uppercase focus:border-hospital-500 focus:ring-hospital-500 w-36" />
                            </div>
                            <span class="text-[11px] text-slate-400 mt-1 block">Default: #F78A49 (Medical Warm Orange)</span>
                        </div>
                    </div>

                    <!-- Logo Upload & Preview -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">Hospital Brand Logo</h4>
                        
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-5">
                            <div class="h-16 w-16 rounded-xl bg-white p-2 border border-slate-200 shadow-2xs flex items-center justify-center shrink-0">
                                <img src="{{ asset($settings['logo_path']) }}" alt="Hospital Logo" class="max-h-full max-w-full object-contain" />
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-slate-800">Current Logo Asset</span>
                                <span class="block text-[11px] text-slate-400 font-mono mt-0.5 truncate max-w-xs">{{ $settings['logo_path'] }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Upload New Logo (PNG, WebP, or SVG)</label>
                            <input type="file" name="logo_file" accept="image/*" class="text-xs text-slate-600 file:mr-4 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-hospital-50 file:text-hospital-700 hover:file:bg-hospital-100" />
                            <span class="text-[11px] text-slate-400 mt-1 block">Transparent background PNG or vector SVG recommended (max 2MB).</span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sticky Floating Bottom Save Bar -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md rounded-2xl p-4 border border-slate-200 shadow-xl flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span>Changes will be immediately synchronized across all public portal pages.</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-hospital-700 hover:bg-hospital-800 text-white font-bold text-xs shadow-md hover:shadow-lg transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Save All Configuration</span>
                </button>
            </div>
        </div>

    </form>

</div>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the hospital identity and configuration console.
     */
    public function index(): View
    {
        $settings = [
            // General Identity
            'hospital_name_en' => HospitalSetting::get('hospital_name_en', 'Ephamarcy Hospital'),
            'hospital_name_sw' => HospitalSetting::get('hospital_name_sw', 'Hospitali ya Ephamarcy'),
            'tagline_en' => HospitalSetting::get('tagline_en', 'Excellence in Healthcare, Compassion in Healing'),
            'tagline_sw' => HospitalSetting::get('tagline_sw', 'Ubora katika Huduma za Afya, Huruma katika Uponyaji'),
            'hospital_type_en' => HospitalSetting::get('hospital_type_en', 'Specialized Medical & Healthcare Center'),
            'hospital_type_sw' => HospitalSetting::get('hospital_type_sw', 'Kituo cha Ubingwa wa Afya na Matibabu'),
            'about_short_en' => HospitalSetting::get('about_short_en', 'Ephamarcy Hospital is a modern, patient-first tertiary medical institution dedicated to high-standard clinical care, specialized diagnostics, and empathetic patient support.'),
            'about_short_sw' => HospitalSetting::get('about_short_sw', 'Hospitali ya Ephamarcy ni kituo cha kisasa cha rufaa kinachotoa huduma bora za matibabu ya ubingwa wa juu, uchunguzi wa kisasa na huduma za dharura 24/7.'),

            // Contact & Emergency Lines
            'emergency_phone' => HospitalSetting::get('emergency_phone', '+255742448965'),
            'reception_phone' => HospitalSetting::get('reception_phone', '+255742448965'),
            'ambulance_phone' => HospitalSetting::get('ambulance_phone', '+255742448965'),
            'whatsapp_phone' => HospitalSetting::get('whatsapp_phone', '255742448965'),
            'official_email' => HospitalSetting::get('official_email', 'info@ephamarcyhosp.com'),
            'address_en' => HospitalSetting::get('address_en', 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania'),
            'address_sw' => HospitalSetting::get('address_sw', 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania'),
            'po_box' => HospitalSetting::get('po_box', 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania'),
            'google_maps_embed' => HospitalSetting::get('google_maps_embed', 'https://maps.google.com/maps?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania&t=&z=16&ie=UTF8&iwloc=&output=embed'),

            // Clinical & Visiting Hours
            'working_hours_emergency' => HospitalSetting::get('working_hours_emergency', '24/7 Resuscitation & Trauma Care'),
            'working_hours_opd' => HospitalSetting::get('working_hours_opd', 'Monday - Sunday, 07:30 - 20:00'),
            'visiting_hours_weekdays' => HospitalSetting::get('visiting_hours_weekdays', '06:00AM - 07:00AM | 12:30PM - 02:00PM | 04:00PM - 06:00PM'),
            'visiting_hours_weekends' => HospitalSetting::get('visiting_hours_weekends', '12:00PM - 02:00PM'),

            // Social & Online Channels
            'social_facebook' => HospitalSetting::get('social_facebook', 'https://facebook.com'),
            'social_twitter' => HospitalSetting::get('social_twitter', 'https://twitter.com'),
            'social_instagram' => HospitalSetting::get('social_instagram', 'https://instagram.com'),
            'social_youtube' => HospitalSetting::get('social_youtube', 'https://youtube.com'),
            'social_linkedin' => HospitalSetting::get('social_linkedin', 'https://linkedin.com'),

            // Branding & Colors
            'primary_color' => HospitalSetting::get('primary_color', '#153C63'),
            'accent_color' => HospitalSetting::get('accent_color', '#F78A49'),
            'logo_path' => HospitalSetting::get('logo_path', 'images/logo.png'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update hospital configuration settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // General
            'hospital_name_en' => 'required|string|max:255',
            'hospital_name_sw' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'tagline_sw' => 'nullable|string|max:255',
            'hospital_type_en' => 'nullable|string|max:255',
            'hospital_type_sw' => 'nullable|string|max:255',
            'about_short_en' => 'nullable|string|max:1000',
            'about_short_sw' => 'nullable|string|max:1000',

            // Contact
            'emergency_phone' => 'required|string|max:50',
            'reception_phone' => 'nullable|string|max:50',
            'ambulance_phone' => 'nullable|string|max:50',
            'whatsapp_phone' => 'nullable|string|max:50',
            'official_email' => 'required|email|max:150',
            'address_en' => 'nullable|string|max:255',
            'address_sw' => 'nullable|string|max:255',
            'po_box' => 'nullable|string|max:100',
            'google_maps_embed' => 'nullable|string',

            // Hours
            'working_hours_emergency' => 'nullable|string|max:150',
            'working_hours_opd' => 'nullable|string|max:150',
            'visiting_hours_weekdays' => 'nullable|string|max:255',
            'visiting_hours_weekends' => 'nullable|string|max:255',

            // Social
            'social_facebook' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',

            // Appearance & Media
            'primary_color' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $groupMap = [
            'hospital_name_en' => 'general',
            'hospital_name_sw' => 'general',
            'tagline_en' => 'general',
            'tagline_sw' => 'general',
            'hospital_type_en' => 'general',
            'hospital_type_sw' => 'general',
            'about_short_en' => 'general',
            'about_short_sw' => 'general',

            'emergency_phone' => 'contact',
            'reception_phone' => 'contact',
            'ambulance_phone' => 'contact',
            'whatsapp_phone' => 'contact',
            'official_email' => 'contact',
            'address_en' => 'contact',
            'address_sw' => 'contact',
            'po_box' => 'contact',
            'google_maps_embed' => 'contact',

            'working_hours_emergency' => 'hours',
            'working_hours_opd' => 'hours',
            'visiting_hours_weekdays' => 'hours',
            'visiting_hours_weekends' => 'hours',

            'social_facebook' => 'social',
            'social_twitter' => 'social',
            'social_instagram' => 'social',
            'social_youtube' => 'social',
            'social_linkedin' => 'social',

            'primary_color' => 'appearance',
            'accent_color' => 'appearance',
        ];

        // Process standard text keys
        foreach ($groupMap as $key => $group) {
            if ($request->has($key)) {
                HospitalSetting::set($key, $request->input($key), $group, 'text');
            }
        }

        // Process brand logo file upload
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $uploadDir = public_path('uploads/branding');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }

            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $fileName);
            $logoPath = 'uploads/branding/' . $fileName;

            HospitalSetting::set('logo_path', $logoPath, 'appearance', 'image');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Hospital settings and identity configuration updated successfully.');
    }
}

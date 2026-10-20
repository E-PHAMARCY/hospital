<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Show homepage material control center.
     */
    public function index(): View
    {
        $heroSlides = json_decode(HospitalSetting::get('homepage_hero_slides', '[]'), true) ?: [];
        $director = json_decode(HospitalSetting::get('homepage_director', '{}'), true) ?: [];
        $videos = json_decode(HospitalSetting::get('homepage_videos', '[]'), true) ?: [];
        $ticker = json_decode(HospitalSetting::get('homepage_ticker', '{}'), true) ?: [];
        $stats = json_decode(HospitalSetting::get('homepage_stats', '{}'), true) ?: [];
        $coreValues = json_decode(HospitalSetting::get('homepage_core_values', '[]'), true) ?: [];
        $insurancePartners = json_decode(HospitalSetting::get('homepage_insurance_partners', '[]'), true) ?: [];

        return view('admin.homepage.index', compact(
            'heroSlides',
            'director',
            'videos',
            'ticker',
            'stats',
            'coreValues',
            'insurancePartners'
        ));
    }

    /**
     * Update Hero architectural slider slides.
     */
    public function updateHero(Request $request): RedirectResponse
    {
        $slidesInput = $request->input('slides', []);
        $slides = [];

        foreach ($slidesInput as $index => $item) {
            $imagePath = $item['image_existing'] ?? 'images/hero_hospital_facade.jpg';

            if ($request->hasFile("slides.{$index}.image_file")) {
                $file = $request->file("slides.{$index}.image_file");
                $filename = 'hero_' . time() . "_{$index}." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/hero'), $filename);
                $imagePath = 'uploads/hero/' . $filename;
            }

            $slides[] = [
                'title' => $item['title'] ?? 'EPHAMARCY HOSPITAL',
                'sub' => $item['sub'] ?? '',
                'image' => $imagePath,
                'btn1_text' => $item['btn1_text'] ?? 'Book Appointment',
                'btn1_link' => $item['btn1_link'] ?? '/appointment',
                'btn2_text' => $item['btn2_text'] ?? 'Explore Services →',
                'btn2_link' => $item['btn2_link'] ?? '/services',
            ];
        }

        HospitalSetting::set('homepage_hero_slides', json_encode($slides), 'homepage', 'json');
        Cache::forget('setting_homepage_hero_slides');

        return back()->with('success', 'Hero architectural slides updated successfully.');
    }

    /**
     * Update Executive Director Statement & Profile.
     */
    public function updateDirector(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'title' => ['required', 'string', 'max:200'],
            'hospital' => ['nullable', 'string', 'max:200'],
            'statement_title' => ['required', 'string', 'max:200'],
            'lead' => ['required', 'string'],
            'extended' => ['nullable', 'string'],
            'btn1_text' => ['nullable', 'string', 'max:100'],
            'btn1_link' => ['nullable', 'string', 'max:255'],
            'btn2_text' => ['nullable', 'string', 'max:100'],
            'btn2_link' => ['nullable', 'string', 'max:255'],
        ]);

        $current = json_decode(HospitalSetting::get('homepage_director', '{}'), true) ?: [];
        $photoPath = $current['photo'] ?? 'images/director_dr_delilah.jpg';

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'director_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/director'), $filename);
            $photoPath = 'uploads/director/' . $filename;
        }

        $validated['photo'] = $photoPath;

        HospitalSetting::set('homepage_director', json_encode($validated), 'homepage', 'json');
        Cache::forget('setting_homepage_director');

        return back()->with('success', "Executive Director's statement and profile updated successfully.");
    }

    /**
     * Update Featured Videos.
     */
    public function updateVideos(Request $request): RedirectResponse
    {
        $videosInput = $request->input('videos', []);
        $videos = [];

        foreach ($videosInput as $index => $item) {
            $imagePath = $item['image_existing'] ?? 'images/media_doctor_interview.jpg';

            if ($request->hasFile("videos.{$index}.image_file")) {
                $file = $request->file("videos.{$index}.image_file");
                $filename = 'video_thumb_' . time() . "_{$index}." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/media'), $filename);
                $imagePath = 'uploads/media/' . $filename;
            }

            $videos[] = [
                'title' => $item['title'] ?? 'Hospital Video',
                'channel' => $item['channel'] ?? 'Hospital TV',
                'image' => $imagePath,
                'url' => $item['url'] ?? 'https://www.youtube.com',
            ];
        }

        HospitalSetting::set('homepage_videos', json_encode($videos), 'homepage', 'json');
        Cache::forget('setting_homepage_videos');

        return back()->with('success', 'Featured videos updated successfully.');
    }

    /**
     * Update Live Operational Ticker & Highlights.
     */
    public function updateTicker(Request $request): RedirectResponse
    {
        $badge = $request->input('badge', 'HIGHLIGHTS');
        $rawItems = $request->input('items', []);
        $items = [];

        foreach ($rawItems as $item) {
            if (!empty(trim($item['text'] ?? ''))) {
                $items[] = [
                    'tag' => strtoupper(trim($item['tag'] ?? 'NEWS')),
                    'text' => trim($item['text']),
                ];
            }
        }

        $tickerData = [
            'badge' => $badge,
            'items' => $items,
        ];

        HospitalSetting::set('homepage_ticker', json_encode($tickerData), 'homepage', 'json');
        Cache::forget('setting_homepage_ticker');

        return back()->with('success', 'Live highlights ticker updated successfully.');
    }

    /**
     * Update Hospital Statistics Counters.
     */
    public function updateStats(Request $request): RedirectResponse
    {
        $statsData = [
            'title' => $request->input('title', 'Hospital Statistics'),
            'beds_number' => $request->input('beds_number', '1,500'),
            'beds_label' => $request->input('beds_label', 'Beds'),
            'doctors_number' => $request->input('doctors_number', '300+'),
            'doctors_label' => $request->input('doctors_label', 'Doctors'),
            'staff_number' => $request->input('staff_number', '2,500+'),
            'staff_label' => $request->input('staff_label', 'Staff Members'),
            'patients_number' => $request->input('patients_number', '100K+'),
            'patients_label' => $request->input('patients_label', 'Annual Patients'),
        ];

        HospitalSetting::set('homepage_stats', json_encode($statsData), 'homepage', 'json');
        Cache::forget('setting_homepage_stats');

        return back()->with('success', 'Hospital statistics counters updated successfully.');
    }

    /**
     * Update Core Values.
     */
    public function updateCoreValues(Request $request): RedirectResponse
    {
        $valuesInput = $request->input('values', []);
        $values = [];

        foreach ($valuesInput as $val) {
            $values[] = [
                'title' => $val['title'] ?? '',
                'description' => $val['description'] ?? '',
                'color' => $val['color'] ?? 'navy',
            ];
        }

        HospitalSetting::set('homepage_core_values', json_encode($values), 'homepage', 'json');
        Cache::forget('setting_homepage_core_values');

        return back()->with('success', 'Core values section updated successfully.');
    }

    /**
     * Update Insurance Services & Corporate Partners.
     */
    public function updateInsurancePartners(Request $request): RedirectResponse
    {
        $partnersInput = $request->input('partners', []);
        $partners = [];

        File::ensureDirectoryExists(public_path('uploads/partners'));

        foreach ($partnersInput as $index => $item) {
            $name = trim($item['name'] ?? '');
            if (empty($name)) {
                continue;
            }

            $logoPath = $item['logo_existing'] ?? null;

            if ($request->hasFile("partners.{$index}.logo_file")) {
                $file = $request->file("partners.{$index}.logo_file");
                $filename = 'partner_' . time() . "_{$index}." . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/partners'), $filename);
                $logoPath = 'uploads/partners/' . $filename;
            }

            $partners[] = [
                'name' => $name,
                'subtitle' => $item['subtitle'] ?? '',
                'badge_text' => $item['badge_text'] ?? strtoupper(substr($name, 0, 4)),
                'badge_color' => $item['badge_color'] ?? 'navy',
                'website_url' => $item['website_url'] ?? '',
                'logo' => $logoPath,
            ];
        }

        HospitalSetting::set('homepage_insurance_partners', json_encode($partners), 'homepage', 'json');
        Cache::forget('setting_homepage_insurance_partners');

        return back()->with('success', 'Insurance services and corporate partners updated successfully.');
    }
}

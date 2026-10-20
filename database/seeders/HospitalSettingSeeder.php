<?php

namespace Database\Seeders;

use App\Models\HospitalSetting;
use Illuminate\Database\Seeder;

class HospitalSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hospital_name_en', 'value' => 'Ephamarcy Hospital', 'group' => 'general'],
            ['key' => 'hospital_name_sw', 'value' => 'Hospitali ya Ephamarcy', 'group' => 'general'],
            ['key' => 'tagline_en', 'value' => 'Excellence in Healthcare, Compassion in Healing', 'group' => 'general'],
            ['key' => 'tagline_sw', 'value' => 'Ubora katika Huduma za Afya, Huruma katika Uponyaji', 'group' => 'general'],
            ['key' => 'emergency_phone', 'value' => '+255742448965', 'group' => 'contact'],
            ['key' => 'reception_phone', 'value' => '+255742448965', 'group' => 'contact'],
            ['key' => 'official_email', 'value' => 'info@ephamarcyhosp.com', 'group' => 'contact'],
            ['key' => 'address_en', 'value' => 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania', 'group' => 'contact'],
            ['key' => 'address_sw', 'value' => 'Sombetini (Ukumbi wa Diwani), Arusha, Tanzania', 'group' => 'contact'],
            ['key' => 'working_hours_emergency', 'value' => '24/7 Everyday', 'group' => 'hours'],
            ['key' => 'working_hours_opd', 'value' => 'Monday - Sunday, 07:30 - 20:00', 'group' => 'hours'],
            ['key' => 'primary_color', 'value' => '#153C63', 'group' => 'appearance'],
            ['key' => 'accent_color', 'value' => '#F78A49', 'group' => 'appearance'],
            
            // Dynamic Homepage Material
            ['key' => 'homepage_hero_slides', 'value' => json_encode([
                [
                    'title' => 'EPHAMARCY HOSPITAL',
                    'sub' => 'Delivering comprehensive inpatient, outpatient, advanced surgical procedures, and compassionate healing.',
                    'image' => 'images/hero_hospital_facade.jpg',
                    'btn1_text' => 'Book Appointment',
                    'btn1_link' => '/appointment',
                    'btn2_text' => 'Explore Services →',
                    'btn2_link' => '/services',
                ],
                [
                    'title' => 'ADVANCED CLINICAL EXCELLENCE',
                    'sub' => 'Equipped with state-of-the-art diagnostic imaging, cath labs, surgical suites, and 24/7 emergency resuscitation.',
                    'image' => 'images/hero_surgery_suite.jpg',
                    'btn1_text' => 'Book Appointment',
                    'btn1_link' => '/appointment',
                    'btn2_text' => 'Explore Services →',
                    'btn2_link' => '/services',
                ],
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_director', 'value' => json_encode([
                'name' => 'Dr. Delilah Charles Kimambo',
                'title' => 'Executive Director',
                'hospital' => 'Ephamarcy Hospital',
                'photo' => 'images/director_dr_delilah.jpg',
                'statement_title' => "Executive Director's Statement",
                'lead' => "Muhimbili National Hospital is proud of its long-standing history as Tanzania's leading tertiary referral and teaching hospital under the Ministry of Health. As the highest level of care in the country's health system, MNH serves the nation and neighboring countries by providing advanced specialized and super-specialized medical services. We deliver a wide range of complex healthcare services, including advanced surgeries, organ transplant, diagnostics, oncology, cardiology, interventional radiol...",
                'extended' => 'We are committed to delivering exemplary patient-centered healthcare, training next-generation medical leaders, and pioneering life-saving clinical breakthroughs across Eastern Africa.',
                'btn1_text' => 'DISCOVER OUR MISSION',
                'btn1_link' => '/about/mission-vision',
                'btn2_text' => 'MEET OUR TEAM',
                'btn2_link' => '/doctors',
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_videos', 'value' => json_encode([
                [
                    'title' => 'Tuache imani potofu tukiona dalili za kutapik...',
                    'channel' => 'Muhimbili TV',
                    'image' => 'images/media_doctor_interview.jpg',
                    'url' => 'https://www.youtube.com',
                ],
                [
                    'title' => 'Hizi Hapa Dalili za Hatari kwa Mama Mjamzito na Mtoto Mchanga',
                    'channel' => 'Muhimbili TV',
                    'image' => 'images/media_maternal_health.jpg',
                    'url' => 'https://www.youtube.com',
                ],
                [
                    'title' => 'Huduma za Kisasa za Upasuaji wa Moyo na Upandikizaji Viungo',
                    'channel' => 'Muhimbili TV',
                    'image' => 'images/media_cardiac_surgery.jpg',
                    'url' => 'https://www.youtube.com',
                ],
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_ticker', 'value' => json_encode([
                'badge' => 'HIGHLIGHTS',
                'items' => [
                    ['tag' => 'NEWS', 'text' => 'WAZIRI WA AFYA ATOA MAAGIZO BODI MPYA YA WADHAMINI MUHIMBILI'],
                    ['tag' => 'NEWS', 'text' => 'MUHIMBILI YAKUTANA NA MASHUJAA WALIOPONA MAGONJWA SUGU'],
                    ['tag' => 'NEWS', 'text' => 'KAMBI MAALUM YA MADAKTARI BINGWA WA UPASUAJI WA MOYO YAANZA'],
                    ['tag' => 'EMERGENCY', 'text' => 'HUDUMA YA DHARURA 24/7 — PIGA SIMU: +255742448965'],
                ],
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_stats', 'value' => json_encode([
                'title' => 'Hospital Statistics',
                'beds_number' => '1,500',
                'beds_label' => 'Beds',
                'doctors_number' => '300+',
                'doctors_label' => 'Doctors',
                'staff_number' => '2,500+',
                'staff_label' => 'Staff Members',
                'patients_number' => '100K+',
                'patients_label' => 'Annual Patients',
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_core_values', 'value' => json_encode([
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
            ]), 'group' => 'homepage', 'type' => 'json'],

            ['key' => 'homepage_insurance_partners', 'value' => json_encode([
                [
                    'name' => 'NHIF Tanzania',
                    'subtitle' => 'National Health Insurance Fund',
                    'badge_text' => 'NHIF',
                    'badge_color' => 'emerald',
                    'website_url' => 'https://www.nhif.or.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'NSSF Tanzania',
                    'subtitle' => 'Social Security Fund',
                    'badge_text' => 'NSSF',
                    'badge_color' => 'amber',
                    'website_url' => 'https://www.nssf.or.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'Jubilee Health Insurance',
                    'subtitle' => 'Health Insurance Provider',
                    'badge_text' => 'JUB',
                    'badge_color' => 'navy',
                    'website_url' => 'https://jubileeinsurance.com',
                    'logo' => null,
                ],
                [
                    'name' => 'Strategis Insurance',
                    'subtitle' => 'Medical & General Cover',
                    'badge_text' => 'STR',
                    'badge_color' => 'purple',
                    'website_url' => 'https://www.strategis.co.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'Assemble Insurance',
                    'subtitle' => 'Healthcare Coverage',
                    'badge_text' => 'ASM',
                    'badge_color' => 'teal',
                    'website_url' => 'https://assemble.co.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'GA Insurance Tanzania',
                    'subtitle' => 'General & Medical Insurance',
                    'badge_text' => 'GA',
                    'badge_color' => 'orange',
                    'website_url' => 'https://www.gainsurance.co.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'Tanzania Ports Authority (TPA)',
                    'subtitle' => 'Corporate Partner',
                    'badge_text' => 'TPA',
                    'badge_color' => 'navy',
                    'website_url' => 'https://www.ports.go.tz',
                    'logo' => null,
                ],
                [
                    'name' => 'Zanzibar Daily',
                    'subtitle' => 'Media & Information Partner',
                    'badge_text' => 'ZD',
                    'badge_color' => 'amber',
                    'website_url' => '',
                    'logo' => null,
                ],
            ]), 'group' => 'homepage', 'type' => 'json'],
        ];

        foreach ($settings as $setting) {
            HospitalSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}

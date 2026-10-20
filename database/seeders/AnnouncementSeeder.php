<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title_en' => '24/7 Acute Casualty & Trauma Center',
                'title_sw' => 'Kituo cha Dharura na Ajali Masaa 24',
                'message_en' => 'Our emergency triage desk is fully staffed and operational for critical admissions.',
                'message_sw' => 'Kitengo cha mapokezi ya dharura kiko wazi masaa yote kwa ajili ya wagonjwa mahututi.',
                'type' => 'urgent',
                'is_active' => true,
                'starts_at' => Carbon::now()->subDays(30),
                'expires_at' => Carbon::now()->addDays(90),
            ],
            [
                'title_en' => 'Community Voluntary Blood Donation Drive',
                'title_sw' => 'Zoezi la Hiari la Kuchangia Damu',
                'message_en' => 'Join us this Friday at the Clinical Atrium to support our maternal and emergency blood bank.',
                'message_sw' => 'Ungana nasi Ijumaa hii katika ukumbi mkuu kuwezesha benki ya damu ya hospitali.',
                'type' => 'info',
                'is_active' => true,
                'starts_at' => Carbon::now()->subDays(2),
                'expires_at' => Carbon::now()->addDays(7),
            ],
        ];

        foreach ($announcements as $ann) {
            Announcement::updateOrCreate(['title_en' => $ann['title_en']], $ann);
        }
    }
}

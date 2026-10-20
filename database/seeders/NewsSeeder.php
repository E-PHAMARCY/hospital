<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title_en' => 'Ephamarcy Hospital Inaugurates Advanced 3T MRI & Cardiac Diagnostics Lab',
                'title_sw' => 'Hospitali ya Ephamarcy Yazindua Maabara ya Kisasa ya 3T MRI na Uchunguzi wa Moyo',
                'slug' => 'ephamarcy-hospital-inaugurates-cardiac-lab',
                'category' => 'Clinical Updates',
                'featured_image' => 'images/news_mri_diagnostic.jpg',
                'excerpt_en' => 'Our new high-definition color Doppler echocardiography and 3T MRI suite enhances early cardiovascular screening for regional patients.',
                'excerpt_sw' => 'Kitengo chetu kipya cha uchunguzi wa moyo na MRI kinaboresha ugunduzi wa mapema wa magonjwa ya moyo.',
                'content_en' => 'Ephamarcy Hospital has officially commissioned its advanced non-invasive cardiac diagnostic wing. Patients can now undergo color Doppler examinations, continuous Holter monitoring, and stress testing within our centralized facility.',
                'content_sw' => 'Hospitali ya Ephamarcy imezindua rasmi kitengo chake cha kisasa cha uchunguzi wa magonjwa ya moyo. Wagonjwa sasa wanaweza kufanyiwa vipimo vya Echo na mazoezi kwa haraka zaidi.',
                'published_at' => Carbon::now()->subDays(3),
                'is_published' => true,
            ],
            [
                'title_en' => 'National Blood Donation Drive Draws Over 800 Donors Across Campuses',
                'title_sw' => 'Kampeni ya Kitaifa ya Uchangiaji Damu Yavuta Zaidi ya Wachangiaji 800',
                'slug' => 'national-blood-donation-drive-success',
                'category' => 'Community Health',
                'featured_image' => 'images/news_blood_donation.jpg',
                'excerpt_en' => 'Voluntary citizens and healthcare workers gathered at Upanga Main Hospital to support regional emergency blood reserves.',
                'excerpt_sw' => 'Wananchi wa hiari na watumishi wa afya wamejitokeza katika Hospitali Kuu ya Upanga kuongeza akiba ya damu salama.',
                'content_en' => 'The National Blood Transfusion Center in collaboration with Ephamarcy Hospital achieved a record collection of 850 blood units during the weekend drive, bolstering trauma and maternity preparedness.',
                'content_sw' => 'Kitengo cha damu salama kimekusanya chupa zaidi ya 850 za damu salama ili kusaidia wodi za dharura na wajawazito.',
                'published_at' => Carbon::now()->subDays(5),
                'is_published' => true,
            ],
            [
                'title_en' => 'Super-Specialized Cardiac Surgery Team Completes 50 Complex Valve Repairs',
                'title_sw' => 'Madaktari Bingwa wa Upasuaji wa Moyo Wakamilisha Upasuaji wa Valvu 50',
                'slug' => 'understanding-hypertension-preventative-steps',
                'category' => 'Clinical Updates',
                'featured_image' => 'images/media_cardiac_surgery.jpg',
                'excerpt_en' => 'Milestone achievements in minimally invasive heart surgery and valve replacements at the surgical theater.',
                'excerpt_sw' => 'Mafanikio makubwa katika upasuaji wa kisasa wa moyo na kubadilisha valvu katika chumba cha upasuaji.',
                'content_en' => 'Our cardiovascular surgery division has reached a major milestone, completing 50 consecutive successful valve replacements with zero 30-day mortality.',
                'content_sw' => 'Madaktari wetu wa upasuaji wa moyo wamekamilisha upasuaji wa valvu 50 kwa mafanikio makubwa na usalama wa hali ya juu.',
                'published_at' => Carbon::now()->subDays(8),
                'is_published' => true,
            ],
            [
                'title_en' => 'Pediatric Nutrition & Maternal Care Drive Expands to Satellite Campuses',
                'title_sw' => 'Kliniki ya Afya ya Uzazi na Mtoto Yapanuliwa katika Kampasi Zote',
                'slug' => 'pediatric-nutrition-vaccination-campaign-2026',
                'category' => 'Community Health',
                'featured_image' => 'images/media_maternal_health.jpg',
                'excerpt_en' => 'The Maternal and Child Health clinic conducts free growth monitoring and routine immunization drives every Saturday.',
                'excerpt_sw' => 'Kliniki ya afya ya uzazi na mtoto itatoa huduma za upimaji wa ukuaji na chanjo kila Jumamosi mwezi huu.',
                'content_en' => 'Parents and caregivers are invited to participate in our comprehensive pediatric health sessions held every Saturday from 08:00 to 13:00 at the Maternal and Child Health Wing.',
                'content_sw' => 'Wazazi na walezi wanakaribishwa kuhudhuria vipindi vya uchunguzi wa afya ya mtoto na chanjo kila Jumamosi saa 02:00 asubuhi hadi saa 07:00 mchana.',
                'published_at' => Carbon::now()->subDays(14),
                'is_published' => true,
            ],
        ];

        foreach ($articles as $art) {
            News::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}

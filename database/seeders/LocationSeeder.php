<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name_en' => 'Main Medical Campus & Casualty Centre',
                'name_sw' => 'Kampasi Kuu ya Hospitali na Kituo cha Dharura',
                'slug' => 'main-medical-campus',
                'address_en' => 'Plot 45, Medical Avenue, Upanga, Dar es Salaam, Tanzania',
                'address_sw' => 'Kiwanja 45, Barabara ya Matibabu, Upanga, Dar es Salaam, Tanzania',
                'phone' => '+255742448965',
                'email' => 'maincampus@ephamarcyhosp.com',
                'opening_hours_en' => 'Emergency: 24/7 | Specialized Clinics: 07:30 - 20:00',
                'opening_hours_sw' => 'Dharura: Masaa 24 | Kliniki za Madaktari Bingwa: 01:30 - 14:00',
                'google_map_url' => 'https://maps.google.com/?q=-6.8045,39.2789',
                'description_en' => 'Our flagship tertiary hospital housing inpatient wards, intensive care units, 6 surgical theaters, cardiac lab, and centralized pathology.',
                'description_sw' => 'Kituo kikuu cha matibabu chenye wodi za kulaza, vyumba vya wagonjwa mahututi, kumbi 6 za upasuaji na maabara kuu.',
                'is_main' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name_en' => 'Ephamarcy City Centre Outpatient Clinic',
                'name_sw' => 'Kliniki ya Nje ya Mjini Ephamarcy',
                'slug' => 'city-centre-clinic',
                'address_en' => 'Samora Avenue Plaza, 2nd Floor, CBD, Dar es Salaam, Tanzania',
                'address_sw' => 'Jengo la Samora Avenue, Ghorofa ya 2, Posta, Dar es Salaam, Tanzania',
                'phone' => '+255742448965',
                'email' => 'cityclinic@ephamarcyhosp.com',
                'opening_hours_en' => 'Monday - Saturday: 08:00 - 18:00',
                'opening_hours_sw' => 'Jumatatu - Jumamosi: Saa 02:00 Asubuhi - Saa 12:00 Jioni',
                'google_map_url' => 'https://maps.google.com/?q=-6.8161,39.2894',
                'description_en' => 'Fast-track executive outpatient consultations, corporate wellness checkups, digital radiology, and pharmacy dispensing.',
                'description_sw' => 'Huduma za haraka za kliniki za nje, uchunguzi wa afya kwa watumishi wa mashirika, mionzi na duka la dawa.',
                'is_main' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($locations as $loc) {
            Location::updateOrCreate(['slug' => $loc['slug']], $loc);
        }
    }
}

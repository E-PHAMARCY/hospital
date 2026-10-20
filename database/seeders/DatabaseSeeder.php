<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with production foundation data.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            HospitalSettingSeeder::class,
            LocationSeeder::class,
            DepartmentSeeder::class,
            ServiceSeeder::class,
            DoctorSeeder::class,
            LeadershipProfileSeeder::class,
            NewsSeeder::class,
            AnnouncementSeeder::class,
            HealthArticleSeeder::class,
            ResourceSeeder::class,
            FaqSeeder::class,
            CareerSeeder::class,
            TenderSeeder::class,
            PageSeeder::class,
            AppointmentRequestSeeder::class,
            ContactInquirySeeder::class,
        ]);
    }
}

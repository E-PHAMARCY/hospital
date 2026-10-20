<?php

namespace Database\Seeders;

use App\Models\Tender;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TenderSeeder extends Seeder
{
    public function run(): void
    {
        $tenders = [
            [
                'tender_number' => 'EPH/TEN/2026/001',
                'title_en' => 'Supply and Commissioning of Automated Biochemistry Analyzers',
                'title_sw' => 'Ugavi na Ufungaji wa Mashine za Kisasa za Maabara ya Kemia',
                'slug' => 'supply-biochemistry-analyzers-2026-001',
                'description_en' => 'Ephamarcy Hospital invites sealed bids from eligible international and local biomedical equipment suppliers for the supply, installation, testing, and 3-year preventive maintenance of fully automated clinical biochemistry laboratory systems.',
                'description_sw' => 'Hospitali ya Ephamarcy inakaribisha zabuni zilizofungwa kutoka kwa wazabuni wenye sifa kwa ajili ya ugavi, usimikaji, na ukarabati wa mashine za maabara za kuchunguza sampuli za damu.',
                'publication_date' => Carbon::now()->subDays(5),
                'submission_deadline' => Carbon::now()->addDays(20),
                'status' => 'open',
            ],
            [
                'tender_number' => 'EPH/TEN/2026/002',
                'title_en' => 'Provision of Hospital Environmental Cleaning & Sanitary Services',
                'title_sw' => 'Kutoa Huduma za Usafi wa Mazingira na Vyoo vya Hospitali',
                'slug' => 'hospital-cleaning-sanitary-services-2026-002',
                'description_en' => 'Tenders are invited from certified institutional cleaning contractors for the provision of medical-grade ward disinfection, biohazard surface cleansing, and hygiene maintenance across all hospital inpatient and outpatient buildings.',
                'description_sw' => 'Zabuni inakaribishwa kutoka kwa makampuni yaliyosajiliwa ya usafi kwa ajili ya usafi wa kina wa wodi, kumbi za wagonjwa na mazingira ya nje ya hospitali.',
                'publication_date' => Carbon::now()->subDays(10),
                'submission_deadline' => Carbon::now()->addDays(14),
                'status' => 'open',
            ],
        ];

        foreach ($tenders as $ten) {
            Tender::updateOrCreate(['tender_number' => $ten['tender_number']], $ten);
        }
    }
}

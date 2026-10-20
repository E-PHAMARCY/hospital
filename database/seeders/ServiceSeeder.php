<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $emergencyDept = Department::where('slug', 'emergency-trauma')->first();
        $cardioDept = Department::where('slug', 'cardiology')->first();
        $pediatricsDept = Department::where('slug', 'pediatrics')->first();
        $maternityDept = Department::where('slug', 'maternity-obstetrics')->first();
        $orthoDept = Department::where('slug', 'orthopedics')->first();
        $radiologyDept = Department::where('slug', 'radiology-imaging')->first();

        $services = [
            [
                'department_id' => $pediatricsDept?->id,
                'name_en' => 'Paediatric and Child Care',
                'name_sw' => 'Huduma za Watoto na Afya ya Mtoto',
                'slug' => 'paediatric-and-child-care',
                'summary_en' => 'The Paediatric and Child Care Services provides specialized medical care for infants, children, and adolescents.',
                'summary_sw' => 'Huduma ya watoto inatoa matibabu ya kibobezi kwa watoto wachanga, watoto na vijana wadogo.',
                'icon' => 'smile',
                'color' => 'teal',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'department_id' => $emergencyDept?->id,
                'name_en' => 'Acute/General Mental Health Services',
                'name_sw' => 'Huduma za Afya ya Akili na Saikolojia',
                'slug' => 'mental-health-services',
                'summary_en' => 'The Acute/General Mental Health Services provides comprehensive and specialized services for individuals experiencing psychological distress.',
                'summary_sw' => 'Huduma jumuishi na za kibobezi kwa watu wanaopitia changamoto na msongo wa afya ya akili.',
                'icon' => 'briefcase',
                'color' => 'purple',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'department_id' => $emergencyDept?->id,
                'name_en' => 'Infectious Diseases Services',
                'name_sw' => 'Kitengo cha Magonjwa ya Kuambukiza',
                'slug' => 'infectious-diseases-services',
                'summary_en' => 'The Infectious Diseases Unit provides specialized care for patients affected by various infectious conditions and emerging pathogens.',
                'summary_sw' => 'Kitengo cha magonjwa ya kuambukiza kinatoa matibabu maalum kwa wagonjwa walioathiriwa na vimelea mbalimbali.',
                'icon' => 'briefcase',
                'color' => 'orange',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'department_id' => $emergencyDept?->id,
                'name_en' => 'Intensive Care Unit (ICU)',
                'name_sw' => 'Kitengo cha Wagonjwa Mahututi (ICU)',
                'slug' => 'intensive-care-unit',
                'summary_en' => 'The Intensive Care Unit (ICU) provides highly specialized and continuous monitoring for critically ill patients.',
                'summary_sw' => 'Uangalizi endelevu na mashine za kisasa za kusaidia kupumua kwa wagonjwa mahututi masaa 24.',
                'icon' => 'heart-pulse',
                'color' => 'red',
                'is_emergency' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'department_id' => $radiologyDept?->id,
                'name_en' => 'Neurology & Neurosurgery',
                'name_sw' => 'Huduma za Mishipa ya Fahamu na Ubongo',
                'slug' => 'neurology-neurosurgery',
                'summary_en' => 'The Neurology service focuses on the diagnosis and management of brain, spine, and nervous system disorders.',
                'summary_sw' => 'Huduma ya mishipa ya fahamu na ubongo inalenga uchunguzi na matibabu ya mfumo mzima wa fahamu.',
                'icon' => 'brain',
                'color' => 'amber',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'department_id' => $cardioDept?->id,
                'name_en' => 'Cardiology & Heart Center',
                'name_sw' => 'Kituo cha Magonjwa ya Moyo',
                'slug' => 'cardiology-heart-center',
                'summary_en' => 'Advanced cardiac catheterization, echocardiography, pacemaker implantation, and interventional cardiology.',
                'summary_sw' => 'Uchunguzi wa moyo, upasuaji wa mishipa ya damu na matibabu ya kisasa ya presha.',
                'icon' => 'heart-pulse',
                'color' => 'navy',
                'is_emergency' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'department_id' => $orthoDept?->id,
                'name_en' => 'Orthopedics & Joint Replacement',
                'name_sw' => 'Mifupa na Upasuaji wa Viungo',
                'slug' => 'orthopedics-joint-replacement',
                'summary_en' => 'Keyhole surgery for knee ligaments, total hip replacement, and complex trauma bone reconstruction.',
                'summary_sw' => 'Upasuaji wa kisasa wa viungo na mifupa, kubadilisha nyonga na magoti.',
                'icon' => 'briefcase',
                'color' => 'teal',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'department_id' => $radiologyDept?->id,
                'name_en' => 'Advanced Diagnostic Radiology & MRI',
                'name_sw' => 'Mionzi ya Kisasa, CT-Scan na MRI',
                'slug' => 'radiology-mri',
                'summary_en' => '128-slice CT scans, 1.5T MRI, 4D ultrasound, digital mammography, and fluoroscopy.',
                'summary_sw' => 'Picha za kina za CT-Scan, MRI na Ultra-sound zenye usahihi wa hali ya juu.',
                'icon' => 'briefcase',
                'color' => 'purple',
                'is_emergency' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(['slug' => $srv['slug']], $srv);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name_en' => 'Emergency & Trauma Centre',
                'name_sw' => 'Kituo cha Dharura na Ajali',
                'slug' => 'emergency-trauma',
                'summary_en' => 'Immediate acute triage, resuscitation bays, and adult & pediatric trauma stabilization teams 24 hours daily.',
                'summary_sw' => 'Huduma za haraka za dharura, vyumba vya kurejesha fahamu, na uangalizi wa majeraha masaa 24 kila siku.',
                'location' => 'Ground Floor, Wing A',
                'phone' => '+255742448965',
                'email' => 'emergency@ephamarcyhosp.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name_en' => 'Cardiology & Cardiovascular Sciences',
                'name_sw' => 'Idara ya Magonjwa ya Moyo',
                'slug' => 'cardiology',
                'summary_en' => 'Non-invasive echocardiography, cardiac stress testing, catheterization procedures, and hypertension clinics.',
                'summary_sw' => 'Uchunguzi wa kisasa wa moyo (ECHO, ECG), kliniki ya shinikizo la damu, na matibabu ya dharura ya moyo.',
                'location' => 'Building 2, Level 3',
                'phone' => '+255742448965',
                'email' => 'cardiology@ephamarcyhosp.com',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name_en' => 'Pediatrics & Child Health',
                'name_sw' => 'Idara ya Watoto na Afya ya Mtoto',
                'slug' => 'pediatrics',
                'summary_en' => 'Dedicated pediatric emergency care, neonatal ICU, developmental assessments, and child immunization clinics.',
                'summary_sw' => 'Uangalizi maalumu wa watoto, chumba cha watoto wachanga mahututi (NICU), na kliniki za chanjo na ukuaji.',
                'location' => 'Maternal & Child Complex, Level 1',
                'phone' => '+255742448965',
                'email' => 'pediatrics@ephamarcyhosp.com',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name_en' => 'Obstetrics & Gynecology (Maternity)',
                'name_sw' => 'Uzazi na Afya ya Wanawake',
                'slug' => 'maternity-obstetrics',
                'summary_en' => 'Comprehensive antenatal care, modern labor suites, high-risk pregnancy management, and fertility counseling.',
                'summary_sw' => 'Huduma bora za wajawazito, vyumba vya kisasa vya kujifungulia, na kliniki za uzazi salama.',
                'location' => 'Maternal & Child Complex, Level 2',
                'phone' => '+255742448965',
                'email' => 'maternity@ephamarcyhosp.com',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name_en' => 'Orthopedics & Joint Reconstruction',
                'name_sw' => 'Mifupa na Upasuaji wa Viungo',
                'slug' => 'orthopedics',
                'summary_en' => 'Advanced trauma fixation, arthroscopic sports injury repair, hip & knee replacements, and spine therapy.',
                'summary_sw' => 'Matibabu na upasuaji wa mifupa, viungo vilivyovunjika, kubadilisha viungo vya magoti na nyonga.',
                'location' => 'Surgical Tower, Level 2',
                'phone' => '+255742448965',
                'email' => 'ortho@ephamarcyhosp.com',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name_en' => 'Radiology & Advanced Imaging',
                'name_sw' => 'Mionzi na Uchunguzi wa Kisasa',
                'slug' => 'radiology-imaging',
                'summary_en' => '128-Slice helical CT scanner, 1.5 Tesla MRI, 4D Doppler ultrasonography, digital mammography, and X-ray.',
                'summary_sw' => 'Mashine za kisasa za CT-Scan, MRI, Ultra-sound ya 4D, na picha za kidijitali za mionzi (X-Ray).',
                'location' => 'Diagnostic Centre, Ground Floor',
                'phone' => '+255742448965',
                'email' => 'radiology@ephamarcyhosp.com',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['slug' => $dept['slug']], $dept);
        }
    }
}

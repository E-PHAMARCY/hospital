<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title_en' => 'Inpatient Admission & Patient Rights Charter 2026',
                'title_sw' => 'Mwongozo wa Kulazwa na Haki za Mgonjwa 2026',
                'description_en' => 'Essential guidelines regarding admission policies, visiting hours, patient safety, and medical confidentiality.',
                'description_sw' => 'Miongozo muhimu kuhusu taratibu za kulazwa, muda wa kuona wagonjwa, na usalama wa taarifa.',
                'category' => 'Patient Guide',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'is_active' => true,
            ],
            [
                'title_en' => 'Outpatient Clinic Pre-Registration Form',
                'title_sw' => 'Fomu ya Usajili wa Awali wa Kliniki ya Nje',
                'description_en' => 'Downloadable form for faster check-in at general outpatient and specialist consultation counters.',
                'description_sw' => 'Fomu inayowezesha wagonjwa kujiandikisha mapema kabla ya kumuona daktari.',
                'category' => 'Forms',
                'file_type' => 'PDF',
                'file_size' => '650 KB',
                'is_active' => true,
            ],
            [
                'title_en' => 'Pre-Operative Surgical Patient Preparation Checklist',
                'title_sw' => 'Orodha ya Maandalizi ya Mgonjwa Kabla ya Upasuaji',
                'description_en' => 'Clinical instructions for patients scheduled for elective surgeries, including fasting guidelines and medication adjustments.',
                'description_sw' => 'Maelekezo ya kitabibu kwa wagonjwa wanaojiandaa kwa upasuaji, ikiwemo muda wa kutokula.',
                'category' => 'Clinical Protocol',
                'file_type' => 'PDF',
                'file_size' => '1.1 MB',
                'is_active' => true,
            ],
            [
                'title_en' => 'Ephamarcy Hospital Quality & Clinical Performance Report 2025/2026',
                'title_sw' => 'Ripoti ya Ubora na Utendaji wa Huduma za Hospitali ya Ephamarcy 2025/2026',
                'description_en' => 'Annual statistical overview of clinical outcomes, patient safety metrics, and facility developments.',
                'description_sw' => 'Muhtasari wa takwimu za mwaka za utoaji wa huduma za matibabu na mafanikio ya hospitali.',
                'category' => 'Reports',
                'file_type' => 'PDF',
                'file_size' => '4.8 MB',
                'is_active' => true,
            ],
        ];

        foreach ($resources as $res) {
            Resource::updateOrCreate(['title_en' => $res['title_en']], $res);
        }
    }
}

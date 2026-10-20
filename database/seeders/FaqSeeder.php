<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question_en' => 'Does Ephamarcy Hospital treat international/foreign patients and what services are available?',
                'question_sw' => 'Je, Ephamarcy Hospital inatibu wagonjwa wa kimataifa na huduma zipi zinapatikana?',
                'answer_en' => 'Yes. The hospital provides specialized international medical consultations, medical visas support, and dedicated multilingual patient liaisons.',
                'answer_sw' => 'Ndiyo. Hospitali inatoa huduma za kibobezi za matibabu kwa wagonjwa wa kimataifa, usaidizi wa visa za matibabu, na wahudumu wanaozungumza lugha mbalimbali.',
                'category' => 'service',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'question_en' => 'If I need emergency care, what should I know?',
                'question_sw' => 'Iwapo ninahitaji huduma ya dharura, ninapaswa kujua nini?',
                'answer_en' => 'Our Emergency & Trauma Casualty wing operates 24/7. Walk straight to the casualty resuscitation bay or call +255742448965 immediately.',
                'answer_sw' => 'Kitengo chetu cha Majeruhi na Dharura kinafanya kazi masaa 24/7. Fika moja kwa moja mapokezi ya dharura au piga simu namba +255742448965 mara moja.',
                'category' => 'service',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'question_en' => 'Does Ephamarcy Hospital accept students for electives or practical training?',
                'question_sw' => 'Je, Ephamarcy Hospital inakubali wanafunzi kwa mafunzo ya vitendo (electives)?',
                'answer_en' => 'Yes. Medical students, nursing interns, and postgraduate fellows can apply through the Directorate of Academic Affairs and Clinical Training.',
                'answer_sw' => 'Ndiyo. Wanafunzi wa udaktari, uuguzi na masomo ya uzamili wanaweza kutuma maombi kupitia Kurugenzi ya Masomo na Mafunzo ya Kitabibu.',
                'category' => 'General',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'question_en' => 'What types of medical services are offered at Ephamarcy Hospital?',
                'question_sw' => 'Ni aina gani za huduma za matibabu zinazotolewa Ephamarcy Hospital?',
                'answer_en' => 'Over 40 clinical specialties including cardiology, kidney transplant, neurosurgery, pediatric surgery, oncology, and intensive care.',
                'answer_sw' => 'Zaidi ya taaluma 40 za kibobezi zikiwemo magonjwa ya moyo, upandikizaji figo, upasuaji wa ubongo, watoto, saratani na wagonjwa mahututi.',
                'category' => 'service',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'question_en' => 'What are the general inpatient visiting hours?',
                'question_sw' => 'Je, ni muda gani rasmi wa kuona wagonjwa waliolazwa wodini?',
                'answer_en' => 'General inpatient visiting sessions are held twice daily: Morning Session: 06:00 - 07:00, and Evening Session: 16:30 - 18:30.',
                'answer_sw' => 'Muda wa kuona wagonjwa waliolazwa ni mara mbili kwa siku: Asubuhi: Saa 12:00 - Saa 01:00 Asubuhi, na Jioni: Saa 10:30 - Saa 12:30 Jioni.',
                'category' => 'Visiting Rules',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'question_en' => 'Which health insurance funds are accepted at Ephamarcy Hospital?',
                'question_sw' => 'Je, hospitali inakubali kadi za bima gani za afya?',
                'answer_en' => 'We accept National Health Insurance Fund (NHIF) for pre-authorized services, along with major private providers including Jubilee Health, Strategis, AAR, NSSF, and corporate schemes.',
                'answer_sw' => 'Tunakubali bima ya Taifa (NHIF) kwa huduma zilizoidhinishwa, pamoja na bima binafsi kama Jubilee, Strategis, AAR, NSSF na mikataba ya mashirika.',
                'category' => 'Billing & Insurance',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question_en' => $faq['question_en']], $faq);
        }
    }
}

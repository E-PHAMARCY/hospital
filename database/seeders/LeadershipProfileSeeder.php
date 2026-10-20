<?php

namespace Database\Seeders;

use App\Models\LeadershipProfile;
use Illuminate\Database\Seeder;

class LeadershipProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'name' => 'Prof. Joseph M. Malecela, MD, PhD',
                'title_en' => 'Chairman of the Board of Governors',
                'title_sw' => 'Mwenyekiti wa Bodi ya Magavana',
                'role_category' => 'Board of Governors',
                'bio_en' => 'Distinguished professor of public health with over 30 years of medical leadership across health policy, governance, and institutional reform.',
                'bio_sw' => 'Profesa mbobezi wa afya ya jamii mwenye uzoefu wa zaidi ya miaka 30 katika uongozi wa sera za afya na utawala bora.',
                'email' => 'board.chair@ephamarcyhosp.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Delilah Charles Kimambo, MD, MMed, MBA',
                'title_en' => 'Executive Director & Chief Executive Officer',
                'title_sw' => 'Mkurugenzi Mtendaji na Mkuu wa Hospitali',
                'role_category' => 'Executive Directorate',
                'bio_en' => 'Senior consultant physician and executive director dedicated to clinical quality, advanced specialized surgery, and continuous medical education at Ephamarcy Hospital.',
                'bio_sw' => 'Daktari bingwa na mkurugenzi mtendaji anayeongoza mageuzi ya kitabibu, ubora wa huduma na upasuaji wa kibobezi.',
                'photo' => 'images/director_dr_delilah.jpg',
                'email' => 'director@ephamarcyhosp.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Lucas V. Mboya, MD, MMed (Surgery)',
                'title_en' => 'Director of Clinical Services & Chief Surgeon',
                'title_sw' => 'Mkurugenzi wa Huduma za Kitabibu na Daktari Bingwa wa Upasuaji',
                'role_category' => 'Executive Directorate',
                'bio_en' => 'Oversees medical divisions, quality assurance protocols, clinical credentialing, and multi-disciplinary specialty coordination.',
                'bio_sw' => 'Anasimamia vitengo vyote vya matibabu, ubora wa huduma na usalama wa wagonjwa hospitalini.',
                'email' => 'clinical.director@ephamarcyhosp.com',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Ms. Catherine A. Mrema, BScN, MSc',
                'title_en' => 'Director of Nursing & Patient Care Services',
                'title_sw' => 'Mkurugenzi wa Huduma za Uuguzi na Uangalizi wa Wagonjwa',
                'role_category' => 'Executive Directorate',
                'bio_en' => 'Leads over 250 nurses and midwives, driving excellence in bedside nursing care, infection control, and empathetic patient advocacy.',
                'bio_sw' => 'Anaongoza wauguzi na wakunga kwa kuzingatia viwango vya juu vya huduma za unesi na usafi wa hospitali.',
                'email' => 'nursing.director@ephamarcyhosp.com',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($profiles as $prof) {
            LeadershipProfile::updateOrCreate(['name' => $prof['name']], $prof);
        }
    }
}

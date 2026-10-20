<?php

namespace Database\Seeders;

use App\Models\Career;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CareerSeeder extends Seeder
{
    public function run(): void
    {
        $cardioDept = Department::where('slug', 'cardiology')->first();
        $pediatricsDept = Department::where('slug', 'pediatrics')->first();

        $careers = [
            [
                'title_en' => 'Specialist Pediatric Intensivist (NICU / PICU)',
                'title_sw' => 'Daktari Bingwa wa Watoto Mahututi (NICU / PICU)',
                'slug' => 'specialist-pediatric-intensivist',
                'department_id' => $pediatricsDept?->id,
                'employment_type' => 'Full-Time',
                'location' => 'Main Medical Campus',
                'description_en' => 'We are seeking an experienced Pediatric Intensivist to lead clinical protocols and resuscitation within our state-of-the-art Neonatal and Pediatric Intensive Care Units.',
                'description_sw' => 'Tunatafuta daktari bingwa mwenye uzoefu wa watoto mahututi kusimamia uangalizi na matibabu ya dharura katika vitengo vyetu vya NICU na PICU.',
                'requirements_en' => 'Master of Medicine (MMed) in Pediatrics, sub-specialty certification in pediatric critical care, active registration with the Medical Council of Tanganyika, minimum 3 years post-fellowship clinical experience.',
                'requirements_sw' => 'Shahada ya Uzamili ya Udaktari wa Watoto (MMed), cheti cha utaalamu wa watoto mahututi, usajili halali wa Baraza la Madaktari Tanganyika, na uzoefu usiopungua miaka 3.',
                'deadline' => Carbon::now()->addDays(25)->toDateString(),
                'application_email' => 'careers@ephamarcyhosp.com',
                'is_active' => true,
            ],
            [
                'title_en' => 'Senior Registered Critical Care Nurse (ICU)',
                'title_sw' => 'Muuguzi Mkuu wa Wagonjwa Mahututi (ICU)',
                'slug' => 'senior-critical-care-nurse-icu',
                'department_id' => $cardioDept?->id,
                'employment_type' => 'Full-Time',
                'location' => 'Main Medical Campus',
                'description_en' => 'Provide specialized hemodynamic bedside monitoring, invasive ventilator management, and medication infusions for complex surgical and medical patients.',
                'description_sw' => 'Kutoa uangalizi maalumu wa wagonjwa mahututi kwenye mashine za kupumulia na kutoa dawa kwa usahihi wa hali ya juu.',
                'requirements_en' => 'Bachelor of Science in Nursing (BScN), Advanced Diploma or Certification in Critical Care Nursing, valid TNMC practicing license, minimum 2 years intensive care bedside nursing experience.',
                'requirements_sw' => 'Shahada ya Uuguzi (BScN), stashahada au cheti cha uuguzi wa wagonjwa mahututi, leseni halali ya Baraza la Wauguzi na Wakunga (TNMC), na uzoefu wa miaka 2 katika ICU.',
                'deadline' => Carbon::now()->addDays(18)->toDateString(),
                'application_email' => 'careers@ephamarcyhosp.com',
                'is_active' => true,
            ],
        ];

        foreach ($careers as $car) {
            Career::updateOrCreate(['slug' => $car['slug']], $car);
        }
    }
}

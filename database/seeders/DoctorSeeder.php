<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $cardioDept = Department::where('slug', 'cardiology')->first();
        $pediatricsDept = Department::where('slug', 'pediatrics')->first();
        $orthoDept = Department::where('slug', 'orthopedics')->first();
        $maternityDept = Department::where('slug', 'maternity-obstetrics')->first();

        $doctors = [
            [
                'name' => 'Dr. David K. Mrema',
                'department_id' => $cardioDept?->id,
                'qualification_en' => 'Chief Consultant Cardiologist, MD, MMed, FESC',
                'qualification_sw' => 'Daktari Bingwa Mkuu wa Magonjwa ya Moyo, MD, MMed',
                'title_en' => 'Head of Cardiovascular Division',
                'title_sw' => 'Mkuu wa Kitengo cha Moyo',
                'email' => 'dr.mrema@ephamarcyhosp.com',
                'phone' => '+255 742 448 965',
                'consultation_days' => ['Monday', 'Wednesday', 'Friday'],
                'consultation_hours' => '08:30 - 13:30',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Amina Z. Hassan',
                'department_id' => $pediatricsDept?->id,
                'qualification_en' => 'Senior Pediatrician & Neonatologist, MD, MMed (Pediatrics)',
                'qualification_sw' => 'Daktari Bingwa wa Watoto na Watoto Wachanga',
                'title_en' => 'Director of Pediatric Services',
                'title_sw' => 'Mkurugenzi wa Huduma za Watoto',
                'email' => 'dr.amina@ephamarcyhosp.com',
                'phone' => '+255 742 448 965',
                'consultation_days' => ['Tuesday', 'Thursday', 'Saturday'],
                'consultation_hours' => '09:00 - 14:00',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Robert J. Chen',
                'department_id' => $orthoDept?->id,
                'qualification_en' => 'Consultant Orthopedic & Arthroscopic Surgeon, MD, FRCS',
                'qualification_sw' => 'Daktari Bingwa wa Upasuaji wa Mifupa na Viungo',
                'title_en' => 'Lead Joint Replacement Surgeon',
                'title_sw' => 'Kiongozi wa Upasuaji wa Viungo',
                'email' => 'dr.chen@ephamarcyhosp.com',
                'phone' => '+255 742 448 965',
                'consultation_days' => ['Monday', 'Tuesday', 'Thursday'],
                'consultation_hours' => '10:00 - 15:00',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Grace N. Ndlovu',
                'department_id' => $maternityDept?->id,
                'qualification_en' => 'Senior Consultant Obstetrician & Gynecologist, MD, MMed',
                'qualification_sw' => 'Daktari Bingwa Mkuu wa Uzazi na Afya ya Wanawake',
                'title_en' => 'Head of Maternal Care',
                'title_sw' => 'Mkuu wa Huduma za Uzazi Salama',
                'email' => 'dr.grace@ephamarcyhosp.com',
                'phone' => '+255 742 448 965',
                'consultation_days' => ['Wednesday', 'Thursday', 'Friday'],
                'consultation_hours' => '08:00 - 13:00',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($doctors as $doc) {
            Doctor::updateOrCreate(['name' => $doc['name']], $doc);
        }
    }
}

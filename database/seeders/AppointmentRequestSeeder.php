<?php

namespace Database\Seeders;

use App\Models\AppointmentRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppointmentRequestSeeder extends Seeder
{
    public function run(): void
    {
        $cardioDept = Department::where('slug', 'cardiology')->first();
        $pediatricsDept = Department::where('slug', 'pediatrics')->first();
        $orthoDept = Department::where('slug', 'orthopedics')->first();

        $drMrema = Doctor::where('name', 'like', '%Mrema%')->first();
        $drAmina = Doctor::where('name', 'like', '%Amina%')->first();
        $drChen = Doctor::where('name', 'like', '%Chen%')->first();

        $requests = [
            [
                'reference_number' => 'APT-2026-9041',
                'patient_name' => 'Neema Emmanuel Lyimo',
                'patient_email' => 'neema.lyimo@example.com',
                'patient_phone' => '+255 754 112 233',
                'department_id' => $cardioDept?->id,
                'doctor_id' => $drMrema?->id,
                'preferred_date' => Carbon::now()->addDays(2)->toDateString(),
                'preferred_time' => 'Morning (08:00 - 12:00)',
                'reason' => 'Routine cardiology follow-up and blood pressure management review.',
                'status' => 'pending',
                'admin_notes' => null,
            ],
            [
                'reference_number' => 'APT-2026-9042',
                'patient_name' => 'Kelvin Baraka Mwamba',
                'patient_email' => 'kelvin.mwamba@example.com',
                'patient_phone' => '+255 768 445 566',
                'department_id' => $orthoDept?->id,
                'doctor_id' => $drChen?->id,
                'preferred_date' => Carbon::now()->addDays(4)->toDateString(),
                'preferred_time' => 'Afternoon (13:00 - 17:00)',
                'reason' => 'Persistent knee pain after sports activity; MRI scans brought from outside.',
                'status' => 'confirmed',
                'admin_notes' => 'Confirmed with patient. Advised to arrive 15 minutes before slot.',
            ],
            [
                'reference_number' => 'APT-2026-9043',
                'patient_name' => 'Zuhura Bakari Mwinyi',
                'patient_email' => 'zuhura.mwinyi@example.com',
                'patient_phone' => '+255 712 998 877',
                'department_id' => $pediatricsDept?->id,
                'doctor_id' => $drAmina?->id,
                'preferred_date' => Carbon::now()->addDays(1)->toDateString(),
                'preferred_time' => 'Morning (08:00 - 12:00)',
                'reason' => 'Pediatric developmental checkup for 18-month-old infant.',
                'status' => 'pending',
                'admin_notes' => null,
            ],
        ];

        foreach ($requests as $req) {
            AppointmentRequest::updateOrCreate(['reference_number' => $req['reference_number']], $req);
        }
    }
}

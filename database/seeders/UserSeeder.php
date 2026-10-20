<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@ephamarcyhosp.com',
                'name' => 'Hospital Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'superadmin@ephamarcyhosp.com',
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'deptmanager@ephamarcyhosp.com',
                'name' => 'Clinical Department Manager',
                'password' => Hash::make('password'),
                'role' => 'dept_manager',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'appointments@ephamarcyhosp.com',
                'name' => 'Patient Appointments Officer',
                'password' => Hash::make('password'),
                'role' => 'appointment_officer',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'editor@ephamarcyhosp.com',
                'name' => 'Content & Publications Editor',
                'password' => Hash::make('password'),
                'role' => 'content_editor',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'staff@ephamarcyhosp.com',
                'name' => 'Clinical Triage Officer',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
            [
                'email' => 'dr.sarah@ephamarcyhosp.com',
                'name' => 'Dr. Sarah K. Temu, MD',
                'password' => Hash::make('password'),
                'role' => 'doctor',
                'phone' => '+255 742 448 965',
                'is_active' => true,
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], $u);
        }
    }
}

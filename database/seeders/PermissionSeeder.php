<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'manage_settings', 'label' => 'Manage Hospital Settings & Branding', 'group' => 'system'],
            ['name' => 'manage_users', 'label' => 'Manage Staff & User Accounts', 'group' => 'system'],
            ['name' => 'view_audit_logs', 'label' => 'View System Audit Logs', 'group' => 'system'],
            ['name' => 'manage_departments', 'label' => 'Manage Clinical Departments', 'group' => 'clinical'],
            ['name' => 'manage_services', 'label' => 'Manage Medical Services', 'group' => 'clinical'],
            ['name' => 'manage_doctors', 'label' => 'Manage Doctors & Specialists Directory', 'group' => 'clinical'],
            ['name' => 'manage_appointments', 'label' => 'Manage & Triage Patient Appointments', 'group' => 'appointments'],
            ['name' => 'manage_inquiries', 'label' => 'Manage & Reply to Visitor Inquiries', 'group' => 'communications'],
            ['name' => 'manage_content', 'label' => 'Create & Edit Public Website Content', 'group' => 'content'],
            ['name' => 'publish_content', 'label' => 'Publish & Authorize Public Content', 'group' => 'content'],
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(['name' => $perm['name']], $perm);
        }

        // Assign to roles
        $allPermIds = Permission::pluck('id')->toArray();
        $contentPermIds = Permission::whereIn('name', ['manage_content', 'publish_content'])->pluck('id')->toArray();
        $appointmentPermIds = Permission::whereIn('name', ['manage_appointments', 'manage_inquiries'])->pluck('id')->toArray();
        $clinicalPermIds = Permission::whereIn('name', ['manage_departments', 'manage_services', 'manage_doctors', 'manage_appointments'])->pluck('id')->toArray();

        // 1. Super Admin gets all
        foreach ($allPermIds as $pId) {
            DB::table('role_permissions')->updateOrInsert(['role' => 'super_admin', 'permission_id' => $pId]);
            DB::table('role_permissions')->updateOrInsert(['role' => 'admin', 'permission_id' => $pId]);
        }

        // 2. Department Manager
        foreach ($clinicalPermIds as $pId) {
            DB::table('role_permissions')->updateOrInsert(['role' => 'dept_manager', 'permission_id' => $pId]);
        }

        // 3. Appointment Officer
        foreach ($appointmentPermIds as $pId) {
            DB::table('role_permissions')->updateOrInsert(['role' => 'appointment_officer', 'permission_id' => $pId]);
            DB::table('role_permissions')->updateOrInsert(['role' => 'staff', 'permission_id' => $pId]);
        }

        // 4. Content Editor
        foreach ($contentPermIds as $pId) {
            DB::table('role_permissions')->updateOrInsert(['role' => 'content_editor', 'permission_id' => $pId]);
        }
    }
}

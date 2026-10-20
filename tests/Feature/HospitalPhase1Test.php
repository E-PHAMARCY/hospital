<?php

namespace Tests\Feature;

use App\Models\AppointmentRequest;
use App\Models\ContactInquiry;
use App\Models\Department;
use App\Models\User;
use Tests\TestCase;

class HospitalPhase1Test extends TestCase
{
    public function test_homepage_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ephamarcy Hospital');
    }

    public function test_language_switcher_switches_session_locale(): void
    {
        $response = $this->get('/language/sw');
        $response->assertSessionHas('locale', 'sw');

        $responseEn = $this->get('/language/en');
        $responseEn->assertSessionHas('locale', 'en');
    }

    public function test_appointment_booking_page_is_accessible(): void
    {
        $response = $this->get('/appointment');
        $response->assertStatus(200);
        $response->assertSee('Outpatient Scheduling');
    }

    public function test_appointment_can_be_submitted(): void
    {
        $dept = Department::first();

        $response = $this->post('/appointment', [
            'patient_name' => 'Test Patient',
            'patient_email' => 'patient@test.com',
            'patient_phone' => '+255 711 000 111',
            'department_id' => $dept?->id,
            'preferred_date' => now()->addDays(3)->toDateString(),
            'preferred_time' => 'Morning (08:00 - 12:00)',
            'reason' => 'Routine cardiology consultation test.',
        ]);

        $response->assertSessionHas('appointment_success');
        $this->assertDatabaseHas('appointment_requests', [
            'patient_name' => 'Test Patient',
            'patient_email' => 'patient@test.com',
        ]);
    }

    public function test_contact_inquiry_can_be_submitted(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Inquiry Tester',
            'email' => 'tester@test.com',
            'phone' => '+255 722 000 333',
            'subject' => 'Clinic Timing Inquiry',
            'message' => 'Are outpatient consultations available on Sunday?',
        ]);

        $response->assertSessionHas('contact_success', true);
        $this->assertDatabaseHas('contact_inquiries', [
            'email' => 'tester@test.com',
            'subject' => 'Clinic Timing Inquiry',
        ]);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Staff & Admin Portal', false);
    }

    public function test_admin_dashboard_requires_authentication(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_user_can_access_dashboard(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ephamarcy Hospital');
    }

    public function test_admin_appointments_management_is_accessible(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin/appointments');
        $response->assertStatus(200);
        $response->assertSee('Appointments & Patient Scheduling');
    }

    public function test_admin_inquiries_management_is_accessible(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin/inquiries');
        $response->assertStatus(200);
        $response->assertSee('Visitor & Patient Inquiries');
    }

    public function test_appointment_tracking_is_accessible(): void
    {
        $response = $this->get('/appointment/track');
        $response->assertStatus(200);
        $response->assertSee('Track Appointment Status');
    }

    public function test_doctors_directory_is_accessible(): void
    {
        $response = $this->get('/doctors');
        $response->assertStatus(200);
        $response->assertSee('Medical Faculty');
    }

    public function test_departments_directory_is_accessible(): void
    {
        $response = $this->get('/departments');
        $response->assertStatus(200);
    }

    public function test_services_directory_is_accessible(): void
    {
        $response = $this->get('/services');
        $response->assertStatus(200);
    }

    public function test_resources_directory_and_download_are_functional(): void
    {
        $response = $this->get('/resources');
        $response->assertStatus(200);

        $resource = \App\Models\Resource::where('is_active', true)->first();
        if ($resource) {
            $downloadResponse = $this->get("/resources/{$resource->id}/download");
            $downloadResponse->assertStatus(200);
        }
    }

    public function test_news_directory_is_accessible(): void
    {
        $response = $this->get('/news');
        $response->assertStatus(200);
    }

    public function test_institutional_pages_are_accessible(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);

        $patientResponse = $this->get('/patients');
        $patientResponse->assertStatus(200);
    }

    public function test_search_returns_successful_response(): void
    {
        $response = $this->get('/search?q=cardiology');
        $response->assertStatus(200);
        $response->assertSee('Hospital Information Search');
    }

    public function test_admin_doctors_and_resources_are_accessible(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $responseDoc = $this->actingAs($admin)->get('/admin/doctors');
        $responseDoc->assertStatus(200);

        $responseRes = $this->actingAs($admin)->get('/admin/resources');
        $responseRes->assertStatus(200);

        $responseNews = $this->actingAs($admin)->get('/admin/news');
        $responseNews->assertStatus(200);

        $responseSettings = $this->actingAs($admin)->get('/admin/settings');
        $responseSettings->assertStatus(200);
        $responseSettings->assertSee('Hospital Identity & Operations', false);
    }

    public function test_admin_settings_can_be_updated(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'hospital_name_en' => 'Ephamarcy Apex Hospital',
            'hospital_name_sw' => 'Hospitali Kuu ya Ephamarcy',
            'tagline_en' => 'Excellence in Medical Care',
            'emergency_phone' => '+255 799 111 222',
            'official_email' => 'contact@ephamarcyhosp.com',
        ]);

        $response->assertRedirect('/admin/settings');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('hospital_settings', [
            'key' => 'emergency_phone',
            'value' => '+255 799 111 222',
        ]);
    }

    public function test_ai_assistant_responds_to_queries(): void
    {
        $response = $this->postJson('/ai/ask', [
            'message' => 'Where are you located in Arusha?',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $response->assertJsonFragment([
            'label' => 'Open in Google Maps',
        ]);
    }

    public function test_homepage_and_footer_display_ai_and_sombetini_location(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ask Ephamarcy AI', false);
        $response->assertSee('Sombetini', false);
        $response->assertSee('Ukumbi wa Diwani', false);
    }
}


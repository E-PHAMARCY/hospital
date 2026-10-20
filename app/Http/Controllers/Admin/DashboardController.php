<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentRequest;
use App\Models\Career;
use App\Models\ContactInquiry;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\HealthArticle;
use App\Models\News;
use App\Models\Resource;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_appointments' => AppointmentRequest::count(),
            'pending_appointments' => AppointmentRequest::where('status', 'pending')->count(),
            'total_inquiries' => ContactInquiry::count(),
            'new_inquiries' => ContactInquiry::where('status', 'new')->count(),
            'total_doctors' => Doctor::where('is_active', true)->count(),
            'total_departments' => Department::where('is_active', true)->count(),
            'total_services' => Service::where('is_active', true)->count(),
            'total_news' => News::count(),
            'total_careers' => Career::where('is_active', true)->count(),
            'total_health_articles' => HealthArticle::count(),
            'total_resources' => Resource::count(),
            'total_staff' => User::where('is_active', true)->count(),
        ];

        $recentAppointments = AppointmentRequest::with(['department', 'doctor'])
            ->latest()
            ->take(6)
            ->get();

        $recentInquiries = ContactInquiry::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAppointments', 'recentInquiries'));
    }
}

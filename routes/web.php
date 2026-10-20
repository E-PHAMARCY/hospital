<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\HealthEducationController as AdminHealthEducationController;
use App\Http\Controllers\Admin\HomepageController as AdminHomepageController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AiAssistantController;
use App\Models\HospitalSetting;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HealthEducationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicAppointmentController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TenderController;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\LeadershipProfile;
use App\Models\Location;
use App\Models\News;
use App\Models\Resource;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Language Switcher
|--------------------------------------------------------------------------
*/
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $announcements = Announcement::where('is_active', true)->latest()->take(5)->get();
    $departments = Department::where('is_active', true)->orderBy('sort_order')->take(8)->get();
    $services = Service::where('is_active', true)->orderBy('sort_order')->take(10)->get();
    $emergencyServices = Service::where('is_active', true)->where('is_emergency', true)->take(4)->get();
    $doctors = Doctor::where('is_active', true)->with('department')->orderBy('sort_order')->take(8)->get();
    $latestNews = News::where('is_published', true)->latest('published_at')->take(4)->get();
    $headlines = News::where('is_published', true)->latest('published_at')->take(6)->get();
    $resources = Resource::where('is_active', true)->latest()->take(4)->get();
    $faqs = Faq::where('is_active', true)->orderBy('sort_order')->take(6)->get();
    $locations = Location::where('is_active', true)->orderBy('sort_order')->take(6)->get();
    $director = LeadershipProfile::where('is_active', true)->where('role_category', 'like', '%Executive%')->first() 
                ?? LeadershipProfile::where('is_active', true)->first();

    // Dynamic Homepage CMS Material
    $heroSlides = json_decode(HospitalSetting::get('homepage_hero_slides', '[]'), true) ?: [];
    $directorStatement = json_decode(HospitalSetting::get('homepage_director', '{}'), true) ?: [];
    $homepageVideos = json_decode(HospitalSetting::get('homepage_videos', '[]'), true) ?: [];
    $ticker = json_decode(HospitalSetting::get('homepage_ticker', '{}'), true) ?: [];
    $stats = json_decode(HospitalSetting::get('homepage_stats', '{}'), true) ?: [];
    $coreValues = json_decode(HospitalSetting::get('homepage_core_values', '[]'), true) ?: [];
    $insurancePartners = json_decode(HospitalSetting::get('homepage_insurance_partners', '[]'), true) ?: [];

    return view('welcome', compact(
        'announcements',
        'departments',
        'services',
        'emergencyServices',
        'doctors',
        'latestNews',
        'headlines',
        'resources',
        'faqs',
        'locations',
        'director',
        'heroSlides',
        'directorStatement',
        'homepageVideos',
        'ticker',
        'stats',
        'coreValues',
        'insurancePartners'
    ));
})->name('home');

// Outpatient Appointments
Route::get('/appointment', [PublicAppointmentController::class, 'create'])->name('appointments.create');
Route::post('/appointment', [PublicAppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointment/confirmation', [PublicAppointmentController::class, 'confirmation'])->name('appointments.confirmation');
Route::get('/appointment/track', [PublicAppointmentController::class, 'track'])->name('appointments.track');

// Visitor Inquiries & Contact
Route::get('/contact', [PublicContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');

// Clinical Doctors & Faculty
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');

// Clinical Departments
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{slug}', [DepartmentController::class, 'show'])->name('departments.show');

// Clinical & Diagnostic Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// News & Bulletins
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Public Announcements
Route::get('/announcements', [NewsController::class, 'announcements'])->name('announcements.index');
Route::get('/announcements/{id}', [NewsController::class, 'announcementShow'])->name('announcements.show');

// Health Education & Wellness
Route::get('/health-education', [HealthEducationController::class, 'index'])->name('health-education.index');
Route::get('/health-education/{slug}', [HealthEducationController::class, 'show'])->name('health-education.show');

// Downloadable Patient Resources
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{id}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/resources/{id}/download', [ResourceController::class, 'download'])->name('resources.download');

// Institutional Search
Route::get('/search', [SearchController::class, 'search'])->name('search');

// AI Health & Hospital Assistant ("Ask Me Anything")
Route::post('/ai/ask', [AiAssistantController::class, 'ask'])->name('ai.ask');

// Newsletter Subscription
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Careers & Tenders
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/{slug}', [CareerController::class, 'show'])->name('careers.show');
Route::get('/tenders', [TenderController::class, 'index'])->name('tenders.index');
Route::get('/tenders/{slug}', [TenderController::class, 'show'])->name('tenders.show');

// Hospital Campus Locations
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('/locations/{slug}', [LocationController::class, 'show'])->name('locations.show');

// Institutional Static/Dynamic Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/about/{section}', [PageController::class, 'about'])->name('about.section');
Route::get('/patients', [PageController::class, 'patients'])->name('patients');
Route::get('/patients/{section}', [PageController::class, 'patients'])->name('patients.section');
Route::get('/legal/{slug}', [PageController::class, 'legal'])->name('legal');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::redirect('/admin/login', '/login');
Route::redirect('/admin', '/admin/dashboard');

/*
|--------------------------------------------------------------------------
| Administrative Dashboard Routes (Role-Guarded: admin, staff)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,staff,super_admin,dept_manager,appointment_officer,content_editor'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Appointments Triage
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');

    // Inquiries Management
    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::patch('/inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.status');

    // Clinical Departments Management
    Route::get('/departments', [AdminDepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [AdminDepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{department}', [AdminDepartmentController::class, 'update'])->name('departments.update');
    Route::patch('/departments/{department}/status', [AdminDepartmentController::class, 'toggleStatus'])->name('departments.status');
    Route::delete('/departments/{department}', [AdminDepartmentController::class, 'destroy'])->name('departments.destroy');

    // Clinical Services Management
    Route::get('/services', [AdminServiceController::class, 'index'])->name('services.index');
    Route::post('/services', [AdminServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::patch('/services/{service}/status', [AdminServiceController::class, 'toggleStatus'])->name('services.status');
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');

    // Doctors & Specialists Management
    Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors', [AdminDoctorController::class, 'store'])->name('doctors.store');
    Route::put('/doctors/{doctor}', [AdminDoctorController::class, 'update'])->name('doctors.update');
    Route::patch('/doctors/{doctor}/status', [AdminDoctorController::class, 'toggleStatus'])->name('doctors.status');
    Route::delete('/doctors/{doctor}', [AdminDoctorController::class, 'destroy'])->name('doctors.destroy');

    // Health Education & Wellness Articles
    Route::get('/health-education', [AdminHealthEducationController::class, 'index'])->name('health-education.index');
    Route::post('/health-education', [AdminHealthEducationController::class, 'store'])->name('health-education.store');
    Route::put('/health-education/{healthArticle}', [AdminHealthEducationController::class, 'update'])->name('health-education.update');
    Route::patch('/health-education/{healthArticle}/status', [AdminHealthEducationController::class, 'toggleStatus'])->name('health-education.status');
    Route::delete('/health-education/{healthArticle}', [AdminHealthEducationController::class, 'destroy'])->name('health-education.destroy');

    // Patient Resources & Institutional Publications
    Route::get('/resources', [AdminResourceController::class, 'index'])->name('resources.index');
    Route::post('/resources', [AdminResourceController::class, 'store'])->name('resources.store');
    Route::put('/resources/{resource}', [AdminResourceController::class, 'update'])->name('resources.update');
    Route::patch('/resources/{resource}/status', [AdminResourceController::class, 'toggleStatus'])->name('resources.status');
    Route::delete('/resources/{resource}', [AdminResourceController::class, 'destroy'])->name('resources.destroy');

    // Careers & Medical Vacancies
    Route::get('/careers', [AdminCareerController::class, 'index'])->name('careers.index');
    Route::post('/careers', [AdminCareerController::class, 'store'])->name('careers.store');
    Route::put('/careers/{career}', [AdminCareerController::class, 'update'])->name('careers.update');
    Route::patch('/careers/{career}/status', [AdminCareerController::class, 'toggleStatus'])->name('careers.status');
    Route::delete('/careers/{career}', [AdminCareerController::class, 'destroy'])->name('careers.destroy');

    // News & Operational Announcements
    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::post('/news/article', [AdminNewsController::class, 'storeNews'])->name('news.store');
    Route::put('/news/{news}', [AdminNewsController::class, 'updateNews'])->name('news.update');
    Route::patch('/news/{news}/status', [AdminNewsController::class, 'toggleNews'])->name('news.status');
    Route::delete('/news/{news}', [AdminNewsController::class, 'destroyNews'])->name('news.destroy');
    Route::post('/news/announcement', [AdminNewsController::class, 'storeAnnouncement'])->name('news.announcements.store');
    Route::put('/news/announcements/{announcement}', [AdminNewsController::class, 'updateAnnouncement'])->name('news.announcements.update');
    Route::patch('/news/announcements/{announcement}/status', [AdminNewsController::class, 'toggleAnnouncement'])->name('news.announcements.status');
    Route::delete('/news/announcements/{announcement}', [AdminNewsController::class, 'destroyAnnouncement'])->name('news.announcements.destroy');

    // FAQs Knowledge Base Management
    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('faqs.index');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('faqs.store');
    Route::put('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('faqs.update');
    Route::patch('/faqs/{faq}/status', [AdminFaqController::class, 'toggleStatus'])->name('faqs.status');
    Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('faqs.destroy');

    // Hospital Campuses & Locations Management
    Route::get('/locations', [AdminLocationController::class, 'index'])->name('locations.index');
    Route::post('/locations', [AdminLocationController::class, 'store'])->name('locations.store');
    Route::put('/locations/{location}', [AdminLocationController::class, 'update'])->name('locations.update');
    Route::patch('/locations/{location}/status', [AdminLocationController::class, 'toggleStatus'])->name('locations.status');
    Route::delete('/locations/{location}', [AdminLocationController::class, 'destroy'])->name('locations.destroy');

    // Homepage Materials & Dynamic Content Editor
    Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage.index');
    Route::post('/homepage/hero', [AdminHomepageController::class, 'updateHero'])->name('homepage.hero');
    Route::post('/homepage/director', [AdminHomepageController::class, 'updateDirector'])->name('homepage.director');
    Route::post('/homepage/videos', [AdminHomepageController::class, 'updateVideos'])->name('homepage.videos');
    Route::post('/homepage/ticker', [AdminHomepageController::class, 'updateTicker'])->name('homepage.ticker');
    Route::post('/homepage/stats', [AdminHomepageController::class, 'updateStats'])->name('homepage.stats');
    Route::post('/homepage/values', [AdminHomepageController::class, 'updateCoreValues'])->name('homepage.values');
    Route::post('/homepage/insurance', [AdminHomepageController::class, 'updateInsurancePartners'])->name('homepage.insurance');

    // Staff Accounts & Security Privileges (Guarded for Admins)
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/status', [AdminUserController::class, 'toggleStatus'])->name('users.status');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Hospital Identity, Emergency Hotlines & System Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

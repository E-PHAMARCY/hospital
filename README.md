# Apex Health Regional Hospital — Web Platform (Phase 1)

An independent, enterprise-grade tertiary referral hospital web application built with **Laravel 11**, **PHP 8.2+**, **MySQL**, **Tailwind CSS**, **Alpine.js**, and **Vite**.

> **Note on Client Inspiration:** This project is an independent hospital platform. Muhimbili National Hospital was provided solely as a structural inspiration reference; all branding, services, specialists, and demonstrative content are independently configured for Apex Health Regional Hospital.

---

## 🛠 Technology Stack

- **Backend Framework:** Laravel 11.57.0 (PHP 8.2+)
- **Database Engine:** MySQL 8.x (managed via Eloquent ORM & migrations)
- **Frontend Templating:** Blade Templates
- **Styling & Design System:** Tailwind CSS v3 with curated medical color tokens (Teal, Navy, Emerald, Coral Red)
- **Micro-Interactions:** Alpine.js
- **Asset Bundler:** Vite 5 + Laravel Vite Plugin
- **Localization:** Full English (`en`) & Swahili (`sw`) bilingual support with dynamic session switching

---

## 📁 Project Architecture & Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php             # Staff/admin authentication with rate limiting
│   │   │   ├── LanguageController.php         # Session-based EN/SW language switcher
│   │   │   ├── PublicAppointmentController.php# Patient outpatient booking, confirmation & status tracking
│   │   │   ├── PublicContactController.php    # Public visitor inquiries handler
│   │   │   ├── DoctorController.php           # Medical specialists directory & faculty profiles
│   │   │   ├── DepartmentController.php       # Clinical department directories & specialty info
│   │   │   ├── ServiceController.php          # Diagnostic & clinical procedure services
│   │   │   ├── NewsController.php             # Hospital news bulletins & operational notices
│   │   │   ├── ResourceController.php         # Patient rights charters & real document downloads
│   │   │   ├── HealthEducationController.php  # Public wellness & health guidance articles
│   │   │   ├── SearchController.php           # Comprehensive multi-entity hospital search engine
│   │   │   ├── CareerController.php           # Job openings & vacancies portal
│   │   │   ├── TenderController.php           # Public procurement & tender notices
│   │   │   ├── LocationController.php         # Satellite clinics & campus locator
│   │   │   ├── PageController.php             # Institutional pages (About, Patients, Legal, Sitemap)
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php    # Admin metrics & recent activity feeds
│   │   │       ├── AppointmentController.php  # Admin triage & appointment status workflow
│   │   │       ├── InquiryController.php      # Admin visitor inquiries management
│   │   │       ├── DoctorController.php       # Specialist doctors registration & status toggle
│   │   │       ├── ResourceController.php     # Patient guides & publications publisher
│   │   │       └── NewsController.php         # Hospital news & emergency ticker broadcast
│   │   └── Middleware/
│   │       ├── SetLocale.php                  # Applies active locale per request
│   │       └── EnsureRole.php                 # Role-based authorization guard ('admin', 'staff')
│   └── Models/
│       ├── User.php                           # User entity with role & status helpers
│       ├── HospitalSetting.php                # Key-value persistent settings with caching
│       ├── Page.php                           # Localized static/dynamic hospital pages
│       ├── Department.php                     # Clinical hospital departments
│       ├── Service.php                        # Clinical diagnostic & emergency services
│       ├── Doctor.php                         # Specialist consultants & schedules
│       ├── News.php                           # Health articles & news bulletins
│       ├── Announcement.php                   # Urgent & public operational banners
│       ├── Resource.php                       # Downloadable patient guides & charters
│       ├── AppointmentRequest.php             # Patient booking requests & reference tracking
│       ├── ContactInquiry.php                 # General patient & visitor inquiries
│       └── ...                                # Careers, Tenders, Locations, FAQs, Leadership
├── database/
│   ├── migrations/                            # Schema migrations for all 24 domain entities
│   └── seeders/                               # Demonstration seeders for all models
├── lang/
│   ├── en/hospital.php                        # English medical dictionary & navigation
│   └── sw/hospital.php                        # Swahili medical dictionary & navigation
├── resources/
│   ├── css/app.css                            # Medical design system tokens & typography
│   ├── js/app.js                              # Alpine.js initialization & bootstrap
│   └── views/
│       ├── components/                        # 15 reusable Blade components (button, card, badge, input, etc.)
│       ├── layouts/
│       │   ├── public.blade.php               # Public responsive healthcare website layout
│       │   └── admin.blade.php                # Role-guarded administrative dashboard layout
│       ├── auth/login.blade.php               # Staff & admin portal login
│       ├── admin/                             # Admin console views (dashboard, appointments, inquiries, doctors, resources, news)
│       ├── appointments/                      # Booking (create), confirmation, and real-time status tracker (track)
│       ├── contact/index.blade.php            # Public contact & directions view
│       ├── resources/                         # Real downloadable documents & previews
│       ├── doctors/, departments/, services/  # Clinical care directories & profiles
│       ├── news/, announcements/, pages/      # Editorial, alerts, and institutional pages
│       └── welcome.blade.php                  # Medical hero, departments, services, doctors, news
└── tests/Feature/HospitalPhase1Test.php       # Automated end-to-end verification test suite
```

---

## 🚀 Environment Requirements

- **PHP:** 8.2 or higher (with `pdo_mysql`, `mbstring`, `openssl`, `curl`)
- **Composer:** 2.x
- **Node.js:** 18.x or 20.x+ (tested on Node v24)
- **npm:** 10.x or higher
- **MySQL:** 8.0+ or MariaDB 10.4+ (running on port `3306`)

---

## ⚙️ Installation & Setup Instructions

### 1. Configure MySQL Database
Ensure MySQL service is running on `127.0.0.1:3306`. Create the database if not already present:
```sql
CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Configure Environment (`.env`)
Verify the `.env` database parameters:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 3. Install Backend & Frontend Dependencies
```bash
composer install
npm install
```

### 4. Run Migrations & Seeders
Execute database migrations and populate demonstration clinical data:
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Frontend Assets
Compile Tailwind CSS and Alpine.js assets using Vite:
```bash
npm run build
```
*(Or use `npm run dev` during active frontend development).*

### 6. Run Automated Test Suite
Verify that all 12 feature and unit test assertions pass:
```bash
php artisan test
```

### 7. Start the Development Server
```bash
php artisan serve
```
The application will be live at `http://127.0.0.1:8000`.

---

## 🔑 Demonstration Accounts & Credentials

The application includes pre-seeded demonstration accounts for administrative testing:

| Role | Email | Password | Permissions |
| :--- | :--- | :--- | :--- |
| **System Administrator** | `admin@apexhealth.demo` | `password` | Full dashboard, appointments triage, inquiries, and settings |
| **Triage / Staff Officer** | `staff@apexhealth.demo` | `password` | Appointments management and inquiries triage |
| **Consultant Doctor** | `dr.sarah@apexhealth.demo` | `password` | Medical specialist staff profile |

---

## 🌐 Localization (English / Kiswahili)

Switch languages dynamically at any time using the header toggle or directly via:
- **English:** `http://127.0.0.1:8000/language/en`
- **Kiswahili:** `http://127.0.0.1:8000/language/sw`

All navigation, emergency alerts, department descriptions, doctor qualifications, and patient form labels switch instantly based on session state.

---

## 🛡️ Security Features
- **Role-Based Authorization:** Custom `EnsureRole` middleware guarding all `/admin/*` routes.
- **Brute-Force Protection:** Rate-limiting enabled on the login form (5 attempts per minute).
- **Session Security:** Full session regeneration and CSRF protection on all mutating actions.
- **Deactivated User Interception:** Automatically logs out and prevents access for any deactivated account.

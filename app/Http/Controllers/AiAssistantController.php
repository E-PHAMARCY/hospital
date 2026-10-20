<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\HospitalSetting;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AiAssistantController extends Controller
{
    /**
     * Handle AI Assistant inquiries on the homepage and across the portal.
     */
    public function ask(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $query = trim($request->input('message'));
        $lower = mb_strtolower($query);
        $locale = app()->getLocale();
        $isSwahili = ($locale === 'sw') || Str::contains($lower, [
            'habari', 'daktari', 'wapi', 'hospitali', 'huduma', 'soma', 'bei', 
            'muda', 'bima', 'dharura', 'namba', 'simu', 
            'saangapi', 'lini', 'nawezaje', 'kadi', 'matibabu', 'ugonjwa'
        ]);

        // Load active hospital context
        $hospitalName = HospitalSetting::get('hospital_name_' . ($isSwahili ? 'sw' : 'en'), 'Ephamarcy Hospital');
        $location = 'Sombetini, Ukumbi wa Diwani, Arusha, Tanzania';
        $emergencyPhone = HospitalSetting::get('emergency_phone', '+255742448965');
        $receptionPhone = HospitalSetting::get('reception_phone', '+255742448965');
        $opdHours = HospitalSetting::get('working_hours_opd', 'Monday - Sunday, 07:30 - 20:00');
        $visitingWeekdays = HospitalSetting::get('visiting_hours_weekdays', '06:00AM - 07:00AM | 12:30PM - 02:00PM | 04:00PM - 06:00PM');
        $visitingWeekends = HospitalSetting::get('visiting_hours_weekends', '12:00PM - 02:00PM');

        $actions = [];
        $answer = '';

        // 1. Location & Campus directions
        if (Str::contains($lower, ['where', 'location', 'located', 'place', 'address', 'directions', 'map', 'wapi', 'mahali', 'arusha', 'sombetini', 'ukumbi', 'diwani', 'barabara'])) {
            if ($isSwahili) {
                $answer = "{$hospitalName} inapatikana **{$location}**.\n\nTuko wazi kwa huduma zote za matibabu ya ubingwa, uchunguzi wa maabara na vipimo, na kitengo cha dharura kinachofanya kazi saa 24 kila siku.";
            } else {
                $answer = "{$hospitalName} is located at **{$location}**.\n\nOur medical center is fully accessible with ample parking, comprehensive diagnostic imaging, modern surgical suites, and a 24/7 emergency resuscitation trauma unit.";
            }
            $actions[] = ['label' => $isSwahili ? 'Fungua Google Maps' : 'Open in Google Maps', 'url' => 'https://maps.google.com/?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania', 'external' => true];
            $actions[] = ['label' => $isSwahili ? 'Wasiliana Nasi' : 'Contact Us', 'url' => route('contact.index')];
        }

        // 2. Emergency & Ambulance
        elseif (Str::contains($lower, ['emergency', 'ambulance', 'urgent', 'dharura', 'ajali', 'gari la wagonjwa', 'resuscitation', 'trauma', 'critical'])) {
            if ($isSwahili) {
                $answer = "🚨 **Kitengo cha Dharura cha {$hospitalName} kinafanya kazi saa 24/7 (kila siku bila mapumziko)** hapa **Sombetini (Ukumbi wa Diwani), Arusha**.\n\nKwa dharura yoyote ya matibabu au uhitaji wa gari la wagonjwa (ambulance), piga simu mara moja:";
            } else {
                $answer = "🚨 **Emergency Care & Ambulance Dispatch are operational 24/7 everyday** at our Sombetini (Ukumbi wa Diwani), Arusha campus.\n\nFor immediate emergency response, resuscitation, or ambulance dispatch, call our direct emergency hotline:";
            }
            $actions[] = ['label' => '📞 ' . ($isSwahili ? 'Piga Simu ya Dharura: ' : 'Call Emergency: ') . $emergencyPhone, 'url' => 'tel:' . preg_replace('/[^0-9+]/', '', $emergencyPhone)];
            $actions[] = ['label' => $isSwahili ? 'Maelekezo ya Sombetini' : 'Get Directions to Emergency', 'url' => 'https://maps.google.com/?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania', 'external' => true];
        }

        // 3. Appointments & Booking
        elseif (Str::contains($lower, ['appointment', 'book', 'booking', 'see a doctor', 'schedule', 'miadi', 'kuona daktari', 'ratiba', 'nafasi', 'pangia'])) {
            if ($isSwahili) {
                $answer = "Unaweza kukata miadi ya kumuona daktari bingwa mtandaoni kwa urahisi kupitia tovuti yetu.\n\nChagua kitengo cha matibabu, daktari unayependelea, tarehe na muda unaokufaa. Utapokea namba ya kumbukumbu (Reference Number) ya kufuatilia miadi yako.";
            } else {
                $answer = "You can easily schedule an outpatient consultation with our medical specialists online.\n\nSimply select your clinical department or physician, pick your preferred date and time, and you will receive an instant Reference Number to track your appointment.";
            }
            $actions[] = ['label' => $isSwahili ? 'Weka Miadi Sasa' : 'Book Appointment Online', 'url' => route('appointments.create')];
            $actions[] = ['label' => $isSwahili ? 'Fuatilia Miadi' : 'Track Existing Appointment', 'url' => route('appointments.track')];
        }

        // 4. Visiting Hours
        elseif (Str::contains($lower, ['visit', 'visiting', 'hours', 'time', 'kuona wagonjwa', 'muda', 'saa ngapi', 'kuona']) && Str::contains($lower, ['visit', 'hours', 'time', 'wagonjwa', 'muda'])) {
            if ($isSwahili) {
                $answer = "Muda wa kuona wagonjwa hospitalini (Inpatient Visiting Hours) hapa {$hospitalName} - Sombetini (Ukumbi wa Diwani), Arusha ni:\n\n"
                    . "• **Siku za Kazi (Jumatatu - Ijumaa):**\n  - Asubuhi: 06:00 AM - 07:00 AM\n  - Mchana: 12:30 PM - 02:00 PM\n  - Jioni: 04:00 PM - 06:00 PM\n\n"
                    . "• **Mwisho wa Wiki & Sikukuu za Kitaifa:**\n  - Mchana: 12:00 PM - 02:00 PM\n\n"
                    . "Tafadhali zingatia kanuni za afya na usafi wa mikono unapotembelea wodi.";
            } else {
                $answer = "Inpatient ward visiting hours at {$hospitalName} (Sombetini, Ukumbi wa Diwani, Arusha) are:\n\n"
                    . "• **Weekdays (Monday - Friday):**\n  - Morning: 06:00 AM - 07:00 AM\n  - Afternoon: 12:30 PM - 02:00 PM\n  - Evening: 04:00 PM - 06:00 PM\n\n"
                    . "• **Weekends & Public Holidays:**\n  - Afternoon: 12:00 PM - 02:00 PM\n\n"
                    . "Please follow hospital hygiene protocols when visiting ward patients.";
            }
            $actions[] = ['label' => $isSwahili ? 'Mwongozo wa Wagonjwa' : 'Patient Guidelines', 'url' => route('patients')];
        }

        // 5. Insurance & Payment
        elseif (Str::contains($lower, ['insurance', 'nhif', 'nssf', 'jubilee', 'strategis', 'bima', 'malipo', 'payment', 'cost', 'gharama'])) {
            if ($isSwahili) {
                $answer = "{$hospitalName} inapokea mifumo mbalimbali ya bima za afya ikiwemo **NHIF, NSSF, Jubilee Insurance, Strategis, Assemble Insurance, na GA Insurance**.\n\nPia tunakubali malipo ya moja kwa moja kupitia fedha taslimu, kadi za benki (Visa/Mastercard), na mifumo ya malipo ya simu (M-Pesa, Airtel Money, Tigo Pesa).";
            } else {
                $answer = "{$hospitalName} accepts leading health insurance providers including **NHIF, NSSF, Jubilee Health Insurance, Strategis Insurance, Assemble, and GA Insurance**.\n\nWe also support self-pay patients via cash, debit/credit cards (Visa & Mastercard), and secure mobile payments.";
            }
            $actions[] = ['label' => $isSwahili ? 'Wasiliana na Idara ya Bima' : 'Inquire with Billing Desk', 'url' => route('contact.index')];
            $actions[] = ['label' => $isSwahili ? 'Weka Miadi' : 'Book Appointment', 'url' => route('appointments.create')];
        }

        // 6. Specific Doctor or Specialty search
        elseif (Str::contains($lower, ['doctor', 'cardiolog', 'surge', 'pediatr', 'gynaecol', 'orthoped', 'neurolog', 'dent', 'daktari', 'bingwa', 'moyo', 'upasuaji', 'watoto', 'mifupa'])) {
            $specialists = Doctor::where('is_active', true)->with('department')->take(4)->get();
            $docList = [];
            foreach ($specialists as $doc) {
                $deptName = $doc->department ? $doc->department->name : 'Specialist';
                $docList[] = "• **{$doc->name}** — {$doc->qualification} ({$deptName}) | *Schedule: {$doc->consultation_hours}*";
            }
            $listStr = implode("\n", $docList);

            if ($isSwahili) {
                $answer = "{$hospitalName} ina madaktari bingwa waliobobea katika fani mbalimbali za matibabu.\n\nBaadhi ya madaktari wetu:\n{$listStr}\n\nUnaweza kuangalia orodha nzima ya madaktari bingwa na ratiba zao za kliniki mtandaoni.";
            } else {
                $answer = "{$hospitalName} features accredited senior medical consultants and clinical faculty.\n\nSome of our specialists include:\n{$listStr}\n\nYou can view our complete faculty directory and book a consultation directly.";
            }
            $actions[] = ['label' => $isSwahili ? 'Tazama Madaktari Wote' : 'View All Specialists', 'url' => route('doctors.index')];
            $actions[] = ['label' => $isSwahili ? 'Weka Miadi' : 'Book Specialist Appointment', 'url' => route('appointments.create')];
        }

        // 7. Departments & Services
        elseif (Str::contains($lower, ['service', 'department', 'mri', 'ct scan', 'xray', 'x-ray', 'lab', 'huduma', 'kitengo', 'idara', 'vipimo', 'maabara', 'upasuaji', 'ultrasound'])) {
            $departments = Department::where('is_active', true)->take(6)->pluck('name_en')->implode(', ');
            if ($isSwahili) {
                $answer = "Idara na huduma za kliniki katika {$hospitalName} (Sombetini, Ukumbi wa Diwani, Arusha) zinajumuisha:\n\n• Uchunguzi wa Radiolojia (CT Scan, MRI, Ultrasound, Digital X-Ray)\n• Maabara ya kisasa ya Uchunguzi wa Damu na Vimelea\n• Upasuaji wa Kisasa (General & Specialized Surgery)\n• Huduma za Mama na Mtoto (Maternity & Pediatrics)\n• Kitengo cha Moyo, Figo na Magonjwa ya Ndani\n• Huduma za Dharura na ICU saa 24.";
            } else {
                $answer = "Clinical procedures and diagnostic departments at {$hospitalName} (Sombetini, Ukumbi wa Diwani, Arusha) include:\n\n• Advanced Diagnostic Imaging (CT Scan, MRI, Digital X-Ray, 4D Ultrasound)\n• Fully Automated Pathology & Clinical Laboratory\n• Inpatient Critical Care & Intensive Care Unit (ICU)\n• Specialized Surgeries & Orthopedics\n• Maternal, Neonatal & Pediatric Care\n• 24/7 Accident & Emergency Resuscitation.";
            }
            $actions[] = ['label' => $isSwahili ? 'Gundua Huduma Zote' : 'Explore All Services', 'url' => route('services.index')];
            $actions[] = ['label' => $isSwahili ? 'Idara za Hospitali' : 'Clinical Departments', 'url' => route('departments.index')];
        }

        // 8. General Health / FAQ / Greeting / Fallback
        else {
            if (Str::contains($lower, ['hi', 'hello', 'mambo', 'habari', 'hey', 'good morning', 'good afternoon', 'shikamoo'])) {
                if ($isSwahili) {
                    $answer = "Habari! Karibu **{$hospitalName}** (Sombetini, Ukumbi wa Diwani, Arusha). Mimi ni msaidizi wako wa akili bandia (Ephamarcy AI Assistant).\n\nNaweza kukusaidia kuhusu:\n• Kupata eneo la hospitali Sombetini (Ukumbi wa Diwani), Arusha\n• Ratiba za madaktari bingwa na kukata miadi\n• Huduma za dharura na namba za kupiga simu\n• Bima zinazokubaliwa na muda wa kutembelea wagonjwa\n\nUna swali gani nikusaidie leo?";
                } else {
                    $answer = "Hello! Welcome to **{$hospitalName}** in Sombetini, Ukumbi wa Diwani, Arusha. I am your AI Health & Hospital Concierge.\n\nI can assist you with:\n• Finding our hospital location in Sombetini (Ukumbi wa Diwani), Arusha\n• Finding medical specialists and booking consultations\n• 24/7 Emergency and ambulance hotline assistance\n• Visiting hours, insurance plans, and diagnostic services\n\nHow can I help you today?";
                }
            } else {
                if ($isSwahili) {
                    $answer = "Asante kwa swali lako kuhusu **\"{$query}\"**.\n\n{$hospitalName} inapatikana **Sombetini, Ukumbi wa Diwani, Arusha, Tanzania**, ikitoa huduma za matibabu ya ubingwa, uchunguzi wa kisasa wa maabara na radiolojia, na huduma za dharura saa 24/7.\n\nKwa ushauri wa moja kwa moja wa daktari au kuweka miadi ya kliniki, tafadhali tumia vitufe vifuatavyo:";
                } else {
                    $answer = "Thank you for asking about **\"{$query}\"**.\n\n{$hospitalName} is located at **Sombetini, Ukumbi wa Diwani, Arusha, Tanzania**, offering comprehensive tertiary clinical care, cutting-edge diagnostic facilities, and 24/7 emergency response.\n\nFor clinical consultations, immediate triage, or scheduling a visit, please use the quick links below:";
                }
            }

            $actions[] = ['label' => $isSwahili ? 'Weka Miadi ya Daktari' : 'Book a Doctor Appointment', 'url' => route('appointments.create')];
            $actions[] = ['label' => $isSwahili ? 'Huduma za Dharura 24/7' : '24/7 Emergency Line', 'url' => 'tel:' . preg_replace('/[^0-9+]/', '', $emergencyPhone)];
            $actions[] = ['label' => $isSwahili ? 'Mahali Tulipo (Ukumbi wa Diwani)' : 'Location (Ukumbi wa Diwani)', 'url' => 'https://maps.google.com/?q=Ukumbi+wa+Diwani,+Sombetini,+Arusha,+Tanzania', 'external' => true];
        }

        return response()->json([
            'success' => true,
            'query' => $query,
            'answer' => $answer,
            'actions' => $actions,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}

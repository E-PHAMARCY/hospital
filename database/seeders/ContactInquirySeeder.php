<?php

namespace Database\Seeders;

use App\Models\ContactInquiry;
use Illuminate\Database\Seeder;

class ContactInquirySeeder extends Seeder
{
    public function run(): void
    {
        $inquiries = [
            [
                'name' => 'Baraka Said Ally',
                'email' => 'baraka.said@example.com',
                'phone' => '+255 715 000 111',
                'subject' => 'Corporate Health Screening Inquiry',
                'message' => 'Greetings. We would like to inquire whether Ephamarcy Hospital provides on-site corporate annual executive wellness packages for corporate staff members.',
                'status' => 'new',
            ],
            [
                'name' => 'Hawa J. Mushi',
                'email' => 'hawa.mushi@example.com',
                'phone' => '+255 767 222 333',
                'subject' => 'Health Insurance Acceptance Details',
                'message' => 'Hello. I would like to confirm if your hospital accepts NHIF and Jubilee Health Insurance cards for specialist consultations and radiology imaging.',
                'status' => 'new',
            ],
        ];

        foreach ($inquiries as $inq) {
            ContactInquiry::updateOrCreate(['email' => $inq['email'], 'subject' => $inq['subject']], $inq);
        }
    }
}

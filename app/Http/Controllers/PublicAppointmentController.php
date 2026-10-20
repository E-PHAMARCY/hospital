<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicAppointmentController extends Controller
{
    public function create(): View
    {
        $departments = Department::where('is_active', true)->orderBy('name_en')->get();
        $doctors = Doctor::where('is_active', true)->with('department')->orderBy('name')->get();

        return view('appointments.create', compact('departments', 'doctors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'patient_name' => ['required', 'string', 'max:150'],
            'patient_email' => ['required', 'email', 'max:150'],
            'patient_phone' => ['required', 'string', 'max:30'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'string', 'max:50'],
            'reason' => ['required', 'string', 'max:1500'],
        ]);

        $reference = AppointmentRequest::generateReference();
        $validated['reference_number'] = $reference;
        $validated['status'] = 'pending';

        $appointment = AppointmentRequest::create($validated);

        // Record initial status in history
        $appointment->statusHistories()->create([
            'from_status' => 'new',
            'to_status' => 'pending',
            'note' => 'Initial online submission received by triage queue.',
        ]);

        return redirect()->route('appointments.confirmation', ['ref' => $reference])
            ->with('appointment_success', [
                'reference' => $reference,
                'name' => $validated['patient_name'],
                'date' => $validated['preferred_date'],
            ]);
    }

    public function confirmation(Request $request): View
    {
        $ref = $request->query('ref');
        $appointment = null;

        if ($ref) {
            $appointment = AppointmentRequest::where('reference_number', $ref)
                ->with(['department', 'doctor'])
                ->first();
        }

        return view('appointments.confirmation', compact('appointment', 'ref'));
    }

    public function track(Request $request): View
    {
        $ref = trim((string) $request->query('ref', ''));
        $appointment = null;

        if ($ref) {
            $appointment = AppointmentRequest::where('reference_number', $ref)
                ->with(['department', 'doctor', 'statusHistories'])
                ->first();
        }

        return view('appointments.track', compact('appointment', 'ref'));
    }
}


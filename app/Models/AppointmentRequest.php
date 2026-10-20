<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppointmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_number',
        'patient_name',
        'patient_email',
        'patient_phone',
        'department_id',
        'doctor_id',
        'preferred_date',
        'preferred_time',
        'reason',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(AppointmentStatusHistory::class, 'appointment_request_id')->latest();
    }

    public static function generateReference(): string
    {
        return 'APT-' . date('Y') . '-' . strtoupper(substr(uniqid(), -5));
    }
}

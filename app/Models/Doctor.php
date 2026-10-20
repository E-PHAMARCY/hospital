<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name',
        'qualification_en',
        'qualification_sw',
        'title_en',
        'title_sw',
        'biography_en',
        'biography_sw',
        'photo',
        'email',
        'phone',
        'consultation_days',
        'consultation_hours',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'consultation_days' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function appointmentRequests(): HasMany
    {
        return $this->hasMany(AppointmentRequest::class);
    }

    public function getQualificationAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->qualification_sw)) ? $this->qualification_sw : $this->qualification_en;
    }

    public function getTitleAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getBiographyAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->biography_sw)) ? $this->biography_sw : $this->biography_en;
    }
}

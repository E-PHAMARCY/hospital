<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_sw',
        'slug',
        'summary_en',
        'summary_sw',
        'description_en',
        'description_sw',
        'icon',
        'image',
        'phone',
        'email',
        'location',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class)->where('is_active', true)->orderBy('sort_order');
    }

    public function appointmentRequests(): HasMany
    {
        return $this->hasMany(AppointmentRequest::class);
    }

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->name_sw)) ? $this->name_sw : $this->name_en;
    }

    public function getSummaryAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->summary_sw)) ? $this->summary_sw : $this->summary_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->description_sw)) ? $this->description_sw : $this->description_en;
    }
}

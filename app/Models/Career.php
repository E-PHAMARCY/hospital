<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Career extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_sw',
        'slug',
        'department_id',
        'employment_type',
        'location',
        'description_en',
        'description_sw',
        'requirements_en',
        'requirements_sw',
        'deadline',
        'application_email',
        'is_active',
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->description_sw)) ? $this->description_sw : $this->description_en;
    }

    public function getRequirementsAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->requirements_sw)) ? $this->requirements_sw : $this->requirements_en;
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->is_active && $this->deadline->isFuture();
    }
}

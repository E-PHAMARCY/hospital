<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name_en',
        'name_sw',
        'slug',
        'summary_en',
        'summary_sw',
        'description_en',
        'description_sw',
        'icon',
        'color',
        'is_emergency',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_emergency' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
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

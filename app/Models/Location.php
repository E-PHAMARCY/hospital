<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_sw',
        'slug',
        'address_en',
        'address_sw',
        'phone',
        'email',
        'opening_hours_en',
        'opening_hours_sw',
        'google_map_url',
        'image',
        'description_en',
        'description_sw',
        'is_main',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getNameAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->name_sw)) ? $this->name_sw : $this->name_en;
    }

    public function getAddressAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->address_sw)) ? $this->address_sw : $this->address_en;
    }

    public function getDescriptionAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->description_sw)) ? $this->description_sw : $this->description_en;
    }

    public function getOpeningHoursAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->opening_hours_sw)) ? $this->opening_hours_sw : $this->opening_hours_en;
    }
}

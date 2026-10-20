<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadershipProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title_en',
        'title_sw',
        'role_category',
        'bio_en',
        'bio_sw',
        'photo',
        'email',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getBioAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->bio_sw)) ? $this->bio_sw : $this->bio_en;
    }
}

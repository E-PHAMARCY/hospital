<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_sw',
        'slug',
        'excerpt_en',
        'excerpt_sw',
        'content_en',
        'content_sw',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->content_sw)) ? $this->content_sw : $this->content_en;
    }
}

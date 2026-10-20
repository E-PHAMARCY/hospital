<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_sw',
        'slug',
        'category',
        'author_name',
        'excerpt_en',
        'excerpt_sw',
        'content_en',
        'content_sw',
        'featured_image',
        'disclaimer_en',
        'disclaimer_sw',
        'is_published',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getExcerptAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->excerpt_sw)) ? $this->excerpt_sw : $this->excerpt_en;
    }

    public function getContentAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->content_sw)) ? $this->content_sw : $this->content_en;
    }

    public function getDisclaimerAttribute(): ?string
    {
        $locale = app()->getLocale();
        $custom = ($locale === 'sw' && !empty($this->disclaimer_sw)) ? $this->disclaimer_sw : $this->disclaimer_en;
        if ($custom) {
            return $custom;
        }

        return $locale === 'sw' 
            ? 'Angalizo la Kimatibabu: Makala haya yanatolewa kwa madhumuni ya elimu ya afya pekee na hayachukui nafasi ya ushauri wa kitaalamu wa daktari. Wasiliana na mtaalamu wa afya kwa uchunguzi na matibabu sahihi.'
            : 'Medical Disclaimer: This health education content is provided for informational and educational purposes only and is not a substitute for professional clinical medical advice, diagnosis, or treatment.';
    }
}

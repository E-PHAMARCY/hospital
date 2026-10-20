<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title_en',
        'title_sw',
        'slug',
        'category',
        'excerpt_en',
        'excerpt_sw',
        'content_en',
        'content_sw',
        'featured_image',
        'published_at',
        'is_published',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
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

    public function getContentAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->content_sw)) ? $this->content_sw : $this->content_en;
    }

    public function getImageAttribute(): string
    {
        return $this->featured_image ? asset($this->featured_image) : asset('images/news_mri_diagnostic.jpg');
    }
}

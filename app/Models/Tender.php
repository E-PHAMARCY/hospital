<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_number',
        'title_en',
        'title_sw',
        'slug',
        'description_en',
        'description_sw',
        'document_path',
        'publication_date',
        'submission_deadline',
        'status',
    ];

    protected $casts = [
        'publication_date' => 'datetime',
        'submission_deadline' => 'datetime',
    ];

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

    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'open' && $this->submission_deadline->isFuture();
    }
}

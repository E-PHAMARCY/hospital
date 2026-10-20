<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_sw',
        'message_en',
        'message_sw',
        'type',
        'starts_at',
        'expires_at',
        'is_active',
        'action_url',
        'action_text_en',
        'action_text_sw',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function getTitleAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->title_sw)) ? $this->title_sw : $this->title_en;
    }

    public function getMessageAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->message_sw)) ? $this->message_sw : $this->message_en;
    }

    public function getActionTextAttribute(): ?string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->action_text_sw)) ? $this->action_text_sw : $this->action_text_en;
    }
}

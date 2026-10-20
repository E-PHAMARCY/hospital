<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_en',
        'question_sw',
        'answer_en',
        'answer_sw',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getQuestionAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->question_sw)) ? $this->question_sw : $this->question_en;
    }

    public function getAnswerAttribute(): string
    {
        $locale = app()->getLocale();
        return ($locale === 'sw' && !empty($this->answer_sw)) ? $this->answer_sw : $this->answer_en;
    }
}

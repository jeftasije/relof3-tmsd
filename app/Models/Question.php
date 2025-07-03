<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question','question_en','question_cy', 'answer', 'answer_en', 'answer_cy'];

    public function getQuestionAttribute()
    {
        $locale = app()->getLocale();

        return match($locale) {
            'sr-Cyrl' => $this->question_cy ?: $this->question,
            'en'      => $this->question_en ?: $this->question,
            default   => $this->attributes['question'],
        };
    }

    public function getAnswerAttribute()
    {
        $locale = app()->getLocale();

        return match($locale) {
            'sr-Cyrl' => $this->answer_cy ?: $this->answer,
            'en'      => $this->answer_en ?: $this->answer,
            default   => $this->attributes['answer'],
        };
    }

}

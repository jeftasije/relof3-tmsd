<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'message', 'message_en', 'message_cy', 'answer', 'answer_en', 'answer_cy'
    ];

    public function translate(string $field): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field;
        }

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }

    public function getTranslatedSubject(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            return $this->subject_en ?? $this->subject ?? '';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            return $this->subject_cy ?? $this->subject ?? '';
        }

        return $this->subject ?? '';
    }

    public function getTranslatedMessage(): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            return $this->message_en ?? $this->message ?? '';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            return $this->message_cy ?? $this->message ?? '';
        }

        return $this->message ?? '';
    }
}

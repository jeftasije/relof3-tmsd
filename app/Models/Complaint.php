<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'subject', 'subject_lat', 'subject_en', 'subject_cy', 'message', 'message_lat', 'message_en', 'message_cy', 'answer', 'answer_lat', 'answer_en', 'answer_cy'];

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'message', 'message_lat', 'message_en', 'message_cy', 'answer', 'answer_lat', 'answer_en', 'answer_cy'
    ];

    public function translate(string $field): string
    {
        $locale = app()->getLocale();

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field. '_lat';
        }

        return $this->{$fieldName} ?? $this->{$field} ?? '';
    }
}

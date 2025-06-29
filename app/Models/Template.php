<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'title',
        'title_en',
        'title_cy',
        'description',
        'description_en',
        'description_cy',
        'thumbnail',
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
}

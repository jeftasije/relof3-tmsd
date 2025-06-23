<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryDescription extends Model
{
    protected $fillable = ['key', 'value', 'value_en', 'value_cy',];

    public function translate(string $field, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        if ($locale === 'en') {
            $fieldName = $field . '_en';
        } elseif ($locale === 'sr-Cyrl' || $locale === 'cy') {
            $fieldName = $field . '_cy';
        } else {
            $fieldName = $field;
        }

        return $this->{$fieldName} ?? $this->{$field} ?? null;
    }
}

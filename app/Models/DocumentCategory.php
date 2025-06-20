<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'name_cy',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
    }

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
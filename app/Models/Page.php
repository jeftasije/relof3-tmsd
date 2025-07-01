<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'title_cy',
        'title_en',
        'slug',
        'template_id',
        'content',
        'content_cy',
        'content_en',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'content_cy' => 'array',
        'content_en' => 'array'
    ];
    
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function translate(string $field)
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
